# -*- coding: utf-8 -*-
"""
FILE: import_products_to_wp.py
MỤC ĐÍCH: Import toàn bộ 1.904 sản phẩm từ products.json lên WordPress (batdongsankhucongnghiep.vn)
LƯU Ý QUAN TRỌNG: CHỈ upload ảnh đã xóa logo nằm trong thư mục images-final/
TÍNH NĂNG:
  - Đa luồng (ThreadPoolExecutor) để tăng tốc độ upload và tạo bài
  - Đồng bộ bộ nhớ đệm wp_media_cache.json
  - Tracking tự động product_import_tracking.json (tránh trùng bài và có thể resume bất kỳ lúc nào)
"""

import os
import re
import sys
import json
import time
import base64
import mimetypes
import threading
import requests
from urllib.parse import urlparse
from concurrent.futures import ThreadPoolExecutor, as_completed

# Ép stdout flush ngay để log thời gian thực
sys.stdout.reconfigure(line_buffering=True)

WP_SITE_URL = "https://batdongsankhucongnghiep.vn"
WP_USERNAME = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

WP_POST_TYPE = "khu-cong-nghiep"
TEMPLATE_FILENAME = "single-product.php"

WP_CATEGORY_ID_KHO_XUONG = 59
WP_CATEGORY_ID_DAT_CONG_NGHIEP = 60

POST_STATUS = "publish"

PRODUCTS_JSON = "./products.json"
IMAGES_FINAL_DIR = "./images-final"
TRACKING_FILE = "./product_import_tracking.json"
MEDIA_CACHE_FILE = "./product_media_cache.json"
GLOBAL_CACHE_FILE = "./wp_media_cache.json"

OLD_TRACKING_PATH = r"C:\Users\ACER\Downloads\python\python\crawled-products\wp_import_tracking.json"

MAX_WORKERS = 4  # Số luồng song song hợp lý để không làm quá tải WordPress

cache_lock = threading.Lock()
tracking_lock = threading.Lock()

def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}"}

def load_media_cache():
    cache_dict = {}
    # Nạp từ GLOBAL_CACHE_FILE trước nếu có
    if os.path.exists(GLOBAL_CACHE_FILE):
        try:
            with open(GLOBAL_CACHE_FILE, "r", encoding="utf-8") as f:
                data = json.load(f)
                if isinstance(data, list):
                    for item in data:
                        url = item.get("source_url", "")
                        fname = url.split("/")[-1] if url else ""
                        if fname and "id" in item:
                            cache_dict[fname] = item
                elif isinstance(data, dict):
                    cache_dict.update(data)
        except Exception:
            pass

    # Sau đó ghi đè bằng cache riêng của sản phẩm nếu có
    if os.path.exists(MEDIA_CACHE_FILE):
        try:
            with open(MEDIA_CACHE_FILE, "r", encoding="utf-8") as f:
                data = json.load(f)
                if isinstance(data, list):
                    for item in data:
                        url = item.get("source_url", "")
                        fname = url.split("/")[-1] if url else ""
                        if fname and "id" in item:
                            cache_dict[fname] = item
                elif isinstance(data, dict):
                    cache_dict.update(data)
        except Exception as e:
            print(f"[Media Cache] Lỗi đọc cache: {e}")
    return cache_dict

def save_media_cache(cache_dict):
    cache_list = list(cache_dict.values())
    with open(MEDIA_CACHE_FILE, "w", encoding="utf-8") as f:
        json.dump(cache_list, f, ensure_ascii=False, indent=2)

def load_tracking():
    tracking = {}
    # Nạp từ file tracking cũ nếu có
    if os.path.exists(OLD_TRACKING_PATH):
        try:
            with open(OLD_TRACKING_PATH, "r", encoding="utf-8") as f:
                tracking.update(json.load(f))
        except Exception:
            pass

    # Nạp từ file tracking hiện tại
    if os.path.exists(TRACKING_FILE):
        try:
            with open(TRACKING_FILE, "r", encoding="utf-8") as f:
                tracking.update(json.load(f))
        except Exception:
            pass
    return tracking

def save_tracking(tracking):
    with open(TRACKING_FILE, "w", encoding="utf-8") as f:
        json.dump(tracking, f, ensure_ascii=False, indent=2)

def upload_image_if_clean(image_raw_path: str, media_cache: dict) -> dict:
    """CHỈ upload ảnh nếu file có mặt trong thư mục images-final (đã xóa logo)."""
    if not image_raw_path:
        return None

    filename = os.path.basename(image_raw_path.replace("\\", "/"))
    clean_path = os.path.join(IMAGES_FINAL_DIR, filename)

    # BẮT BUỘC: Chỉ upload nếu có trong images-final
    if not os.path.exists(clean_path):
        return None

    with cache_lock:
        if filename in media_cache:
            return media_cache[filename]

    headers = get_auth_header()
    content_type = mimetypes.guess_type(filename)[0] or "image/jpeg"

    for attempt in range(2):
        try:
            with open(clean_path, "rb") as f:
                file_data = f.read()

            upload_headers = dict(headers)
            upload_headers["Content-Disposition"] = f'attachment; filename="{filename}"'
            upload_headers["Content-Type"] = content_type

            resp = requests.post(
                f"{WP_SITE_URL}/wp-json/wp/v2/media",
                headers=upload_headers,
                data=file_data,
                timeout=45
            )
            if resp.status_code == 201:
                data = resp.json()
                res = {"id": data["id"], "slug": data.get("slug", ""), "source_url": data["source_url"]}
                with cache_lock:
                    media_cache[filename] = res
                return res
            elif resp.status_code == 400 and "already exists" in resp.text.lower():
                # Có thể ảnh đã tồn tại trên Media Library
                break
            else:
                time.sleep(1)
        except Exception:
            time.sleep(2)

    return None

def guess_category_id(product: dict) -> int:
    text = (product.get("loai_hinh", "") + " " + product.get("title", "")).lower()
    if "đất" in text or "dat" in text:
        return WP_CATEGORY_ID_DAT_CONG_NGHIEP
    return WP_CATEGORY_ID_KHO_XUONG

def process_single_product(index: int, total: int, product: dict, media_cache: dict, tracking: dict) -> bool:
    url = product.get("url", "").strip()
    title = product.get("title", "(Không có tiêu đề)").strip()

    if not url:
        return False

    headers = get_auth_header()

    # 1. Thu thập và upload ảnh sạch từ images-final
    images_raw = product.get("images", [])
    media_ids = []

    for img_p in images_raw:
        res = upload_image_if_clean(img_p, media_cache)
        if res and res.get("id"):
            media_ids.append(res["id"])

    featured_media_id = media_ids[0] if media_ids else None
    gallery_str = ",".join(str(mid) for mid in media_ids)

    # 2. Xây dựng ACF payload
    acf_payload = {
        "ma_tin": product.get("ma_tin", ""),
        "loai_hinh": product.get("loai_hinh", ""),
        "khu_vuc": product.get("khu_vuc", ""),
        "dien_tich": product.get("dien_tich", ""),
        "gia": product.get("gia", ""),
        "mo_ta_chi_tiet": product.get("mo_ta_chi_tiet", ""),
        "tien_ich": "\n".join(product.get("tien_ich", [])),
        "lat": product.get("lat") or "",
        "lng": product.get("lng") or "",
        "url_nguon": url,
        "gallery_anh": media_ids,
    }

    # Meta bổ sung
    meta_payload = {
        "_kcn_gallery_ids": gallery_str,
        "loai_hinh": product.get("loai_hinh", ""),
        "ma_tin": product.get("ma_tin", ""),
        "gia": product.get("gia", ""),
        "dien_tich": product.get("dien_tich", ""),
        "khu_vuc": product.get("khu_vuc", ""),
    }

    category_id = guess_category_id(product)
    slug = urlparse(url).path.strip("/").split("/")[-1]

    # Kiểm tra xem bài đã tồn tại trong tracking chưa
    existing_id = tracking.get(url)

    if existing_id:
        # CẬP NHẬT bài đã có để đảm bảo có ảnh sạch mới và thông tin chuẩn
        endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/{WP_POST_TYPE}/{existing_id}"
        payload = {
            "acf": acf_payload,
            "meta": meta_payload,
            "template": TEMPLATE_FILENAME,
            "categories": [category_id],
        }
        if featured_media_id:
            payload["featured_media"] = featured_media_id

        try:
            resp = requests.post(endpoint, headers=headers, json=payload, timeout=30)
            if resp.status_code in (200, 201):
                print(f"[{index}/{total}] 🔄 Đã cập nhật SP: {title[:42]}... (ID: {existing_id})")
                return True
            elif resp.status_code == 404:
                # Nếu ID không còn tồn tại trên WP -> tạo mới
                existing_id = None
            else:
                print(f"[{index}/{total}] ⚠️ Lỗi cập nhật (ID {existing_id}): {resp.status_code}")
                return False
        except Exception as e:
            print(f"[{index}/{total}] ⚠️ Exception cập nhật: {e}")
            return False

    if not existing_id:
        # TẠO MỚI bài viết
        endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/{WP_POST_TYPE}"
        payload = {
            "title": title,
            "status": POST_STATUS,
            "template": TEMPLATE_FILENAME,
            "categories": [category_id],
            "acf": acf_payload,
            "meta": meta_payload,
        }
        if slug:
            payload["slug"] = slug
        if featured_media_id:
            payload["featured_media"] = featured_media_id

        try:
            resp = requests.post(endpoint, headers=headers, json=payload, timeout=35)
            if resp.status_code in (200, 201):
                post_id = resp.json()["id"]
                with tracking_lock:
                    tracking[url] = post_id
                print(f"[{index}/{total}] ✅ Đã tạo mới SP: {title[:42]}... (ID: {post_id})")
                return True
            elif resp.status_code == 400:
                # Thử lại nếu WordPress chưa nhận template
                payload.pop("template", None)
                resp2 = requests.post(endpoint, headers=headers, json=payload, timeout=35)
                if resp2.status_code in (200, 201):
                    post_id = resp2.json()["id"]
                    with tracking_lock:
                        tracking[url] = post_id
                    print(f"[{index}/{total}] ✅ Đã tạo mới SP (ko template param): {title[:42]}... (ID: {post_id})")
                    return True
                else:
                    print(f"[{index}/{total}] ❌ Lỗi 400: {resp2.text[:200]}")
                    return False
            else:
                print(f"[{index}/{total}] ❌ Lỗi {resp.status_code}: {resp.text[:200]}")
                return False
        except Exception as e:
            print(f"[{index}/{total}] ❌ Exception tạo mới: {e}")
            return False

def main():
    if not os.path.exists(PRODUCTS_JSON):
        print(f"[Lỗi] Không tìm thấy file {PRODUCTS_JSON}")
        return

    with open(PRODUCTS_JSON, "r", encoding="utf-8") as f:
        products = json.load(f)

    media_cache = load_media_cache()
    tracking = load_tracking()

    print(f"=== BẮT ĐẦU IMPORT {len(products)} SẢN PHẨM ===")
    print(f"- Thư mục ảnh sạch: {IMAGES_FINAL_DIR} ({len(os.listdir(IMAGES_FINAL_DIR))} files)")
    print(f"- Đã tracking trước đó: {len(tracking)} sản phẩm")
    print(f"- Bộ nhớ đệm ảnh: {len(media_cache)} media")
    print(f"- Số luồng xử lý song song: {MAX_WORKERS}")

    total = len(products)
    completed = 0
    success_count = 0
    save_counter = 0

    with ThreadPoolExecutor(max_workers=MAX_WORKERS) as executor:
        futures = []
        for i, p in enumerate(products, 1):
            futures.append(executor.submit(process_single_product, i, total, p, media_cache, tracking))

        for fut in as_completed(futures):
            completed += 1
            save_counter += 1
            try:
                ok = fut.result()
                if ok:
                    success_count += 1
            except Exception as e:
                print(f"[Worker Error] {e}")

            # Lưu định kỳ mỗi 15 sản phẩm để tránh mất dữ liệu
            if save_counter >= 15:
                save_counter = 0
                with tracking_lock:
                    save_tracking(tracking)
                with cache_lock:
                    save_media_cache(media_cache)

    # Lưu lần cuối
    with tracking_lock:
        save_tracking(tracking)
    with cache_lock:
        save_media_cache(media_cache)

    print("\n=== HOÀN TẤT IMPORT SẢN PHẨM ===")
    print(f"- Tổng số sản phẩm: {total}")
    print(f"- Thành công: {success_count}")

if __name__ == "__main__":
    main()
