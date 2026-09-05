# -*- coding: utf-8 -*-
"""
FILE: crawl_and_update_kcn_details.py
MỤC ĐÍCH:
    Thu thập TOÀN BỘ thông tin chi tiết (Chủ đầu tư, Địa điểm/Vị trí, Quy mô diện tích,
    Giá thuê, Hạ tầng Điện/Nước/Nước thải/Viễn thông, Ngành nghề, Biểu phí, Ưu đãi thuế, Mô tả)
    từ khoxuongdep cho 1.211 KCN và CẬP NHẬT TRỰC TIẾP vào các bài viết đã tạo trên WordPress
    (batdongsankhucongnghiep.vn), chuyển template về chuẩn single-khu-cong-nghiep.php.
"""

import os
import re
import sys
import json
import time
import base64
import requests
from bs4 import BeautifulSoup
from concurrent.futures import ThreadPoolExecutor, as_completed
import threading

sys.stdout.reconfigure(line_buffering=True, encoding='utf-8')

# ================== CONFIG ==================
WP_SITE_URL     = "https://batdongsankhucongnghiep.vn"
WP_USERNAME     = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

WP_POST_TYPE    = "khu-cong-nghiep"

TRACKING_FILE   = "./kcn/kcn_reupload_tracking.json"
UPDATE_TRACKING = "./kcn/kcn_details_updated_new.json"

MAX_WORKERS     = 15

log_lock = threading.Lock()

def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}", "Content-Type": "application/json"}

AUTH_HEADER = get_auth_header()

def clean_brand_text(text: str) -> str:
    """Thay thế thông tin thương hiệu và số điện thoại cũ sang BĐS24H."""
    if not text:
        return ""
    text = re.sub(r'khoxuongdep(?:\.com(?:\.vn)?)?', 'batdongsankhucongnghiep.vn', text, flags=re.IGNORECASE)
    text = re.sub(r'kho\s*xưởng\s*đẹp', 'Bất Động Sản Khu Công Nghiệp', text, flags=re.IGNORECASE)
    text = re.sub(r'(?:0909\s*161\s*824|0901\s*626\s*248)', '0909 161 824', text)
    return text

def parse_kcn_page(url: str) -> dict:
    """Crawl và trích xuất toàn bộ thông tin từ trang chi tiết KCN."""
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"}
    for attempt in range(2):
        try:
            resp = requests.get(url, headers=headers, timeout=25)
            if resp.status_code != 200:
                return {}
            html = resp.text
            break
        except Exception:
            time.sleep(1)
            if attempt == 1:
                return {}

    soup = BeautifulSoup(html, "lxml")
    main = soup.select_one("main") or soup.select_one("article") or soup.select_one(".entry-content")
    if not main:
        return {}

    raw_text = main.get_text("\n", strip=True)
    text = clean_brand_text(raw_text)

    def get_val(pattern, default=""):
        m = re.search(pattern, text, re.IGNORECASE | re.MULTILINE)
        return m.group(1).strip() if m else default

    chu_dau_tu = get_val(r"(?:Công\s*ty\s*)?chủ\s*đầu\s*tư[:\n\s]+([^\n]+)")
    vi_tri     = get_val(r"(?:Địa\s*điểm|Vị\s*trí)[:\n\s]+([^\n]+)")
    quy_mo     = get_val(r"(?:Quy\s*mô(?:\s*diện\s*tích)?|Diện\s*tích(?:\s*khu\s*công\s*nghiệp)?)[:\n\s]+([^\n]+)")
    thoi_han   = get_val(r"Thời\s*hạn(?:\s*vận\s*hành|\s*sử\s*dụng)?[:\n\s]+([^\n]+)")

    ht_dien       = get_val(r"Hệ\s*thống\s*điện[:\n\s]+([^\n]+)")
    ht_nuoc_sach  = get_val(r"Hệ\s*thống\s*nước[:\n\s]+([^\n]+)")
    ht_nuoc_thai  = get_val(r"Hệ\s*thống\s*xử\s*lý\s*nước\s*thải[:\n\s]+([^\n]+)")
    ht_vien_thong = get_val(r"(?:Internet\s*&\s*viễn\s*thông|Hệ\s*thống\s*viễn\s*thông)[:\n\s]+([^\n]+)")

    nganh_nghe = get_val(r"Lĩnh\s*vực\s*ưu\s*tiên\s*thu\s*hút\s*đầu\s*tư[:\n\s]+([^\n]+)")
    gia_thue   = get_val(r"Giá\s*thuê\s*đất\s*&\s*hạ\s*tầng[:\n\s]+([^\n]+)") or get_val(r"Giá\s*thuê\s*tham\s*khảo[:\n\s]+([^\n]+)") or get_val(r"Giá\s*thuê[:\n\s]+([^\n]+)")

    phi_ql = get_val(r"Phí\s*quản\s*lý[:\n\s]+([^\n]+)")
    if "các chi phí" in phi_ql.lower():
        m_p = re.search(r"Phí\s*quản\s*lý[:\n\s]+.*?([\d,\.]+\s*(?:USD|VNĐ|VND|\$)[^\n]*)", text, re.IGNORECASE)
        phi_ql = m_p.group(1).strip() if m_p else ""

    gia_dien    = get_val(r"Giá\s*điện[:\n\s]+([^\n]+)")
    gia_nuoc    = get_val(r"Giá\s*nước[:\n\s]+([^\n]+)")
    phi_xl_nt   = get_val(r"Phí\s*xử\s*lý\s*nước\s*thải[:\n\s]+([^\n]+)")

    uu_dai_match = re.search(r"Chính\s*sách\s*ưu\s*đãi\s*thu\s*hút\s*đầu\s*tư[:\n\s]+(.*?)(?=Thông\s*tin\s*liên\s*hệ|Hỏi\s*đáp|KCN\s*cùng\s*khu\s*vực|\Z)", text, re.IGNORECASE | re.DOTALL)
    uu_dai = " ".join(uu_dai_match.group(1).split()) if uu_dai_match else ""

    clean_html = clean_brand_text(str(main))

    return {
        "content": clean_html,
        "mo_ta_text": text,
        "chu_dau_tu": chu_dau_tu,
        "vi_tri": vi_tri,
        "quy_mo": quy_mo,
        "thoi_han": thoi_han,
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

    payload = {
        "content": data["content"],
        "template": "",
        "categories": [58],
        "acf": {
            "chu_dau_tu": data["chu_dau_tu"],
            "vi_tri": data["vi_tri"],
            "quy_mo": data["quy_mo"],
            "dien_tich": data["quy_mo"],
            "thoi_han": data["thoi_han"],
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
            "quy_mo": data["quy_mo"],
            "dien_tich": data["quy_mo"],
            "thoi_han": data["thoi_han"],
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
            "_wp_page_template": "",
        }
    }

    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/{WP_POST_TYPE}/{post_id}"
    for attempt in range(3):
        try:
            resp = requests.post(endpoint, headers=AUTH_HEADER, json=payload, timeout=30)
            if resp.status_code == 200:
                return True
            time.sleep(1)
        except Exception:
            time.sleep(2)

    return False

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
    print(f"   (Đã hoàn thành trước đó: {len(updated_log)})")
    print("=" * 65)

    success_count = 0
    error_count = 0

    with ThreadPoolExecutor(max_workers=MAX_WORKERS) as executor:
        futures = {executor.submit(update_single_kcn, url, pid): (url, pid) for url, pid in items_to_update}

        for idx, future in enumerate(as_completed(futures), 1):
            url, pid = futures[future]
            slug = url.strip("/").split("/")[-1]
            try:
                ok = future.result()
                if ok:
                    print(f"[{idx}/{total}] ✅ Đã cập nhật chi tiết: ID {pid} | {slug}")
                    with log_lock:
                        updated_log[url] = pid
                        success_count += 1
                else:
                    print(f"[{idx}/{total}] ⚠️ Không cào được dữ liệu: ID {pid} | {slug}")
                    with log_lock:
                        error_count += 1
            except Exception as e:
                print(f"[{idx}/{total}] ❌ Lỗi: ID {pid}: {e}")
                with log_lock:
                    error_count += 1

            if idx % 25 == 0:
                with log_lock:
                    with open(UPDATE_TRACKING, "w", encoding="utf-8") as f:
                        json.dump(updated_log, f, ensure_ascii=False, indent=2)

    with log_lock:
        with open(UPDATE_TRACKING, "w", encoding="utf-8") as f:
            json.dump(updated_log, f, ensure_ascii=False, indent=2)

    print("\n" + "=" * 65)
    print("🎉 HOÀN TẤT CẬP NHẬT THÔNG TIN CHO TOÀN BỘ KCN!")
    print(f"   ✅ Thành công: {success_count}")
    print(f"   ❌ Gặp lỗi: {error_count}")
    print("=" * 65)

if __name__ == "__main__":
    main()
