# -*- coding: utf-8 -*-
"""
Import toàn bộ sản phẩm trong crawled-products/products.json lên bds24h (WordPress),
tự động: upload từng ảnh lên Media Library, điền đúng field ACF, tạo bài ở trạng
thái DRAFT (nháp — kiểm tra lại trước khi công khai).

TRƯỚC KHI CHẠY:
    1. Đã import file acf-bds-cong-nghiep-fields-simplified.json vào ACF trên bds24h
       (xem lại hướng dẫn import ACF trước đó).
    2. Tạo Application Password bên wp-admin bds24h:
       Users -> Profile -> Application Passwords -> đặt tên bất kỳ -> Add New
       -> COPY NGAY chuỗi hiện ra (chỉ hiện 1 lần).
    3. Điền WP_USERNAME, WP_APP_PASSWORD bên dưới (hoặc đặt qua biến môi trường,
       AN TOÀN HƠN — xem hướng dẫn cuối file).

CÀI ĐẶT: pip install requests (đã có sẵn nếu chạy chung với crawl_process_gptimage.py)

CÁCH DÙNG:
    python import_to_wp.py
"""

import requests
import json
import os
import base64
import mimetypes

# ================== CONFIG ==================

WP_SITE_URL = "https://batdongsankhucongnghiep.vn"  # domain thật đã xác nhận
WP_USERNAME = os.environ.get("WP_USERNAME", "admin")       # <-- THAY hoặc dùng biến môi trường
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")  # <-- THAY

# Loại nội dung đích: theo xác nhận qua /wp-json/, route thật là "khu-cong-nghiep"
# (KHÔNG có "s" ở cuối) — đây là CPT DÙNG CHUNG cho cả sản phẩm lẫn khu công nghiệp,
# phân biệt bằng CATEGORY (kho-xuong / dat-cong-nghiep), không phải bằng post type khác.
WP_POST_TYPE = "khu-cong-nghiep"

# Tên file template PHP (đã sửa, khớp field ACF) cần GÁN CHO TỪNG BÀI — vì CPT này có
# thể có nhiều mẫu hiển thị khác nhau (single-khu-cong-nghiep.php là mặc định tự động
# áp dụng cho MỌI bài thuộc CPT này, còn single-product.php là mẫu CHỌN TAY riêng cho
# sản phẩm). Cần trỏ đúng để bài sản phẩm hiển thị bằng đúng giao diện sản phẩm.
TEMPLATE_FILENAME = "single-product.php"

# ID category "Kho Xưởng" và "Đất Công Nghiệp" bên bds24h — vào wp-admin → Posts →
# Categories để lấy đúng ID (trỏ chuột vào tên category, xem số "tag_ID=" trên URL).
WP_CATEGORY_ID_KHO_XUONG = 59       # <-- ĐIỀN SỐ THẬT
WP_CATEGORY_ID_DAT_CONG_NGHIEP = 60  # <-- ĐIỀN SỐ THẬT

POST_STATUS = "draft"  # giữ "draft" để kiểm tra lại trước khi công khai

PRODUCTS_JSON = "./crawled-products/products.json"
IMPORT_TRACKING_FILE = "./crawled-products/wp_import_tracking.json"

# ================== HẾT CONFIG ==================


def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}"}


def load_tracking() -> dict:
    """Theo dõi sản phẩm nào ĐÃ import rồi (theo url) -> tránh tạo trùng bài khi
    chạy lại/resume."""
    if os.path.exists(IMPORT_TRACKING_FILE):
        with open(IMPORT_TRACKING_FILE, "r", encoding="utf-8") as f:
            return json.load(f)
    return {}


def save_tracking(tracking: dict):
    with open(IMPORT_TRACKING_FILE, "w", encoding="utf-8") as f:
        json.dump(tracking, f, ensure_ascii=False, indent=2)


def upload_image(image_path: str) -> dict:
    """Upload 1 ảnh lên Media Library của WordPress, trả về {'id':..., 'source_url':...}."""
    headers = get_auth_header()
    filename = os.path.basename(image_path)
    content_type = mimetypes.guess_type(filename)[0] or "image/jpeg"

    with open(image_path, "rb") as f:
        file_data = f.read()

    upload_headers = dict(headers)
    upload_headers["Content-Disposition"] = f'attachment; filename="{filename}"'
    upload_headers["Content-Type"] = content_type

    resp = requests.post(
        f"{WP_SITE_URL}/wp-json/wp/v2/media",
        headers=upload_headers,
        data=file_data,
        timeout=60,
    )
    resp.raise_for_status()
    media = resp.json()
    return {"id": media["id"], "source_url": media["source_url"]}


def guess_category_id(product: dict):
    """Tự chọn category Kho Xưởng hay Đất Công Nghiệp dựa theo nội dung field
    'loai_hinh'/'title' — vì cả 2 loại đều dùng chung 1 CPT, phân biệt qua category."""
    text = (product.get("loai_hinh", "") + " " + product.get("title", "")).lower()
    if "đất" in text or "dat" in text:
        return WP_CATEGORY_ID_DAT_CONG_NGHIEP
    return WP_CATEGORY_ID_KHO_XUONG


def create_post(product: dict, media_ids: list, featured_media_id) -> dict:
    headers = get_auth_header()

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
        "url_nguon": product.get("url", ""),
        "gallery_anh": media_ids,
    }

    payload = {
        "title": product.get("title", "(Không có tiêu đề)"),
        "status": POST_STATUS,
        "acf": acf_payload,
        "template": TEMPLATE_FILENAME,  # gán đúng giao diện hiển thị sản phẩm
    }
    if featured_media_id:
        payload["featured_media"] = featured_media_id

    category_id = guess_category_id(product)
    if category_id:
        payload["categories"] = [category_id]

    # Route CPT đã xác nhận qua /wp-json/: KHÔNG thêm "s", dùng đúng tên thật
    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/{WP_POST_TYPE}"

    resp = requests.post(endpoint, headers=headers, json=payload, timeout=30)

    # Nếu lỗi 400 (Bad Request) — có thể do "template" chưa được WordPress công nhận
    # (file .php chưa upload lên theme) -> thử lại KHÔNG kèm template, để không bị
    # chặn hoàn toàn việc tạo bài. Bạn có thể tự gán template sau qua wp-admin.
    if resp.status_code == 400:
        print(f"    [Cảnh báo] Lỗi 400 khi tạo bài (kèm template). Chi tiết từ WordPress: {resp.text[:300]}")
        print("    -> Thử lại KHÔNG kèm template...")
        payload.pop("template", None)
        resp = requests.post(endpoint, headers=headers, json=payload, timeout=30)
        if resp.status_code == 400:
            print(f"    [Vẫn lỗi 400 sau khi bỏ template] Chi tiết: {resp.text[:300]}")

    resp.raise_for_status()
    return resp.json()


def main():
    with open(PRODUCTS_JSON, "r", encoding="utf-8") as f:
        products = json.load(f)

    tracking = load_tracking()

    print(f"Chuẩn bị import {len(products)} sản phẩm lên {WP_SITE_URL} (trạng thái: {POST_STATUS})...")

    success_count = 0
    skip_count = 0
    error_count = 0

    for i, product in enumerate(products, 1):
        url = product.get("url", "")
        title = product.get("title", "")
        print(f"\n[{i}/{len(products)}] {title}")

        if url in tracking:
            print(f"  [Bỏ qua] Đã import trước đó (post ID {tracking[url]}).")
            skip_count += 1
            continue

        images = product.get("images", [])
        media_ids = []
        featured_media_id = None

        for idx, img_path in enumerate(images):
            if not os.path.exists(img_path):
                print(f"    [Cảnh báo] Không tìm thấy file ảnh: {img_path} — bỏ qua ảnh này.")
                continue
            try:
                uploaded = upload_image(img_path)
                media_ids.append(uploaded["id"])
                if idx == 0:
                    featured_media_id = uploaded["id"]
                print(f"    Đã upload: {uploaded['source_url']}")
            except Exception as e:
                print(f"    [Lỗi upload ảnh] {img_path}: {e}")

        try:
            post = create_post(product, media_ids, featured_media_id)
            post_id = post.get("id")
            post_link = post.get("link", "")
            print(f"  Đã tạo draft: {post_link} (ID {post_id})")
            tracking[url] = post_id
            save_tracking(tracking)  # lưu ngay, phòng script bị dừng giữa chừng
            success_count += 1
        except Exception as e:
            print(f"  [Lỗi tạo bài] {title}: {e}")
            error_count += 1

    print(f"\n=== HOÀN TẤT ===")
    print(f"Thành công: {success_count}")
    print(f"Bỏ qua (đã import trước đó): {skip_count}")
    print(f"Lỗi: {error_count}")


if __name__ == "__main__":
    main()