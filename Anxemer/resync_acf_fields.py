# -*- coding: utf-8 -*-
"""
Ghi (PATCH) lại field ACF cho TOÀN BỘ bài đã tạo trước đó — dùng khi bài + ảnh
đã đúng (đã tạo/upload thành công) nhưng field ACF bị rỗng, ví dụ do lúc tạo
bài có 2 field group cùng áp dụng cho CPT khiến ACF REST API ghi nhầm/không
ghi được (xem lại: đã tắt/xóa field group cũ, CHỈ còn 1 field group áp dụng
cho khu-cong-nghiep, trước khi chạy script này).

Không tạo bài mới, không upload lại ảnh — chỉ PATCH field "acf" cho từng
post_id đã có trong wp_import_tracking.json.

CÁCH DÙNG:
    python resync_acf_fields.py
"""

import requests
import json
import os
import base64

# ================== CONFIG (giống import_to_wp.py) ==================

WP_SITE_URL = "https://batdongsankhucongnghiep.vn"
WP_USERNAME = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

WP_POST_TYPE = "khu-cong-nghiep"

PRODUCTS_JSON = "./crawled-products/products.json"
IMPORT_TRACKING_FILE = "./crawled-products/wp_import_tracking.json"

# ================== HẾT CONFIG ==================


def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}"}


def build_acf_payload(product: dict) -> dict:
    return {
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
    }


def patch_acf(post_id: int, acf_payload: dict) -> dict:
    headers = get_auth_header()
    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/{WP_POST_TYPE}/{post_id}"
    resp = requests.post(endpoint, headers=headers, json={"acf": acf_payload}, timeout=30)
    resp.raise_for_status()
    return resp.json()


def verify_acf_saved(post_id: int, expected: dict) -> bool:
    """Đọc lại bài vừa PATCH, kiểm tra field 'gia' (đại diện) đã có giá trị
    đúng như mong đợi chưa — để phát hiện sớm nếu vẫn còn bị field group
    trùng gây ghi nhầm."""
    headers = get_auth_header()
    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/{WP_POST_TYPE}/{post_id}"
    resp = requests.get(endpoint, headers=headers, timeout=30)
    resp.raise_for_status()
    data = resp.json()
    acf = data.get("acf", {}) or {}
    return acf.get("gia", "") == expected.get("gia", "")


def main():
    with open(PRODUCTS_JSON, "r", encoding="utf-8") as f:
        products = json.load(f)
    products_by_url = {p.get("url", ""): p for p in products}

    if not os.path.exists(IMPORT_TRACKING_FILE):
        print(f"[Lỗi] Không tìm thấy {IMPORT_TRACKING_FILE} — không biết url nào ứng với post_id nào.")
        return

    with open(IMPORT_TRACKING_FILE, "r", encoding="utf-8") as f:
        tracking = json.load(f)  # {url: post_id}

    print(f"Có {len(tracking)} bài đã tracking. Bắt đầu resync ACF...\n")

    success_count = 0
    mismatch_count = 0
    error_count = 0
    not_found_count = 0

    for url, post_id in tracking.items():
        product = products_by_url.get(url)
        if not product:
            print(f"[Bỏ qua] Không tìm thấy sản phẩm ứng với url trong products.json: {url}")
            not_found_count += 1
            continue

        acf_payload = build_acf_payload(product)
        title = product.get("title", "")
        try:
            patch_acf(post_id, acf_payload)
            ok = verify_acf_saved(post_id, acf_payload)
            if ok:
                print(f"[OK] Post ID {post_id} — {title}")
                success_count += 1
            else:
                print(f"[CẢNH BÁO] Post ID {post_id} — {title}: đã PATCH nhưng đọc lại field 'gia' KHÔNG khớp "
                      f"(có thể vẫn còn field group trùng tên gây ghi nhầm — kiểm tra lại wp-admin).")
                mismatch_count += 1
        except Exception as e:
            print(f"[LỖI] Post ID {post_id} — {title}: {e}")
            error_count += 1

    print(f"\n=== HOÀN TẤT ===")
    print(f"OK: {success_count}")
    print(f"Ghi nhưng đọc lại không khớp (nghi còn field group trùng): {mismatch_count}")
    print(f"Lỗi: {error_count}")
    print(f"Không tìm thấy sản phẩm tương ứng: {not_found_count}")


if __name__ == "__main__":
    main()