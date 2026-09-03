# -*- coding: utf-8 -*-
"""
FILE: import_kcn_to_wp.py
MỤC ĐÍCH: Import toàn bộ Khu Công Nghiệp từ kcn_list.json lên WordPress (batdongsankhucongnghiep.vn)
qua WordPress REST API.

TÍNH NĂNG:
    - Tự động tìm và upload ảnh từ thư mục images-final/ lên WP Media Library.
    - Ảnh đầu tiên -> Gán làm Featured Image (Ảnh đại diện).
    - Toàn bộ ảnh còn lại (không giới hạn số lượng) -> Gán vào Thư viện ảnh (_kcn_gallery_ids).
    - Lưu đầy đủ thông tin ACF: giá thuê, diện tích, chủ đầu tư, hạ tầng, ưu đãi, v.v.
    - Có cơ chế Tracking (kcn_import_tracking.json): tự lưu tiến độ, nếu mất mạng hoặc
      dừng script thì chạy lại sẽ tiếp tục từ bài tiếp theo, KHÔNG bị tạo trùng bài.
    - Cache ảnh đã upload: tránh upload lại cùng 1 file ảnh nhiều lần.

CÀI ĐẶT THƯ VIỆN:
    pip install requests

CÁCH CHẠY:
    python import_kcn_to_wp.py
"""

import os
import json
import base64
import mimetypes
import requests
from urllib.parse import urlparse

# ============================================================
# CẤU HÌNH (CONFIG)
# ============================================================

WP_SITE_URL     = "https://batdongsankhucongnghiep.vn"
WP_USERNAME     = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

# Custom Post Type cho KCN
WP_POST_TYPE    = "khu-cong-nghiep"

# Template hiển thị
TEMPLATE_FILENAME = "single-khu-cong-nghiep.php"

# Trạng thái bài viết khi tạo: 'publish' (công khai) hoặc 'draft' (nháp)
POST_STATUS     = "publish"

# File dữ liệu KCN
KCN_JSON_PATH   = "./kcn_list.json"

# Các thư mục tìm ảnh (tìm lần lượt theo thứ tự)
IMAGE_SEARCH_DIRS = [
    "./images-final",
    r"C:\Users\ACER\Downloads\Anxemer\images-final",
    r"C:\Users\ACER\Downloads\python\python\crawled-kcn\images-final",
]

# File ghi nhớ tiến độ
TRACKING_FILE   = "./kcn_import_tracking.json"
MEDIA_CACHE_FILE = "./kcn_media_cache.json"

# ============================================================
# TỈNH THÀNH TRA CỨU TỰ ĐỘNG
# ============================================================
PROVINCE_MAP = {
    'long-an': 'Long An', 'binh-duong': 'Bình Dương', 'dong-nai': 'Đồng Nai',
    'ba-ria': 'Bà Rịa - Vũng Tàu', 'vung-tau': 'Bà Rịa - Vũng Tàu',
    'bac-ninh': 'Bắc Ninh', 'hai-phong': 'Hải Phòng', 'ha-noi': 'Hà Nội',
    'ho-chi-minh': 'TP. Hồ Chí Minh', 'quang-ninh': 'Quảng Ninh',
    'thai-nguyen': 'Thái Nguyên', 'vinh-phuc': 'Vĩnh Phúc', 'bac-giang': 'Bắc Giang',
    'hai-duong': 'Hải Dương', 'phu-tho': 'Phú Thọ', 'nghe-an': 'Nghệ An',
    'ha-tinh': 'Hà Tĩnh', 'quang-tri': 'Quảng Trị', 'da-nang': 'Đà Nẵng',
    'quang-nam': 'Quảng Nam', 'binh-dinh': 'Bình Định', 'khanh-hoa': 'Khánh Hòa',
    'lam-dong': 'Lâm Đồng', 'binh-phuoc': 'Bình Phước', 'tay-ninh': 'Tây Ninh',
    'tien-giang': 'Tiền Giang', 'can-tho': 'Cần Thơ', 'kien-giang': 'Kiên Giang',
    'an-giang': 'An Giang', 'nam-dinh': 'Nam Định', 'thai-binh': 'Thái Bình',
    'thanh-hoa': 'Thanh Hóa', 'ninh-binh': 'Ninh Bình', 'hoa-binh': 'Hòa Bình',
    'quang-ngai': 'Quảng Ngãi', 'hung-yen': 'Hưng Yên', 'hue': 'Thừa Thiên Huế',
    'thua-thien': 'Thừa Thiên Huế', 'binh-thuan': 'Bình Thuận', 'phu-yen': 'Phú Yên',
    'ninh-thuan': 'Ninh Thuận', 'dak-lak': 'Đắk Lắk', 'gia-lai': 'Gia Lai',
}

def guess_province(title: str, url: str) -> str:
    hay = (url + " " + title).lower()
    for k, v in PROVINCE_MAP.items():
        if k in hay:
            return v
    return ""

def get_slug_from_url(url: str, title: str) -> str:
    path = urlparse(url).path.strip("/")
    if path:
        parts = path.split("/")
        slug = parts[-1]
        if slug and slug != "khu-cong-nghiep":
            return slug
    # Fallback từ title
    return "".join(c if c.isalnum() else "-" for c in title.lower()).strip("-")

# ============================================================
# CÁC HÀM XỬ LÝ REST API WORDPRESS
# ============================================================

def get_auth_header() -> dict:
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}"}

def load_json_file(file_path: str) -> dict:
    if os.path.exists(file_path):
        try:
            with open(file_path, "r", encoding="utf-8") as f:
                return json.load(f)
        except Exception:
            return {}
    return {}

def save_json_file(file_path: str, data: dict):
    with open(file_path, "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=2)

def find_image_file(raw_path: str) -> str:
    """Tìm file ảnh thực tế trên máy tính từ đường dẫn trong JSON."""
    raw_path = raw_path.replace("\\", "/")
    basename = os.path.basename(raw_path)

    # 1. Thử trực tiếp đường dẫn ghi trong JSON
    if os.path.exists(raw_path):
        return raw_path

    # 2. Thử trong các thư mục định sẵn
    for d in IMAGE_SEARCH_DIRS:
        candidate = os.path.join(d, basename)
        if os.path.exists(candidate):
            return candidate

    return ""

def upload_image(image_path: str, media_cache: dict) -> dict:
    """Upload 1 ảnh lên WP Media Library (hoặc dùng cache nếu đã upload rồi)."""
    filename = os.path.basename(image_path)

    # Kiểm tra cache
    if filename in media_cache:
        return media_cache[filename]

    headers = get_auth_header()
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
    data = resp.json()
    res = {"id": data["id"], "source_url": data["source_url"]}

    # Lưu cache
    media_cache[filename] = res
    save_json_file(MEDIA_CACHE_FILE, media_cache)
    return res

def create_kcn_post(item: dict, media_ids: list, featured_media_id) -> dict:
    """Tạo hoặc cập nhật bài KCN trên WordPress qua REST API."""
    headers = get_auth_header()
    title = item.get("title", "").strip()
    url = item.get("url", "").strip()
    slug = get_slug_from_url(url, title)

    # Dữ liệu fields (nếu crawl có)
    fields = {}
    fields.update(item.get("acf", {}) or {})
    fields.update(item.get("fields_detected", {}) or {})

    tinh_thanh = fields.get("tinh_thanh") or fields.get("khu_vuc") or guess_province(title, url)
    gia = fields.get("gia") or fields.get("gia_thue") or "Liên hệ báo giá"
    dien_tich = fields.get("dien_tich") or ""
    mo_ta_html = item.get("mo_ta_html") or ""
    mo_ta_text = item.get("mo_ta_text") or fields.get("mo_ta_chi_tiet") or ""

    # Chuỗi ID thư viện ảnh (tất cả ảnh phụ)
    extra_gallery_ids_str = ",".join(str(mid) for mid in media_ids if mid != featured_media_id)

    # ACF Fields
    acf_payload = {
        "vi_tri": fields.get("vi_tri") or tinh_thanh,
        "tinh_thanh": tinh_thanh,
        "trang_thai": fields.get("trang_thai") or "ĐANG HOẠT ĐỘNG",
        "gia_thue": gia,
        "don_vi_tinh": fields.get("don_vi_tinh") or "Giá tham khảo",
        "chu_dau_tu": fields.get("chu_dau_tu") or "",
        "dien_tich": dien_tich,
        "ty_le_lap_day": fields.get("ty_le_lap_day") or "",
        "nganh_nghe_thu_hut": fields.get("nganh_nghe_thu_hut") or fields.get("nganh_nghe") or "",
        "ht_dien": fields.get("ht_dien") or "",
        "ht_nuoc_sach": fields.get("ht_nuoc_sach") or "",
        "ht_nuoc_thai": fields.get("ht_nuoc_thai") or "",
        "ht_vien_thong": fields.get("ht_vien_thong") or "",
        "ht_duong_bo": fields.get("ht_duong_bo") or "",
        "ht_duong_thuy": fields.get("ht_duong_thuy") or "",
        "phi_quan_ly": fields.get("phi_quan_ly") or "",
        "gia_dien": fields.get("gia_dien") or "",
        "gia_nuoc": fields.get("gia_nuoc") or "",
        "phi_xuly_nuocthai": fields.get("phi_xuly_nuocthai") or "",
        "uu_dai_thue": fields.get("uu_dai_thue") or "",
        "mo_ta_chi_tiet": mo_ta_text,
        "google_map_embed": fields.get("google_map_embed") or "",
        "hotline": "0909 161 824",
        "link_zalo": "https://zalo.me/0909161824",
    }

    # Meta payload (gồm _kcn_gallery_ids cho Metabox Native)
    meta_payload = {
        "_kcn_gallery_ids": extra_gallery_ids_str,
        "vi_tri": fields.get("vi_tri") or tinh_thanh,
        "gia_thue": gia,
        "dien_tich": dien_tich,
    }

    payload = {
        "title": title,
        "slug": slug,
        "status": POST_STATUS,
        "content": mo_ta_html or mo_ta_text,
        "template": TEMPLATE_FILENAME,
        "acf": acf_payload,
        "meta": meta_payload,
    }

    if featured_media_id:
        payload["featured_media"] = featured_media_id

    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/{WP_POST_TYPE}"
    resp = requests.post(endpoint, headers=headers, json=payload, timeout=35)

    # Fallback nếu WordPress chưa chấp nhận thuộc tính template
    if resp.status_code == 400 and "template" in resp.text:
        payload.pop("template", None)
        resp = requests.post(endpoint, headers=headers, json=payload, timeout=35)

    resp.raise_for_status()
    return resp.json()

# ============================================================
# HÀM CHÍNH
# ============================================================

def main():
    if not os.path.exists(KCN_JSON_PATH):
        print(f"❌ Không tìm thấy file dữ liệu: {KCN_JSON_PATH}")
        return

    with open(KCN_JSON_PATH, "r", encoding="utf-8") as f:
        items = json.load(f)

    tracking = load_json_file(TRACKING_FILE)
    media_cache = load_json_file(MEDIA_CACHE_FILE)

    total = len(items)
    print("=" * 65)
    print(f"🚀 BẮT ĐẦU IMPORT {total} KCN LÊN WORDPRESS ({WP_SITE_URL})")
    print(f"   Trạng thái: {POST_STATUS.upper()} | Post Type: {WP_POST_TYPE}")
    print("=" * 65)

    success_count = 0
    skip_count = 0
    error_count = 0

    for idx, item in enumerate(items, 1):
        url = item.get("url", "").strip()
        title = item.get("title", "").strip()

        if not title:
            skip_count += 1
            continue

        print(f"\n[{idx}/{total}] 🏢 {title}")

        # Kiểm tra đã import trước đó chưa
        if url and url in tracking:
            print(f"   [Bỏ qua] Đã import trước đó (Post ID: {tracking[url]})")
            skip_count += 1
            continue

        images = item.get("images", []) or []
        uploaded_media_ids = []
        featured_media_id = None

        # Upload toàn bộ ảnh của sản phẩm
        for img_idx, raw_img_path in enumerate(images):
            real_img_path = find_image_file(raw_img_path)
            if not real_img_path:
                print(f"   ⚠️ Không tìm thấy ảnh: {os.path.basename(raw_img_path)}")
                continue

            try:
                media_info = upload_image(real_img_path, media_cache)
                m_id = media_info["id"]
                uploaded_media_ids.append(m_id)

                if img_idx == 0:
                    featured_media_id = m_id
                    print(f"   📷 Featured Image: {os.path.basename(real_img_path)} (ID {m_id})")
                else:
                    print(f"   🖼️ Gallery #{img_idx+1}: {os.path.basename(real_img_path)} (ID {m_id})")
            except Exception as e:
                print(f"   ❌ Lỗi upload {os.path.basename(real_img_path)}: {e}")

        # Tạo bài viết KCN
        try:
            post = create_kcn_post(item, uploaded_media_ids, featured_media_id)
            post_id = post.get("id")
            post_link = post.get("link", "")
            print(f"   ✅ Đã tạo thành công: {post_link} (ID: {post_id})")

            # Lưu tracking ngay lập tức để không mất tiến độ
            if url:
                tracking[url] = post_id
            else:
                tracking[f"item_{idx}"] = post_id
            save_json_file(TRACKING_FILE, tracking)

            success_count += 1
        except Exception as e:
            print(f"   ❌ Lỗi tạo bài viết '{title}': {e}")
            error_count += 1

    print("\n" + "=" * 65)
    print("🎉 HOÀN THÀNH QUÁ TRÌNH IMPORT!")
    print(f"   ✅ Thành công: {success_count}")
    print(f"   ⏭️ Bỏ qua (đã có): {skip_count}")
    print(f"   ❌ Gặp lỗi: {error_count}")
    print("=" * 65)

if __name__ == "__main__":
    main()
