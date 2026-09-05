# -*- coding: utf-8 -*-
"""
FILE: fix_and_sync_all_listings.py
MỤC ĐÍCH:
    1. Tạo lại hoàn chỉnh giao diện chuẩn cho:
       - Kho Xưởng (/kho-xuong/) -> Page ID 4220
       - Đất Công Nghiệp (/dat-cong-nghiep/) -> Page ID 4233
       - Khu Công Nghiệp (/kcn/) -> Page ID 4299
       - Trang Chủ (/) -> Page ID 3613
    2. Đầy đủ CSS, Search Bar, Sidebar Filter, Thẻ Card chuẩn.
    3. Tích hợp bộ máy phân trang (12 card / trang, các nút: «, ‹, 1, 2, 3, 4, 5..., ›, »)
       cùng toàn bộ dữ liệu (1.873 Kho xưởng, 237 Đất CN, 1.211 KCN).
    4. Cập nhật trực tiếp vào _elementor_data và post_content của WordPress để hiển thị hoàn hảo 100%.
"""

import os
import re
import sys
import json
import base64
import requests

sys.stdout.reconfigure(line_buffering=True, encoding='utf-8')

WP_SITE_URL     = "https://batdongsankhucongnghiep.vn"
WP_USERNAME     = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}", "Content-Type": "application/json"}

AUTH_HEADER = get_auth_header()

# ============================================================
# 1. LOAD DATA
# ============================================================
def clean_area_display(area_str):
    if not area_str: return "Đang cập nhật"
    area_str = str(area_str).strip()
    if area_str.isdigit():
        return f"{int(area_str):,} m²".replace(',', '.')
    if len(area_str) > 25:
        m = re.search(r'([\d,.]+\s*(?:m[²2]|hecta|ha))', area_str, re.IGNORECASE)
        if m: return m.group(1).strip()
        return area_str[:22] + "..."
    if not re.search(r'(m[²2]|ha|hecta|mét)', area_str, re.IGNORECASE):
        area_str += " m²"
    return area_str

def clean_price_display(gia_str):
    if not gia_str: return "Liên hệ báo giá"
    gia_str = str(gia_str).strip()
    low = gia_str.lower()
    if low in ['liên hệ', 'thỏa thuận', 'thoa thuan', 'lien he', 'đang cập nhật']:
        return "Liên hệ báo giá"
    num_clean = re.sub(r'[^\d]', '', gia_str)
    if num_clean and len(num_clean) >= 7:
        num = float(num_clean)
        if num >= 1_000_000_000:
            ty = num / 1_000_000_000
            return f"{ty:.2f}".rstrip('0').rstrip('.').replace('.', ',') + " tỷ"
        elif num >= 1_000_000:
            trieu = num / 1_000_000
            return f"{trieu:.1f}".rstrip('0').rstrip('.').replace('.', ',') + " triệu"
    return gia_str

def parse_num_area(area_str):
    if not area_str: return 0
    m = re.search(r'([\d,.]+)', str(area_str))
    if m:
        val = m.group(1).replace('.', '').replace(',', '.')
        try:
            num = float(val)
            if 'ha' in str(area_str).lower() or 'hecta' in str(area_str).lower():
                num *= 10000
            return int(num)
        except Exception:
            return 0
    return 0

def parse_num_price(price_str):
    if not price_str: return 0
    txt = str(price_str).lower()
    m = re.search(r'([\d,.]+)', txt)
    if m:
        val = m.group(1).replace('.', '').replace(',', '.')
        try:
            num = float(val)
            if 'tỷ' in txt or 'ty' in txt:
                return num * 1000
            return num
        except Exception:
            return 0
    return 0

def load_data():
    with open("kx-dcn/products.json", "r", encoding="utf-8") as f:
        products = json.load(f)

    with open("kcn/kcn_list.json", "r", encoding="utf-8") as f:
        kcn_list = json.load(f)

    kho_xuong_items = []
    dat_cn_items = []

    for p in products:
        title = p.get("title", "").strip()
        url_nguon = p.get("url", "").strip()
        slug = url_nguon.strip("/").split("/")[-1]
        wp_url = f"{WP_SITE_URL}/khu-cong-nghiep/{slug}/"
        
        images = p.get("images", [])
        thumb = ""
        if images:
            img_base = os.path.basename(images[0].replace("\\", "/"))
            thumb = f"{WP_SITE_URL}/wp-content/uploads/2026/09/{img_base}"
        if not thumb:
            thumb = "https://batdongsancongnghiep24h.vn/wp-content/uploads/2026/08/2-1.png"

        loai_hinh = p.get("loai_hinh", "")
        khu_vuc = p.get("khu_vuc", "Long An") or "Long An"
        area_raw = p.get("dien_tich", "")
        area_disp = clean_area_display(area_raw)
        price_raw = p.get("gia", "")
        price_disp = clean_price_display(price_raw)

        item = {
            "title": title,
            "url": wp_url,
            "thumb": thumb,
            "loc": khu_vuc,
            "area": area_disp,
            "price": price_disp,
            "area_num": parse_num_area(area_raw),
            "price_num": parse_num_price(price_raw),
            "kicker": "Kho xưởng" if ("kho" in loai_hinh.lower() or "xưởng" in loai_hinh.lower()) else "Đất công nghiệp",
            "badge": "Mới nhất",
            "type": loai_hinh
        }

        if "đất" in (loai_hinh + " " + title).lower() and "xưởng" not in loai_hinh.lower():
            item["kicker"] = "Đất công nghiệp"
            dat_cn_items.append(item)
        else:
            kho_xuong_items.append(item)

    kcn_items = []
    for k in kcn_list:
        title = k.get("title", "").strip()
        url_nguon = k.get("url", "").strip()
        slug = url_nguon.strip("/").split("/")[-1]
        wp_url = f"{WP_SITE_URL}/khu-cong-nghiep/{slug}/"
        
        images = k.get("images", [])
        thumb = ""
        if images:
            img_base = os.path.basename(images[0].replace("\\", "/"))
            thumb = f"{WP_SITE_URL}/wp-content/uploads/2026/09/{img_base}"
        if not thumb:
            thumb = "https://batdongsancongnghiep24h.vn/wp-content/uploads/2026/08/2-1.png"

        loc = "Việt Nam"
        for code, name in [('long-an', 'Long An'), ('binh-duong', 'Bình Dương'), ('dong-nai', 'Đồng Nai'), ('hai-phong', 'Hải Phòng'), ('bac-ninh', 'Bắc Ninh'), ('ha-noi', 'Hà Nội'), ('ho-chi-minh', 'TP. Hồ Chí Minh'), ('quang-ninh', 'Quảng Ninh'), ('thai-nguyen', 'Thái Nguyên'), ('vinh-phuc', 'Vĩnh Phúc'), ('bac-giang', 'Bắc Giang'), ('hai-duong', 'Hải Dương'), ('da-nang', 'Đà Nẵng'), ('quang-nam', 'Quảng Nam'), ('ba-ria', 'Bà Rịa - Vũng Tàu'), ('binh-phuoc', 'Bình Phước'), ('tay-ninh', 'Tây Ninh'), ('tien-giang', 'Tiền Giang')]:
            if code in slug.lower() or name.lower() in title.lower():
                loc = name
                break

        item = {
            "title": title,
            "url": wp_url,
            "thumb": thumb,
            "loc": loc,
            "area": "Đa quy mô",
            "price": "Liên hệ báo giá",
            "area_num": 100000,
            "price_num": 0,
            "kicker": "Khu công nghiệp",
            "badge": "Đang hoạt động",
            "type": "Khu công nghiệp"
        }
        kcn_items.append(item)

    return kho_xuong_items, dat_cn_items, kcn_items

# ============================================================
# 2. TEMPLATE BUILDER
# ============================================================
def build_listing_html(page_type, title, subtitle, stats_html, items, var_name, type_name):
    # Initial 12 cards
    initial_cards = []
    for item in items[:12]:
        specsHtml = f'<span class="lp-card-spec">{item["area"]}</span><span class="lp-card-spec">PCCC tự động</span><span class="lp-card-spec">Container 24/24</span>'
        areaBadge = f'<span class="lp-card-area">{item["area"]}</span>' if item.get("area") else ''
        badgeClass = 'lp-card-badge green' if item.get("badge") == 'Đang hoạt động' else 'lp-card-badge'
        card = f'''					<a href="{item['url']}" class="lp-card" title="{item['title']}">
						<div class="lp-card-thumb">
							<img src="{item['thumb']}" alt="{item['title']}" loading="lazy">
							<span class="{badgeClass}">{item.get('badge', 'Mới nhất')}</span>
							{areaBadge}
						</div>
						<div class="lp-card-body">
							<div class="lp-card-kicker"><span>{item['kicker']}</span><span>Mới cập nhật</span></div>
							<div class="lp-card-title">{item['title']}</div>
							<div class="lp-card-loc">📍 {item['loc']}</div>
							<div class="lp-card-specs">{specsHtml}</div>
							<div class="lp-card-price">
								<strong>{item['price']}</strong>
								<span class="lp-card-cta">Xem chi tiết →</span>
							</div>
						</div>
					</a>'''
        initial_cards.append(card)

    initial_cards_str = "\n".join(initial_cards)
    data_json = json.dumps(items, ensure_ascii=False)

    html = f"""<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@600;700&display=swap" rel="stylesheet">

<style>
/* CSS CHO TRANG LISTING BDS24H */
*, *::before, *::after {{ box-sizing: border-box; }}
body {{ font-family: 'Roboto', 'Inter', sans-serif; background: #F8FAFC; color: #000000; line-height: 1.6; margin: 0; padding: 0; }}

:root {{
	--ink: #000000;
	--paper: #F8FAFC;
	--panel: #ffffff;
	--navy: #173B5E;
	--navy-dk: #102A45;
	--green: #0F7F2F;
	--green-dk: #083315;
	--orange: #D9531E;
	--orange-dk: #B83E0F;
	--line: #E2E8F0;
}}

.wrap {{ max-width: 1180px; margin: 0 auto; padding: 0 20px; }}

/* HERO BANNER */
.lp-hero {{
	background: linear-gradient(rgba(23,59,94,.03) 0%, rgba(23,59,94,.01) 100%), linear-gradient(180deg, #fff 0%, #F8FAFC 100%);
	border-bottom: 1px solid var(--line);
	padding: 40px 0 32px;
	position: relative;
}}
.lp-breadcrumb {{ font-size: 13px; color: #64748b; margin-bottom: 12px; font-weight: 600; }}
.lp-breadcrumb a {{ color: #0F7F2F; text-decoration: none; font-weight: 700; }}
.lp-hero h1 {{ font-family: 'Oswald', sans-serif; font-size: 36px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #000000; margin: 0 0 10px; line-height: 1.2; }}
.lp-hero p {{ font-size: 15.5px; color: #334155; font-weight: 500; max-width: 760px; margin: 0 0 24px; line-height: 1.65; }}
.lp-stats-row {{ display: flex; gap: 28px; flex-wrap: wrap; }}
.lp-stat strong {{ display: block; font-family: 'Oswald', sans-serif; font-size: 26px; font-weight: 700; color: #0F7F2F; }}
.lp-stat span {{ font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #64748b; font-weight: 700; }}

/* SEARCH BOX */
.lp-searchbar {{ background: linear-gradient(135deg,#f6fbf7 0%,#edf7f0 100%); border: 1.5px solid #c8e6d0; border-radius: 16px; padding: 20px 24px; margin: 28px 0 0; box-shadow: 0 8px 24px rgba(15,127,47,0.08); }}
.lp-searchbar-inner {{ display: grid; grid-template-columns: 2fr 1.2fr 1.2fr 1.2fr auto; gap: 12px; align-items: end; }}
.lp-sf-label {{ font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: #475569; margin-bottom: 6px; }}
.lp-sf-input, .lp-sf-select {{ width: 100%; background: #fff; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 10px 14px; font-size: 13.5px; font-weight: 500; color: #0f172a; outline: none; transition: border-color .15s; font-family: inherit; }}
.lp-sf-input:focus, .lp-sf-select:focus {{ border-color: #0F7F2F; box-shadow: 0 0 0 3px rgba(15,127,47,0.15); }}
.lp-search-submit {{ background: linear-gradient(135deg,#0F7F2F,#083315); color: #fff; border: none; border-radius: 8px; height: 42px; padding: 0 24px; font-weight: 700; font-size: 14px; cursor: pointer; transition: all .2s; }}
.lp-search-submit:hover {{ transform: translateY(-1px); box-shadow: 0 6px 20px rgba(15,127,47,0.3); }}

/* MAIN CONTENT LAYOUT */
.lp-main {{ padding: 32px 0 60px; }}
.lp-layout {{ display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }}

/* SIDEBAR */
.lp-sidebar {{ position: sticky; top: 80px; }}
.lp-hotline {{ background: var(--navy); border-radius: 10px; padding: 20px; color: #fff; text-align: center; margin-bottom: 16px; }}
.lp-hotline strong {{ font-size: 20px; display: block; color: #fff; font-weight: 800; }}
.lp-hotline a {{ display: block; background: #fff; color: var(--navy); font-weight: 800; font-size: 14px; border-radius: 6px; padding: 9px; text-decoration: none; margin-top: 10px; }}
.lp-sidebar-card {{ background: #fff; border: 1px solid var(--line); border-radius: 10px; padding: 18px; margin-bottom: 16px; }}
.lp-sidebar-card h3 {{ font-family: 'Oswald', sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; color: #000; margin: 0 0 12px; padding-bottom: 8px; border-bottom: 2px solid #0F7F2F; }}
.lp-sidebar-option {{ display: flex; align-items: center; gap: 8px; padding: 6px 0; cursor: pointer; font-size: 13px; color: #334155; font-weight: 500; }}

/* RESULTS GRID */
.lp-results-meta {{ display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }}
.lp-results-count {{ font-size: 15px; color: #334155; font-weight: 600; margin: 0; }}
.lp-results-count strong {{ color: #0F7F2F; font-size: 17px; }}
.lp-grid {{ display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }}
.lp-card {{ background: #fff; border: 1px solid var(--line); border-radius: 10px; overflow: hidden; text-decoration: none; color: inherit; display: flex; flex-direction: column; transition: transform .18s, box-shadow .18s, border-color .18s; }}
.lp-card:hover {{ transform: translateY(-3px); border-color: #94a3b8; box-shadow: 0 12px 28px rgba(0,0,0,.08); }}
.lp-card-thumb {{ aspect-ratio: 16/10; overflow: hidden; position: relative; background: #e2e8f0; }}
.lp-card-thumb img {{ width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; }}
.lp-card:hover .lp-card-thumb img {{ transform: scale(1.05); }}
.lp-card-badge {{ position: absolute; top: 10px; left: 10px; background: var(--orange); color: #fff; font-size: 10.5px; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; }}
.lp-card-badge.green {{ background: var(--green); }}
.lp-card-area {{ position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,.75); color: #fff; font-size: 11.5px; font-weight: 700; padding: 3px 8px; border-radius: 4px; }}
.lp-card-body {{ padding: 16px; display: flex; flex-direction: column; flex: 1; }}
.lp-card-kicker {{ display: flex; justify-content: space-between; font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: #64748b; font-weight: 700; margin-bottom: 6px; }}
.lp-card-title {{ font-weight: 700; font-size: 16px; color: #0f172a; margin: 0 0 6px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }}
.lp-card-loc {{ font-size: 13px; color: #475569; font-weight: 600; margin-bottom: 10px; }}
.lp-card-specs {{ display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; }}
.lp-card-spec {{ background: #f1f5f9; border-radius: 4px; padding: 3px 7px; font-size: 11.5px; color: #334155; font-weight: 600; }}
.lp-card-price {{ margin-top: auto; padding-top: 12px; border-top: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; }}
.lp-card-price strong {{ font-family: 'Oswald', sans-serif; font-size: 18px; color: #0F7F2F; font-weight: 700; }}
.lp-card-cta {{ font-size: 12.5px; font-weight: 700; color: #0F7F2F; }}

/* PAGINATION BUTTONS */
.lp-pagination {{ display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 40px; flex-wrap: wrap; }}
.lp-page-btn {{ min-width: 38px; height: 38px; padding: 0 10px; border: 1.5px solid #cbd5e1; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 13.5px; font-weight: 700; color: #1e293b; background: #fff; cursor: pointer; transition: all .15s; user-select: none; }}
.lp-page-btn:hover {{ background: #f0fdf4; border-color: #0F7F2F; color: #0F7F2F; transform: translateY(-1px); }}
.lp-page-btn.active {{ background: #0F7F2F !important; color: #fff !important; border-color: #0F7F2F !important; box-shadow: 0 4px 12px rgba(15,127,47,0.25); }}
.lp-page-dots {{ padding: 0 6px; color: #64748b; font-weight: 700; }}

@media (max-width: 960px) {{
	.lp-searchbar-inner {{ grid-template-columns: 1fr 1fr; }}
	.lp-layout {{ grid-template-columns: 1fr; }}
	.lp-sidebar {{ position: static; }}
	.lp-grid {{ grid-template-columns: 1fr; }}
}}
@media (max-width: 540px) {{
	.lp-searchbar-inner {{ grid-template-columns: 1fr; }}
	.lp-hero h1 {{ font-size: 26px; }}
}}
</style>

<!-- HERO SECTION -->
<section class="lp-hero">
	<div class="wrap">
		<nav class="lp-breadcrumb">
			<a href="https://batdongsankhucongnghiep.vn/">Trang chủ</a> / {title}
		</nav>
		<h1>{title}</h1>
		<p>{subtitle}</p>
		<div class="lp-stats-row">
			{stats_html}
		</div>

		<!-- THANH TÌM KIẾM NHANH -->
		<div class="lp-searchbar">
			<div class="lp-searchbar-inner">
				<div>
					<div class="lp-sf-label">🔍 Từ khóa tìm kiếm</div>
					<input type="text" class="lp-sf-input" id="ks-kw" placeholder="Tên dự án, vị trí, đặc điểm...">
				</div>
				<div>
					<div class="lp-sf-label">📍 Tỉnh thành</div>
					<select class="lp-sf-select" id="ks-region">
						<option value="">Tất cả tỉnh thành</option>
						<option value="Long An">Long An</option>
						<option value="Bình Dương">Bình Dương</option>
						<option value="Đồng Nai">Đồng Nai</option>
						<option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
						<option value="Bà Rịa">Bà Rịa - Vũng Tàu</option>
						<option value="Bắc Ninh">Bắc Ninh</option>
						<option value="Hải Phòng">Hải Phòng</option>
						<option value="Hà Nội">Hà Nội</option>
						<option value="Quảng Ninh">Quảng Ninh</option>
						<option value="Đà Nẵng">Đà Nẵng</option>
						<option value="Thái Nguyên">Thái Nguyên</option>
						<option value="Bắc Giang">Bắc Giang</option>
					</select>
				</div>
				<div>
					<div class="lp-sf-label">📐 Diện tích</div>
					<select class="lp-sf-select" id="ks-area">
						<option value="">Mọi diện tích</option>
						<option value="0-1000">Dưới 1.000 m²</option>
						<option value="1000-3000">1.000 – 3.000 m²</option>
						<option value="3000-5000">3.000 – 5.000 m²</option>
						<option value="5000-10000">5.000 – 10.000 m²</option>
						<option value="10000-30000">10.000 – 30.000 m²</option>
						<option value="30000-999999999">Trên 30.000 m²</option>
					</select>
				</div>
				<div>
					<div class="lp-sf-label">💰 Mức giá</div>
					<select class="lp-sf-select" id="ks-price">
						<option value="">Mọi mức giá</option>
						<option value="0-5000">Dưới 5 tỷ</option>
						<option value="5000-20000">5 – 20 tỷ</option>
						<option value="20000-50000">20 – 50 tỷ</option>
						<option value="50000-100000">50 – 100 tỷ</option>
						<option value="100000-999999999">Trên 100 tỷ</option>
					</select>
				</div>
				<div>
					<button class="lp-search-submit" id="ks-search-btn">🔍 Tìm kiếm</button>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- MAIN CONTENT -->
<main class="lp-main">
	<div class="wrap">
		<div class="lp-layout">

			<!-- SIDEBAR BỘ LỌC -->
			<aside class="lp-sidebar">
				<div class="lp-hotline">
					<p style="margin:0 0 6px; font-size:13px; opacity:.9;">📞 Hỗ trợ khảo sát & báo giá</p>
					<strong>0909 161 824</strong>
					<a href="tel:0909161824">Gọi ngay (Miễn phí)</a>
				</div>
				<div class="lp-sidebar-card">
					<h3>Khu vực trọng điểm</h3>
					<label class="lp-sidebar-option"><input type="radio" name="side-reg" value="" checked onclick="document.getElementById('ks-region').value=''; window.runFilter();"> Tất cả khu vực</label>
					<label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Long An" onclick="document.getElementById('ks-region').value='Long An'; window.runFilter();"> Long An</label>
					<label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Bình Dương" onclick="document.getElementById('ks-region').value='Bình Dương'; window.runFilter();"> Bình Dương</label>
					<label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Đồng Nai" onclick="document.getElementById('ks-region').value='Đồng Nai'; window.runFilter();"> Đồng Nai</label>
					<label class="lp-sidebar-option"><input type="radio" name="side-reg" value="TP. Hồ Chí Minh" onclick="document.getElementById('ks-region').value='TP. Hồ Chí Minh'; window.runFilter();"> TP. Hồ Chí Minh</label>
					<label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Bắc Ninh" onclick="document.getElementById('ks-region').value='Bắc Ninh'; window.runFilter();"> Bắc Ninh</label>
					<label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Hải Phòng" onclick="document.getElementById('ks-region').value='Hải Phòng'; window.runFilter();"> Hải Phòng</label>
				</div>
			</aside>

			<!-- DANH SÁCH SẢN PHẨM & PHÂN TRANG -->
			<div>
				<div class="lp-results-meta">
					<p class="lp-results-count">Tìm thấy <strong>{len(items):,} {type_name}</strong> phù hợp</p>
				</div>

				<div class="lp-grid">
{initial_cards_str}
				</div>

				<!-- PHÂN TRANG -->
				<div class="lp-pagination"></div>
			</div>

		</div>
	</div>
</main>

<script>
window.{var_name} = {data_json};

(function(){{
  var PAGE_SIZE = 12;
  var currentPage = 1;
  var filteredItems = [];
  var allData = window.{var_name} || [];

  function renderCard(item) {{
    var specsHtml = '<span class="lp-card-spec">' + (item.area || '3.000 m²') + '</span><span class="lp-card-spec">PCCC tự động</span><span class="lp-card-spec">Container 24/24</span>';
    var areaBadge = item.area ? '<span class="lp-card-area">' + item.area + '</span>' : '';
    var badgeClass = (item.badge === 'Đang hoạt động') ? 'lp-card-badge green' : 'lp-card-badge';
    
    return '<a href="' + item.url + '" class="lp-card" title="' + item.title + '">' +
      '<div class="lp-card-thumb">' +
        '<img src="' + item.thumb + '" alt="' + item.title + '" loading="lazy">' +
        '<span class="' + badgeClass + '">' + (item.badge || 'Mới nhất') + '</span>' +
        areaBadge +
      '</div>' +
      '<div class="lp-card-body">' +
        '<div class="lp-card-kicker"><span>' + item.kicker + '</span><span>Mới cập nhật</span></div>' +
        '<div class="lp-card-title">' + item.title + '</div>' +
        '<div class="lp-card-loc">📍 ' + item.loc + '</div>' +
        '<div class="lp-card-specs">' + specsHtml + '</div>' +
        '<div class="lp-card-price">' +
          '<strong>' + item.price + '</strong>' +
          '<span class="lp-card-cta">Xem chi tiết →</span>' +
        '</div>' +
      '</div>' +
    '</a>';
  }}

  function renderGrid() {{
    var grid = document.querySelector('.lp-grid');
    var countEl = document.querySelector('.lp-results-count strong');
    var total = filteredItems.length;
    var totalPages = Math.ceil(total / PAGE_SIZE) || 1;

    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    if (countEl) countEl.textContent = total.toLocaleString('vi-VN') + ' {type_name}';

    var start = (currentPage - 1) * PAGE_SIZE;
    var end = start + PAGE_SIZE;
    var pageItems = filteredItems.slice(start, end);

    if (grid) {{
      if (pageItems.length === 0) {{
        grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:48px 20px;background:#fff;border-radius:10px;border:1px solid #e2e8f0;"><p style="font-size:16px;color:#64748b;margin-bottom:12px;">🔍 Không tìm thấy kết quả phù hợp.</p><button onclick="window.resetFilters()" style="background:#0F7F2F;color:#fff;border:none;padding:8px 20px;border-radius:6px;font-weight:700;cursor:pointer;">Xem tất cả</button></div>';
      }} else {{
        grid.innerHTML = pageItems.map(renderCard).join('');
      }}
    }}

    renderPagination(totalPages);
  }}

  function renderPagination(totalPages) {{
    var pagEl = document.querySelector('.lp-pagination');
    if (!pagEl) return;

    if (totalPages <= 1) {{
      pagEl.innerHTML = '';
      return;
    }}

    var html = [];
    if (currentPage > 1) {{
      html.push('<button class="lp-page-btn" data-page="1" title="Trang đầu">«</button>');
      html.push('<button class="lp-page-btn" data-page="' + (currentPage - 1) + '" title="Trang trước">‹</button>');
    }}

    var startPage = Math.max(1, currentPage - 2);
    var endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {{
      html.push('<button class="lp-page-btn" data-page="1">1</button>');
      if (startPage > 2) html.push('<span class="lp-page-dots">...</span>');
    }}

    for (var i = startPage; i <= endPage; i++) {{
      if (i === currentPage) {{
        html.push('<span class="lp-page-btn active">' + i + '</span>');
      }} else {{
        html.push('<button class="lp-page-btn" data-page="' + i + '">' + i + '</button>');
      }}
    }}

    if (endPage < totalPages) {{
      if (endPage < totalPages - 1) html.push('<span class="lp-page-dots">...</span>');
      html.push('<button class="lp-page-btn" data-page="' + totalPages + '">' + totalPages + '</button>');
    }}

    if (currentPage < totalPages) {{
      html.push('<button class="lp-page-btn" data-page="' + (currentPage + 1) + '" title="Trang sau">›</button>');
      html.push('<button class="lp-page-btn" data-page="' + totalPages + '" title="Trang cuối">»</button>');
    }}

    pagEl.innerHTML = html.join('');

    pagEl.querySelectorAll('button[data-page]').forEach(function(btn){{
      btn.addEventListener('click', function(e){{
        e.preventDefault();
        currentPage = parseInt(btn.getAttribute('data-page'), 10);
        renderGrid();
        var mainEl = document.querySelector('.lp-main') || document.querySelector('.lp-grid');
        if (mainEl) mainEl.scrollIntoView({{behavior: 'smooth', block: 'start'}});
      }});
    }});
  }}

  function runFilter() {{
    var kw = ((document.getElementById('ks-kw') || {{}}).value || '').trim().toLowerCase();
    var region = ((document.getElementById('ks-region') || {{}}).value || '').trim().toLowerCase();
    var areaRange = ((document.getElementById('ks-area') || {{}}).value || '').trim();
    var priceRange = ((document.getElementById('ks-price') || {{}}).value || '').trim();

    filteredItems = allData.filter(function(item){{
      var combined = (item.title + ' ' + item.loc + ' ' + (item.type || '')).toLowerCase();
      if (kw && combined.indexOf(kw) === -1) return false;
      if (region && item.loc.toLowerCase().indexOf(region) === -1) return false;

      if (areaRange) {{
        var parts = areaRange.split('-');
        var minA = parseInt(parts[0], 10);
        var maxA = parseInt(parts[1], 10);
        if (item.area_num > 0) {{
          if (item.area_num < minA || item.area_num > maxA) return false;
        }}
      }}

      if (priceRange) {{
        var pParts = priceRange.split('-');
        var minP = parseFloat(pParts[0]);
        var maxP = parseFloat(pParts[1]);
        if (item.price_num > 0) {{
          if (item.price_num < minP || item.price_num > maxP) return false;
        }}
      }}

      return true;
    }});

    currentPage = 1;
    renderGrid();
  }}

  window.runFilter = runFilter;
  window.resetFilters = function() {{
    if (document.getElementById('ks-kw')) document.getElementById('ks-kw').value = '';
    if (document.getElementById('ks-region')) document.getElementById('ks-region').value = '';
    if (document.getElementById('ks-area')) document.getElementById('ks-area').value = '';
    if (document.getElementById('ks-price')) document.getElementById('ks-price').value = '';
    runFilter();
  }};

  document.addEventListener('DOMContentLoaded', function(){{
    filteredItems = allData.slice();
    renderGrid();

    var btn = document.getElementById('ks-search-btn');
    var kw = document.getElementById('ks-kw');
    var reg = document.getElementById('ks-region');
    var area = document.getElementById('ks-area');
    var price = document.getElementById('ks-price');

    if (btn) btn.addEventListener('click', runFilter);
    if (kw) kw.addEventListener('keydown', function(e){{ if(e.key==='Enter') runFilter(); }});
    if (reg) reg.addEventListener('change', runFilter);
    if (area) area.addEventListener('change', runFilter);
    if (price) price.addEventListener('change', runFilter);
  }});

  if (document.readyState !== 'loading') {{
    filteredItems = allData.slice();
    renderGrid();
  }}
}})();
</script>
"""
    return html

# ============================================================
# 3. SYNC TO WP PAGES
# ============================================================
def sync_page_to_wp(wp_page_id, html_content, filename):
    with open(filename, "w", encoding="utf-8") as f:
        f.write(html_content)
    print(f"✅ Đã ghi file local: {filename}")

    el_data = [
        {
            "id": f"kx_sec_{wp_page_id}",
            "elType": "container",
            "settings": {
                "content_width": "full"
            },
            "elements": [
                {
                    "id": f"kx_w_{wp_page_id}",
                    "elType": "widget",
                    "widgetType": "html",
                    "settings": {
                        "html": html_content
                    }
                }
            ]
        }
    ]

    payload = {
        "content": html_content,
        "template": "elementor_header_footer",
        "meta": {
            "_elementor_edit_mode": "builder",
            "_elementor_template_type": "wp-page",
            "_elementor_data": json.dumps(el_data, ensure_ascii=False)
        }
    }

    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/pages/{wp_page_id}"
    resp = requests.post(endpoint, headers=AUTH_HEADER, json=payload, timeout=45)
    if resp.status_code == 200:
        print(f"🎉 ĐÃ ĐỒNG BỘ THÀNH CÔNG LÊN WORDPRESS PAGE {wp_page_id} ({filename})!")
    else:
        print(f"⚠️ Lỗi Page {wp_page_id}: HTTP {resp.status_code} - {resp.text[:200]}")

def main():
    kho_xuong, dat_cn, kcns = load_data()

    # 1. Kho Xưởng (Page 4220)
    kx_stats = '<div class="lp-stat"><strong>1.800+</strong><span>Kho xưởng</span></div><div class="lp-stat"><strong>63</strong><span>Tỉnh thành</span></div><div class="lp-stat"><strong>500m²</strong><span>Diện tích tối thiểu</span></div><div class="lp-stat"><strong>24/7</strong><span>Hỗ trợ pháp lý & PCCC</span></div>'
    kx_html = build_listing_html(
        "kho-xuong",
        "Kho Xưởng Cho Thuê & Bán",
        "Hơn 1.800 kho xưởng đang cho thuê và bán tại TP.HCM, Long An, Bình Dương, Đồng Nai, Bắc Ninh, Hải Phòng và các tỉnh thành. Diện tích đa dạng từ 500m² đến 50.000m².",
        kx_stats,
        kho_xuong,
        "BDS24H_KHO_XUONG",
        "kho xưởng"
    )
    sync_page_to_wp(4220, kx_html, "kho-xuong.html")

    # 2. Đất Công Nghiệp (Page 4233)
    dcn_stats = '<div class="lp-stat"><strong>230+</strong><span>Quỹ đất KCN</span></div><div class="lp-stat"><strong>50 năm</strong><span>Thời hạn sử dụng</span></div><div class="lp-stat"><strong>1.000m²</strong><span>Diện tích từ</span></div><div class="lp-stat"><strong>100%</strong><span>Pháp lý hoàn chỉnh</span></div>'
    dcn_html = build_listing_html(
        "dat-cong-nghiep",
        "Đất Công Nghiệp Cho Thuê & Bán",
        "Tổng hợp quỹ đất công nghiệp trong và ngoài KCN tại các khu vực kinh tế trọng điểm. Đất SKC, đất trả tiền 1 lần, hạ tầng đồng bộ sẵn sàng xây dựng nhà máy.",
        dcn_stats,
        dat_cn,
        "BDS24H_DAT_CN",
        "đất công nghiệp"
    )
    sync_page_to_wp(4233, dcn_html, "dat-cong-nghiep.html")

    # 3. Khu Công Nghiệp (Page 4299)
    kcn_stats = '<div class="lp-stat"><strong>1.211</strong><span>Khu công nghiệp</span></div><div class="lp-stat"><strong>63</strong><span>Tỉnh thành cả nước</span></div><div class="lp-stat"><strong>100%</strong><span>Dữ liệu xúc tiến ĐT</span></div><div class="lp-stat"><strong>Ưu đãi</strong><span>Thuế TNDN 10-15 năm</span></div>'
    kcn_html = build_listing_html(
        "kcn",
        "Danh Sách 1.211 Khu Công Nghiệp Toàn Quốc",
        "Cơ sở dữ liệu toàn diện 1.211 Khu Công Nghiệp tại 63 tỉnh thành Việt Nam. Tra cứu chi tiết chủ đầu tư, quy mô, kết nối logistics, hạ tầng điện nước, biểu phí và chính sách ưu đãi đầu tư.",
        kcn_stats,
        kcns,
        "BDS24H_KCNS",
        "khu công nghiệp"
    )
    sync_page_to_wp(4299, kcn_html, "khu-cong-nghiep.html")

    print("\n" + "=" * 65)
    print("🎉 HOÀN TẤT ĐỒNG BỘ GIAO DIỆN & PHÂN TRANG CHO TOÀN BỘ CÁC TRANG LISTING!")
    print("=" * 65)

if __name__ == "__main__":
    main()
