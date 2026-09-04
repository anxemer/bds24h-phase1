# -*- coding: utf-8 -*-
"""
FILE: crawl_and_update_kcn_details.py
MỤC ĐÍCH:
    Thu thập TOÀN BỘ thông tin chi tiết (Chủ đầu tư, Vị trí, Giá thuê, Hạ tầng Điện/Nước/Nước thải,
    Ngành nghề, Chi phí, Ưu đãi, Mô tả) từ khoxuongdep.com.vn cho 1.211 KCN
    và CẬP NHẬT TRỰC TIẾP vào các bài viết đã tạo trên WordPress (batdongsankhucongnghiep.vn).

TỐC ĐỘ:
    Sử dụng đa luồng (ThreadPoolExecutor) để cập nhật hàng loạt 1.211 bài viết nhanh chóng.
"""

import os
import re
import json
import base64
import requests
from bs4 import BeautifulSoup
from concurrent.futures import ThreadPoolExecutor, as_completed

# ================== CONFIG ==================

WP_SITE_URL     = "https://batdongsankhucongnghiep.vn"
WP_USERNAME     = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

TRACKING_FILE   = "./kcn_import_tracking.json"
UPDATE_TRACKING = "./kcn_details_updated.json"
KCN_LIST_FILE   = "./kcn_list.json"

MAX_WORKERS     = 15  # Số luồng chạy đồng thời

# ============================================

def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}", "Content-Type": "application/json"}

def parse_kcn_page(url: str) -> dict:
    """Crawl và trích xuất toàn bộ thông tin từ trang chi tiết KCN trên khoxuongdep."""
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"}
    try:
        resp = requests.get(url, headers=headers, timeout=20)
        if resp.status_code != 200:
            return {}
        html = resp.text
    except Exception:
        return {}

    soup = BeautifulSoup(html, "lxml")
    main = soup.select_one("main")
    if not main:
        return {}

    text = main.get_text("\n", strip=True)

    def get_val(pattern, default=""):
        m = re.search(pattern, text, re.IGNORECASE | re.MULTILINE)
        return m.group(1).strip() if m else default

    chu_dau_tu = get_val(r"Công ty chủ đầu tư[:\n\s]+([^\n]+)")
    vi_tri     = get_val(r"Địa điểm[:\n\s]+([^\n]+)")

    ht_dien       = get_val(r"Hệ thống điện[:\n\s]+([^\n]+)")
    ht_nuoc_sach  = get_val(r"Hệ thống nước[:\n\s]+([^\n]+)")
    ht_nuoc_thai  = get_val(r"Hệ thống xử lý nước thải[:\n\s]+([^\n]+)")
    ht_vien_thong = get_val(r"Internet & viễn thông[:\n\s]+([^\n]+)")

    nganh_nghe = get_val(r"Lĩnh vực ưu tiên thu hút đầu tư[:\n\s]+([^\n]+)")
    gia_thue   = get_val(r"Giá thuê đất & hạ tầng[:\n\s]+([^\n]+)") or get_val(r"Giá thuê tham khảo[:\n\s]+([^\n]+)")

    phi_ql = get_val(r"Phí quản lý[:\n\s]+([^\n]+)")
    if "các chi phí" in phi_ql.lower():
        m_p = re.search(r"Phí quản lý[:\n\s]+.*?([\d,\.]+\s*(?:USD|VNĐ|VND|\$)[^\n]*)", text, re.IGNORECASE)
        phi_ql = m_p.group(1).strip() if m_p else ""

    gia_dien    = get_val(r"Giá điện[:\n\s]+([^\n]+)")
    gia_nuoc    = get_val(r"Giá nước[:\n\s]+([^\n]+)")
    phi_xl_nt   = get_val(r"Phí xử lý nước thải[:\n\s]+([^\n]+)")

    uu_dai_match = re.search(r"Chính sách ưu đãi thu hút đầu tư[:\n\s]+(.*?)(?=Thông tin liên hệ|Hỏi đáp|KCN cùng khu vực|$)", text, re.IGNORECASE | re.DOTALL)
    uu_dai = " ".join(uu_dai_match.group(1).split()) if uu_dai_match else ""

    return {
        "content": str(main),
        "mo_ta_text": text,
        "chu_dau_tu": chu_dau_tu,
        "vi_tri": vi_tri,
        "tinh_thanh": vi_tri,
        "ht_dien": ht_dien,
        "ht_nuoc_sach": ht_nuoc_sach,
        "ht_nuoc_thai": ht_nuoc_thai,
        "ht_vien_thong": ht_vien_thong,
        "nganh_nghe_thu_hut": nganh_nghe,
        "gia_thue": gia_thue or "Liên hệ báo giá",
        "phi_quan_ly": phi_ql,
        "gia_dien": gia_dien,
        "gia_nuoc": gia_nuoc,
        "phi_xuly_nuocthai": phi_xl_nt,
        "uu_dai_thue": uu_dai,
    }

def update_single_kcn(url: str, post_id: int) -> bool:
    """Crawl dữ liệu và gửi cập nhật lên WordPress qua REST API."""
    data = parse_kcn_page(url)
    if not data:
        return False

    headers = get_auth_header()

    payload = {
        "content": data["content"],
        "acf": {
            "chu_dau_tu": data["chu_dau_tu"],
            "vi_tri": data["vi_tri"],
            "tinh_thanh": data["tinh_thanh"],
            "ht_dien": data["ht_dien"],
            "ht_nuoc_sach": data["ht_nuoc_sach"],
            "ht_nuoc_thai": data["ht_nuoc_thai"],
            "ht_vien_thong": data["ht_vien_thong"],
            "nganh_nghe_thu_hut": data["nganh_nghe_thu_hut"],
            "gia_thue": data["gia_thue"],
            "phi_quan_ly": data["phi_quan_ly"],
            "gia_dien": data["gia_dien"],
            "gia_nuoc": data["gia_nuoc"],
            "phi_xuly_nuocthai": data["phi_xuly_nuocthai"],
            "uu_dai_thue": data["uu_dai_thue"],
            "mo_ta_chi_tiet": data["mo_ta_text"],
        },
        "meta": {
            "chu_dau_tu": data["chu_dau_tu"],
            "vi_tri": data["vi_tri"],
            "tinh_thanh": data["tinh_thanh"],
            "ht_dien": data["ht_dien"],
            "ht_nuoc_sach": data["ht_nuoc_sach"],
            "ht_nuoc_thai": data["ht_nuoc_thai"],
            "ht_vien_thong": data["ht_vien_thong"],
            "nganh_nghe_thu_hut": data["nganh_nghe_thu_hut"],
            "gia_thue": data["gia_thue"],
            "phi_quan_ly": data["phi_quan_ly"],
            "gia_dien": data["gia_dien"],
            "gia_nuoc": data["gia_nuoc"],
            "phi_xuly_nuocthai": data["phi_xuly_nuocthai"],
            "uu_dai_thue": data["uu_dai_thue"],
            "mo_ta_chi_tiet": data["mo_ta_text"],
        }
    }

    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/khu-cong-nghiep/{post_id}"
    resp = requests.post(endpoint, headers=headers, json=payload, timeout=30)
    return resp.status_code == 200

def main():
    if not os.path.exists(TRACKING_FILE):
        print(f"❌ Không tìm thấy file tracking {TRACKING_FILE}")
        return

    with open(TRACKING_FILE, "r", encoding="utf-8") as f:
        tracking = json.load(f)

    updated_log = {}
    if os.path.exists(UPDATE_TRACKING):
        with open(UPDATE_TRACKING, "r", encoding="utf-8") as f:
            updated_log = json.load(f)

    items_to_update = [(url, pid) for url, pid in tracking.items() if url.startswith("http") and url not in updated_log]
    total = len(items_to_update)

    print("=" * 65)
    print(f"🚀 BẮT ĐẦU CẬP NHẬT THÔNG TIN CHI TIẾT CHO {total} KHU CÔNG NGHIỆP")
    print(f"   (Đã cập nhật trước đó: {len(updated_log)})")
    print("=" * 65)

    success_count = 0
    error_count = 0

    with ThreadPoolExecutor(max_workers=MAX_WORKERS) as executor:
        futures = {executor.submit(update_single_kcn, url, pid): (url, pid) for url, pid in items_to_update}

        for idx, future in enumerate(as_completed(futures), 1):
            url, pid = futures[future]
            try:
                ok = future.result()
                if ok:
                    print(f"[{idx}/{total}] ✅ Cập nhật thành công: Post ID {pid} ({url.split('/')[-2]})")
                    updated_log[url] = pid
                    success_count += 1
                else:
                    print(f"[{idx}/{total}] ⚠️ Không cào được dữ liệu: Post ID {pid} ({url.split('/')[-2]})")
                    error_count += 1
            except Exception as e:
                print(f"[{idx}/{total}] ❌ Lỗi: Post ID {pid}: {e}")
                error_count += 1

            # Lưu tiến độ mỗi 10 bài
            if idx % 10 == 0:
                with open(UPDATE_TRACKING, "w", encoding="utf-8") as f:
                    json.dump(updated_log, f, ensure_ascii=False, indent=2)

    # Lưu lần cuối
    with open(UPDATE_TRACKING, "w", encoding="utf-8") as f:
        json.dump(updated_log, f, ensure_ascii=False, indent=2)

    print("\n" + "=" * 65)
    print("🎉 HOÀN TẤT CẬP NHẬT THÔNG TIN!")
    print(f"   ✅ Thành công: {success_count}")
    print(f"   ❌ Gặp lỗi: {error_count}")
    print("=" * 65)

if __name__ == "__main__":
    main()
