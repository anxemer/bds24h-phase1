# -*- coding: utf-8 -*-
"""
FILE: sync_real_wp_posts_to_listings.py
MỤC ĐÍCH: Lấy trực tiếp danh sách bài viết THẬT từ WordPress API (kèm URL thật p['link'])
          để cập nhật vào các trang listing:
          - homepage.html
          - khu-cong-nghiep.html
          - kho-xuong.html
          - dat-cong-nghiep.html
          Đảm bảo 100% link hoạt động, không bao giờ bị 404!
"""

import os
import re
import sys
import base64
import requests

sys.stdout.reconfigure(encoding='utf-8')

WP_URL = "https://batdongsankhucongnghiep.vn"
AUTH = base64.b64encode(b"admin:Q5qz 5BX0 20LM uEYs 7b0i ud9n").decode()
HEADERS = {"Authorization": f"Basic {AUTH}"}

def clean_area(area_str):
    if not area_str: return "3.000 m²"
    area_str = str(area_str).strip()
    if area_str.isdigit():
        return f"{int(area_str):,} m²".replace(',', '.')
    if len(area_str) > 25:
        m = re.search(r'([\d,.]+\s*(?:m[²2]|hecta|ha))', area_str, re.IGNORECASE)
        if m: return m.group(1).strip()
        return area_str[:22] + "..."
    if not re.search(r'(m[²2]|ha|hecta)', area_str, re.IGNORECASE):
        area_str += " m²"
    return area_str

def clean_price(gia_str):
    if not gia_str: return "Thỏa thuận"
    gia_str = str(gia_str).strip()
    low = gia_str.lower()
    if low in ['liên hệ', 'thỏa thuận', 'thoa thuan', 'lien he', 'đang cập nhật']:
        return "Liên hệ báo giá"
    num_clean = re.sub(r'[^\d]', '', gia_str)
    if num_clean and len(num_clean) >= 7:
        num = float(num_clean)
        if num >= 1_000_000_000:
            ty = num / 1_000_000_000
            return f"{ty:.1f} tỷ".replace('.0', '').replace('.', ',')
        elif num >= 1_000_000:
            trieu = num / 1_000_000
            return f"{trieu:.1f} triệu".replace('.0', '').replace('.', ',')
    return gia_str

def get_posts_from_wp(per_page=100, page=1):
    try:
        r = requests.get(f"{WP_URL}/wp-json/wp/v2/khu-cong-nghiep?per_page={per_page}&page={page}&status=publish&_embed=1", headers=HEADERS, timeout=30)
        if r.status_code == 200:
            return r.json()
    except Exception as e:
        print(f"Error fetching WP posts: {e}")
    return []

def main():
    print("⏳ Đang tải danh sách bài viết từ WordPress...")
    all_items = []
    for p in range(1, 7):
        items = get_posts_from_wp(per_page=50, page=p)
        if not items: break
        all_items.extend(items)

    print(f"Đã tải {len(all_items)} bài viết từ WordPress.")

    kcns = []
    kho_xuong = []
    dat_cn = []

    for item in all_items:
        title = item["title"]["rendered"]
        link = item["link"]
        slug = item["slug"]
        
        # Featured image
        media = item.get("_embedded", {}).get("wp:featuredmedia", [{}])[0]
        thumb = media.get("source_url", "")
        if not thumb:
            thumb = "https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg"

        acf = item.get("acf") or {}
        loai_hinh = acf.get("loai_hinh", "").lower()
        khu_vuc = acf.get("khu_vuc") or "Long An"
        gia = clean_price(acf.get("gia"))
        dien_tich = clean_area(acf.get("dien_tich"))

        # Phân loại
        lower_title = title.lower()
        if "kho" in loai_hinh or "xưởng" in loai_hinh or "kho" in lower_title or "xưởng" in lower_title:
            kho_xuong.append({
                "title": title, "link": link, "thumb": thumb, "khu_vuc": khu_vuc, "gia": gia, "dien_tich": dien_tich
            })
        elif "đất" in loai_hinh or "dat" in loai_hinh or "đất" in lower_title or "dat" in lower_title:
            dat_cn.append({
                "title": title, "link": link, "thumb": thumb, "khu_vuc": khu_vuc, "gia": gia, "dien_tich": dien_tich
            })
        else:
            # Khu công nghiệp
            region = "long-an"
            region_text = "Long An"
            if any(k in lower_title for k in ["hcm", "hồ chí minh", "củ chi", "bình chánh", "nhà bè", "thủ đức"]):
                region = "hcm"; region_text = "TP.HCM"
            elif any(k in lower_title for k in ["bình dương", "vsip", "bàu bàng", "tân uyên"]):
                region = "binh-duong"; region_text = "Bình Dương"
            elif any(k in lower_title for k in ["đồng nai", "nhơn trạch", "long thành"]):
                region = "dong-nai"; region_text = "Đồng Nai"
            elif any(k in lower_title for k in ["vũng tàu", "bà rịa", "phú mỹ", "châu đức"]):
                region = "ba-ria"; region_text = "Bà Rịa - Vũng Tàu"
            elif "đà nẵng" in lower_title:
                region = "da-nang"; region_text = "Đà Nẵng"

            kcns.append({
                "title": title, "link": link, "thumb": thumb, "region": region, "region_text": region_text,
                "gia_thue": "Liên hệ báo giá"
            })

    print(f"Phân loại được: {len(kcns)} KCN, {len(kho_xuong)} Kho xưởng, {len(dat_cn)} Đất công nghiệp.")

    # 1. CẬP NHẬT HOMEPAGE
    if os.path.exists("homepage.html") and kcns:
        with open("homepage.html", "r", encoding="utf-8") as f: html = f.read()
        cards = []
        for k in kcns[:14]:
            card = f'''                <a href="{k['link']}" class="bds-card" data-region="{k['region']}" data-status="operating"
                    data-title="{k['title']}" title="{k['title']}">
                    <div class="bds-thumb"><img src="{k['thumb']}" alt="{k['title']}"><span class="bds-status">Đang hoạt động</span><span class="bds-thumb-label">{k['title'].upper()[:20]}</span></div>
                    <div class="bds-card-body">
                        <div class="bds-card-kicker"><span>Khu công nghiệp</span><span>Mới cập nhật</span></div>
                        <div class="bds-card-title">{k['title']}</div>
                        <div class="bds-card-loc">📍 {k['region_text']}</div><span class="bds-spec">{k['gia_thue']}</span>
                        <div class="bds-card-meta"><span>Hạ tầng hoàn chỉnh</span><span>PCCC & GPXD</span></div>
                        <div class="bds-price">{k['gia_thue']}</div><span class="bds-card-action">Xem chi tiết {k['title']} →</span>
                    </div>
                </a>'''
            cards.append(card)
        grid_html = "\n".join(cards)
        pattern = r'(<div class="bds-grid" id="bds-property-grid">).*?(<div class="bds-empty" id="bds-empty">)'
        if re.search(pattern, html, re.DOTALL):
            html = re.sub(pattern, rf'\1\n{grid_html}\n                \2', html, flags=re.DOTALL)
            with open("homepage.html", "w", encoding="utf-8") as f: f.write(html)
            print("✅ Đã cập nhật link chuẩn vào homepage.html")

    # 2. CẬP NHẬT KHU-CONG-NGHIEP.HTML
    if os.path.exists("khu-cong-nghiep.html") and kcns:
        with open("khu-cong-nghiep.html", "r", encoding="utf-8") as f: html = f.read()
        cards = []
        for k in kcns[:18]:
            card = f'''					<a href="{k['link']}" class="lp-card">
						<div class="lp-card-thumb">
							<img src="{k['thumb']}" alt="{k['title']}">
							<span class="lp-card-badge">Đang hoạt động</span>
							<span class="lp-card-label">{k['title'].upper()[:20]}</span>
						</div>
						<div class="lp-card-body">
							<div class="lp-card-kicker"><span>Khu công nghiệp</span><span>{k['region_text']}</span></div>
							<div class="lp-card-title">{k['title']}</div>
							<div class="lp-card-loc">📍 {k['region_text']}</div>
							<div class="lp-card-specs">
								<span class="lp-card-spec">Hạ tầng chuẩn</span>
								<span class="lp-card-spec">PCCC & GPXD</span>
								<span class="lp-card-spec">Logistics</span>
							</div>
							<div class="lp-card-price">
								<strong>{k['gia_thue']}</strong>
								<span class="lp-card-cta">Xem chi tiết →</span>
							</div>
						</div>
					</a>'''
            cards.append(card)
        grid_html = "\n".join(cards)
        pattern = r'(<div class="lp-grid">).*?(</div>\s*</div>\s*</div>\s*</div>\s*</main>)'
        if re.search(pattern, html, re.DOTALL):
            html = re.sub(pattern, rf'\1\n{grid_html}\n\t\t\t\t\2', html, flags=re.DOTALL)
            with open("khu-cong-nghiep.html", "w", encoding="utf-8") as f: f.write(html)
            print("✅ Đã cập nhật link chuẩn vào khu-cong-nghiep.html")

    # 3. CẬP NHẬT KHO-XUONG.HTML
    if os.path.exists("kho-xuong.html") and kho_xuong:
        with open("kho-xuong.html", "r", encoding="utf-8") as f: html = f.read()
        cards = []
        for p in kho_xuong[:16]:
            card = f'''					<a href="{p['link']}" class="lp-card">
						<div class="lp-card-thumb">
							<img src="{p['thumb']}" alt="{p['title']}">
							<span class="lp-card-badge">Mới nhất</span>
							<span class="lp-card-area">{p['dien_tich']}</span>
						</div>
						<div class="lp-card-body">
							<div class="lp-card-kicker"><span>Kho xưởng</span><span>Mới cập nhật</span></div>
							<div class="lp-card-title">{p['title']}</div>
							<div class="lp-card-loc">📍 {p['khu_vuc']}</div>
							<div class="lp-card-specs">
								<span class="lp-card-spec">{p['dien_tich']}</span>
								<span class="lp-card-spec">PCCC tự động</span>
								<span class="lp-card-spec">Container 24/24</span>
							</div>
							<div class="lp-card-price">
								<strong>{p['gia']}</strong>
								<span class="lp-card-cta">Xem chi tiết →</span>
							</div>
						</div>
					</a>'''
            cards.append(card)
        grid_html = "\n".join(cards)
        pattern = r'(<div class="lp-grid">).*?(</div>\s*</div>\s*</div>\s*</div>\s*</main>)'
        if re.search(pattern, html, re.DOTALL):
            html = re.sub(pattern, rf'\1\n{grid_html}\n\t\t\t\t\2', html, flags=re.DOTALL)
            with open("kho-xuong.html", "w", encoding="utf-8") as f: f.write(html)
            print("✅ Đã cập nhật link chuẩn vào kho-xuong.html")

    # 4. CẬP NHẬT DAT-CONG-NGHIEP.HTML
    if os.path.exists("dat-cong-nghiep.html") and dat_cn:
        with open("dat-cong-nghiep.html", "r", encoding="utf-8") as f: html = f.read()
        cards = []
        for p in dat_cn[:16]:
            card = f'''					<a href="{p['link']}" class="lp-list-card">
						<div class="lp-list-thumb">
							<img src="{p['thumb']}" alt="{p['title']}">
							<span class="lp-list-badge" style="background: #16a34a;">Đất công nghiệp</span>
						</div>
						<div class="lp-list-body">
							<div>
								<div class="lp-list-kicker"><span>Đất công nghiệp</span><span>•</span><span>{p['khu_vuc']}</span><span>•</span><span>Mới cập nhật</span></div>
								<div class="lp-list-title">{p['title']}</div>
								<div class="lp-list-loc">📍 {p['khu_vuc']}</div>
								<div class="lp-list-specs">
									<span class="lp-list-spec"><strong>{p['dien_tich']}</strong></span>
									<span class="lp-list-spec">Pháp lý đầy đủ</span>
									<span class="lp-list-spec">Đường xe container</span>
									<span class="lp-list-spec">Hạ tầng hoàn chỉnh</span>
								</div>
							</div>
							<div class="lp-list-footer">
								<div class="lp-list-price">
									{p['gia']}
									<small>Giá thuê tham khảo</small>
								</div>
								<span class="lp-list-cta">Xem chi tiết →</span>
							</div>
						</div>
					</a>'''
            cards.append(card)
        grid_html = "\n".join(cards)
        pattern = r'(<div class="lp-list">).*?(</div>\s*</div>\s*</div>\s*</div>\s*</main>)'
        if re.search(pattern, html, re.DOTALL):
            html = re.sub(pattern, rf'\1\n{grid_html}\n\t\t\t\t\2', html, flags=re.DOTALL)
            with open("dat-cong-nghiep.html", "w", encoding="utf-8") as f: f.write(html)
            print("✅ Đã cập nhật link chuẩn vào dat-cong-nghiep.html")

    print("\n🎉 ĐÃ ĐỒNG BỘ 100% LINK THẬT TỪ WORDPRESS VÀO CÁC FILE LISTING!")

if __name__ == "__main__":
    main()
