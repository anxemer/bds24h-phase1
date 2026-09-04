# -*- coding: utf-8 -*-
"""
FILE: update_listing_pages.py
MỤC ĐÍCH: Thay thế toàn bộ các card mẫu cũ (vốn đang bị link 404) trong các file:
    - homepage.html
    - khu-cong-nghiep.html
    - kho-xuong.html
    - dat-cong-nghiep.html
bằng các Khu Công Nghiệp và Sản Phẩm THẬT vừa được import lên WordPress (batdongsankhucongnghiep.vn).
"""

import os
import re
import json

SITE_URL = "https://batdongsankhucongnghiep.vn"

def load_json(filepath):
    if os.path.exists(filepath):
        with open(filepath, "r", encoding="utf-8") as f:
            return json.load(f)
    return {}

def update_homepage(real_kcns):
    filepath = "homepage.html"
    if not os.path.exists(filepath): return
    with open(filepath, "r", encoding="utf-8") as f: html = f.read()

    cards_html = []
    for kcn in real_kcns[:14]:
        title = kcn.get("title", "")
        slug = kcn.get("slug", "")
        url = f"{SITE_URL}/{slug}/"
        thumb = kcn.get("thumb_url") or "https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg"
        region = kcn.get("region", "long-an")
        region_text = kcn.get("region_text", "Long An")
        price = kcn.get("price", "Liên hệ báo giá")
        specs = kcn.get("specs", "Đa ngành nghề · Logistics")

        card = f'''                <a href="{url}" class="bds-card" data-region="{region}" data-status="operating"
                    data-title="{title}" title="{title}">
                    <div class="bds-thumb"><img
                            src="{thumb}"
                            alt="{title}"><span class="bds-status">Đang hoạt động</span><span class="bds-thumb-label">{title.upper()[:20]}</span></div>
                    <div class="bds-card-body">
                        <div class="bds-card-kicker"><span>Khu công nghiệp</span><span>Mới cập nhật</span></div>
                        <div class="bds-card-title">{title}</div>
                        <div class="bds-card-loc">📍 {region_text}</div><span class="bds-spec">{price}</span>
                        <div class="bds-card-meta"><span>{specs}</span><span>Hạ tầng hoàn chỉnh</span></div>
                        <div class="bds-price">{price}</div><span class="bds-card-action">Xem chi tiết {title} →</span>
                    </div>
                </a>'''
        cards_html.append(card)

    new_grid_content = "\n".join(cards_html)
    pattern = r'(<div class="bds-grid" id="bds-property-grid">).*?(<div class="bds-empty" id="bds-empty">)'
    if re.search(pattern, html, re.DOTALL):
        html = re.sub(pattern, rf'\1\n{new_grid_content}\n                \2', html, flags=re.DOTALL)
        with open(filepath, "w", encoding="utf-8") as f: f.write(html)
        print("✅ Đã cập nhật cards thật vào homepage.html!")
    else:
        print("⚠️ Không tìm thấy vị trí bds-property-grid trong homepage.html")

def update_khu_cong_nghiep(real_kcns):
    filepath = "khu-cong-nghiep.html"
    if not os.path.exists(filepath): return
    with open(filepath, "r", encoding="utf-8") as f: html = f.read()

    cards_html = []
    for kcn in real_kcns[:18]:
        title = kcn.get("title", "")
        slug = kcn.get("slug", "")
        url = f"{SITE_URL}/{slug}/"
        thumb = kcn.get("thumb_url") or "https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg"
        region_text = kcn.get("region_text", "Việt Nam")
        price = kcn.get("price", "Liên hệ báo giá")
        specs = kcn.get("specs", "Đa ngành nghề · Logistics")

        card = f'''					<!-- {title} -->
					<a href="{url}" class="lp-card">
						<div class="lp-card-thumb">
							<img src="{thumb}" alt="{title}">
							<span class="lp-card-badge">Đang hoạt động</span>
							<span class="lp-card-label">{title.upper()[:20]}</span>
						</div>
						<div class="lp-card-body">
							<div class="lp-card-kicker"><span>Khu công nghiệp</span><span>{region_text}</span></div>
							<div class="lp-card-title">{title}</div>
							<div class="lp-card-loc">📍 {region_text}</div>
							<div class="lp-card-specs">
								<span class="lp-card-spec">{specs.split("·")[0].strip()}</span>
								<span class="lp-card-spec">Hạ tầng chuẩn</span>
								<span class="lp-card-spec">PCCC & GPXD</span>
							</div>
							<div class="lp-card-price">
								<strong>{price}</strong>
								<span class="lp-card-cta">Xem chi tiết →</span>
							</div>
						</div>
					</a>'''
        cards_html.append(card)

    new_grid = "\n".join(cards_html)
    pattern = r'(<div class="lp-grid">).*?(</div>\s*</div>\s*</div>\s*</div>\s*</main>)'
    if re.search(pattern, html, re.DOTALL):
        html = re.sub(pattern, rf'\1\n{new_grid}\n\t\t\t\t\2', html, flags=re.DOTALL)
        with open(filepath, "w", encoding="utf-8") as f: f.write(html)
        print("✅ Đã cập nhật cards thật vào khu-cong-nghiep.html!")
    else:
        print("⚠️ Không tìm thấy vị trí lp-grid trong khu-cong-nghiep.html")

def clean_area(area_str):
    if not area_str: return "Đang cập nhật"
    area_str = str(area_str).strip()
    if len(area_str) > 25:
        m = re.search(r'([\d,.]+\s*(?:m[²2]|hecta|ha))', area_str, re.IGNORECASE)
        if m: return m.group(1).strip()
        return area_str[:22] + "..."
    return area_str

def update_kho_xuong(products):
    filepath = "kho-xuong.html"
    if not os.path.exists(filepath): return
    with open(filepath, "r", encoding="utf-8") as f: html = f.read()

    kho_products = [p for p in products if "kho" in p.get("loai_hinh", "").lower() or "xưởng" in p.get("loai_hinh", "").lower() or "thuê" in p.get("title", "").lower()]
    if not kho_products: kho_products = products

    cards_html = []
    for p in kho_products[:12]:
        title = p.get("title", "")
        slug = p.get("url", "").strip("/").split("/")[-1]
        url = f"{SITE_URL}/{slug}/"
        images = p.get("images", [])
        thumb = images[0] if images else "https://khoxuongdep.com.vn/wp-content/uploads/2026/08/cho-thue-kho-xuong-3000m2-kcn-hoa-khanh-da-nang.jpg"
        if not thumb.startswith("http"):
            thumb = f"https://batdongsankhucongnghiep.vn/wp-content/uploads/2026/09/{os.path.basename(thumb)}"
        area = clean_area(p.get("dien_tich") or "3.000 m²")
        loc = p.get("khu_vuc") or "Long An"
        price = p.get("gia") or "Thỏa thuận"

        card = f'''					<a href="{url}" class="lp-card">
						<div class="lp-card-thumb">
							<img src="{thumb}" alt="{title}">
							<span class="lp-card-badge">Mới nhất</span>
							<span class="lp-card-area">{area}</span>
						</div>
						<div class="lp-card-body">
							<div class="lp-card-kicker"><span>Kho xưởng</span><span>Mới cập nhật</span></div>
							<div class="lp-card-title">{title}</div>
							<div class="lp-card-loc">📍 {loc}</div>
							<div class="lp-card-specs">
								<span class="lp-card-spec">{area}</span>
								<span class="lp-card-spec">PCCC tự động</span>
								<span class="lp-card-spec">Container 24/24</span>
							</div>
							<div class="lp-card-price">
								<strong>{price}</strong>
								<span class="lp-card-cta">Xem chi tiết →</span>
							</div>
						</div>
					</a>'''
        cards_html.append(card)

    new_grid = "\n".join(cards_html)
    pattern = r'(<div class="lp-grid">).*?(</div>\s*</div>\s*</div>\s*</div>\s*</main>)'
    if re.search(pattern, html, re.DOTALL):
        html = re.sub(pattern, rf'\1\n{new_grid}\n\t\t\t\t\2', html, flags=re.DOTALL)
        with open(filepath, "w", encoding="utf-8") as f: f.write(html)
        print("✅ Đã cập nhật cards thật vào kho-xuong.html!")
    else:
        print("⚠️ Không tìm thấy vị trí lp-grid trong kho-xuong.html")

def update_dat_cong_nghiep(products):
    filepath = "dat-cong-nghiep.html"
    if not os.path.exists(filepath): return
    with open(filepath, "r", encoding="utf-8") as f: html = f.read()

    dat_products = [p for p in products if "đất" in p.get("loai_hinh", "").lower() or "dat" in p.get("loai_hinh", "").lower() or "đất" in p.get("title", "").lower()]
    if not dat_products: dat_products = products

    cards_html = []
    for p in dat_products[:12]:
        title = p.get("title", "")
        slug = p.get("url", "").strip("/").split("/")[-1]
        url = f"{SITE_URL}/{slug}/"
        images = p.get("images", [])
        thumb = images[0] if images else "https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-huu-thanh-long-an.jpg"
        if not thumb.startswith("http"):
            thumb = f"https://batdongsankhucongnghiep.vn/wp-content/uploads/2026/09/{os.path.basename(thumb)}"
        area = clean_area(p.get("dien_tich") or "10.000 m²")
        loc = p.get("khu_vuc") or "Long An"
        price = p.get("gia") or "Thỏa thuận"

        card = f'''					<a href="{url}" class="lp-list-card">
						<div class="lp-list-thumb">
							<img src="{thumb}" alt="{title}">
							<span class="lp-list-badge" style="background: #16a34a;">Đất công nghiệp</span>
						</div>
						<div class="lp-list-body">
							<div>
								<div class="lp-list-kicker"><span>Đất công nghiệp</span><span>•</span><span>{loc}</span><span>•</span><span>Mới cập nhật</span></div>
								<div class="lp-list-title">{title}</div>
								<div class="lp-list-loc">📍 {loc}</div>
								<div class="lp-list-specs">
									<span class="lp-list-spec"><strong>{area}</strong></span>
									<span class="lp-list-spec">Pháp lý đầy đủ</span>
									<span class="lp-list-spec">Đường xe container</span>
									<span class="lp-list-spec">Hạ tầng hoàn chỉnh</span>
								</div>
							</div>
							<div class="lp-list-footer">
								<div class="lp-list-price">
									{price}
									<small>Giá thuê tham khảo</small>
								</div>
								<span class="lp-list-cta">Xem chi tiết →</span>
							</div>
						</div>
					</a>'''
        cards_html.append(card)

    new_grid = "\n".join(cards_html)
    pattern = r'(<div class="lp-list">).*?(</div>\s*</div>\s*</div>\s*</div>\s*</main>)'
    if re.search(pattern, html, re.DOTALL):
        html = re.sub(pattern, rf'\1\n{new_grid}\n\t\t\t\t\2', html, flags=re.DOTALL)
        with open(filepath, "w", encoding="utf-8") as f: f.write(html)
        print("✅ Đã cập nhật cards thật vào dat-cong-nghiep.html!")
    else:
        print("⚠️ Không tìm thấy vị trí lp-list trong dat-cong-nghiep.html")


def main():
    kcn_list = load_json("kcn_list.json")
    media_cache = load_json("kcn_media_cache.json")
    products = load_json(r"C:\Users\ACER\Downloads\python\python\crawled-products\products.json")

    # Chuẩn bị danh sách KCN thật
    real_kcns = []
    for item in kcn_list:
        title = item.get("title", "").strip()
        url = item.get("url", "")
        slug = url.strip("/").split("/")[-1]
        if not slug or slug == "khu-cong-nghiep":
            continue

        # Tìm ảnh
        thumb = ""
        images = item.get("images", [])
        if images:
            fn = os.path.basename(images[0])
            if fn in media_cache:
                thumb = media_cache[fn].get("source_url", "")

        region = "long-an"
        region_text = "Long An"
        lower = (title + " " + slug).lower()
        if "hcm" in lower or "ho-chi-minh" in lower or "binh-chanh" in lower or "cu-chi" in lower or "nha-be" in lower:
            region = "hcm"; region_text = "TP. Hồ Chí Minh"
        elif "binh-duong" in lower or "bau-bang" in lower or "vsip" in lower:
            region = "binh-duong"; region_text = "Bình Dương"
        elif "dong-nai" in lower or "nhon-trach" in lower:
            region = "dong-nai"; region_text = "Đồng Nai"
        elif "ba-ria" in lower or "vung-tau" in lower or "phu-my" in lower or "chau-duc" in lower:
            region = "ba-ria"; region_text = "Bà Rịa - Vũng Tàu"
        elif "da-nang" in lower:
            region = "da-nang"; region_text = "Đà Nẵng"

        real_kcns.append({
            "title": title,
            "slug": slug,
            "thumb_url": thumb,
            "region": region,
            "region_text": region_text,
            "price": "Liên hệ báo giá",
            "specs": "Hạ tầng kỹ thuật đồng bộ",
        })

    print(f"Loaded {len(real_kcns)} real KCNs and {len(products)} real products.")
    update_homepage(real_kcns)
    update_khu_cong_nghiep(real_kcns)
    update_kho_xuong(products)
    update_dat_cong_nghiep(products)

if __name__ == "__main__":
    main()
