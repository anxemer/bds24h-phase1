# -*- coding: utf-8 -*-
"""
FILE: deploy_full_listings.py
MỤC ĐÍCH:
    Đồng bộ toàn bộ 100% sản phẩm và KCN vào các trang listing:
    1. Sửa triệt để lỗi "tỷ tỷ" (duplicate đơn vị).
    2. Sửa màu sắc, độ tương phản của Sidebar Hotline (chữ vàng/trắng nổi bật trên nền xanh navy).
    3. Căn chỉnh giao diện Radio bộ lọc tỉnh thành, Card sản phẩm và Phân trang.
    4. Cập nhật đồng bộ lên WordPress Page 4220, 4233, 4299.
"""

import os
import re
import json
import base64
import requests

WP_SITE_URL     = "https://batdongsankhucongnghiep.vn"
WP_USERNAME     = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}", "Content-Type": "application/json"}

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
    
    # Chuẩn hóa nếu có số tiền lớn
    num_clean = re.sub(r'[^\d]', '', gia_str)
    if num_clean and len(num_clean) >= 7:
        num = float(num_clean)
        if num >= 1_000_000_000:
            ty = num / 1_000_000_000
            val_str = f"{ty:.2f}".rstrip('0').rstrip('.').replace('.', ',')
            return f"{val_str} tỷ"
        elif num >= 1_000_000:
            trieu = num / 1_000_000
            val_str = f"{trieu:.1f}".rstrip('0').rstrip('.').replace('.', ',')
            return f"{val_str} triệu"
            
    # Xử lý trường hợp bị lặp từ tỷ hoặc triệu
    gia_str = re.sub(r'\s*tỷ\s*tỷ', ' tỷ', gia_str, flags=re.IGNORECASE)
    gia_str = re.sub(r'\s*triệu\s*triệu', ' triệu', gia_str, flags=re.IGNORECASE)
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

def load_all_data():
    print("⏳ Đang đọc dữ liệu từ local JSON...")
    
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
        for code, name in [
            ('long-an', 'Long An'), ('binh-duong', 'Bình Dương'), ('dong-nai', 'Đồng Nai'),
            ('hai-phong', 'Hải Phòng'), ('bac-ninh', 'Bắc Ninh'), ('ha-noi', 'Hà Nội'),
            ('ho-chi-minh', 'TP. Hồ Chí Minh'), ('quang-ninh', 'Quảng Ninh'),
            ('thai-nguyen', 'Thái Nguyên'), ('vinh-phuc', 'Vĩnh Phúc'),
            ('bac-giang', 'Bắc Giang'), ('hai-duong', 'Hải Dương'), ('da-nang', 'Đà Nẵng'),
            ('quang-nam', 'Quảng Nam'), ('ba-ria', 'Bà Rịa - Vũng Tàu'),
            ('binh-phuoc', 'Bình Phước'), ('tay-ninh', 'Tây Ninh'), ('tien-giang', 'Tiền Giang')
        ]:
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

    print(f"   => Kho xưởng: {len(kho_xuong_items)} items")
    print(f"   => Đất CN: {len(dat_cn_items)} items")
    print(f"   => KCN: {len(kcn_items)} items")

    return kho_xuong_items, dat_cn_items, kcn_items

def build_listing_page_html(page_type, page_title, page_desc, items, var_name):
    # CSS hoàn chỉnh, siêu tương thích WordPress
    css_content = """
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Roboto', 'Inter', system-ui, sans-serif; background: #F8FAFC; color: #0f172a; line-height: 1.6; margin: 0; padding: 0; }
:root { --ink: #0f172a; --paper: #F8FAFC; --panel: #ffffff; --navy: #173B5E; --navy-dk: #102A45; --green: #0F7F2F; --green-dk: #083315; --orange: #D9531E; --line: #E2E8F0; }
.wrap { max-width: 1200px; margin: 0 auto; padding: 0 16px; width: 100%; box-sizing: border-box; }
.lp-hero { background: linear-gradient(rgba(23,59,94,.03) 0%, rgba(23,59,94,.01) 100%), linear-gradient(180deg, #ffffff 0%, #F8FAFC 100%); border-bottom: 1px solid var(--line); padding: 36px 0 28px; position: relative; }
.lp-breadcrumb { font-size: 13.5px; color: #64748b; margin-bottom: 12px; font-weight: 600; }
.lp-breadcrumb a { color: #0F7F2F; text-decoration: none; font-weight: 700; }
.lp-hero h1 { font-family: 'Oswald', sans-serif; font-size: 32px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #0f172a; margin: 0 0 10px; line-height: 1.25; }
.lp-hero p { font-size: 14.5px; color: #334155; font-weight: 500; max-width: 800px; margin: 0 0 20px; line-height: 1.6; }
.lp-stats-row { display: flex; gap: 20px; flex-wrap: wrap; }
.lp-stat strong { display: block; font-family: 'Oswald', sans-serif; font-size: 24px; font-weight: 700; color: #0F7F2F; }
.lp-stat span { font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: #64748b; font-weight: 700; }
.lp-searchbar { background: linear-gradient(135deg,#f6fbf7 0%,#edf7f0 100%); border: 1.5px solid #c8e6d0; border-radius: 12px; padding: 16px 20px; margin: 22px 0 0; box-shadow: 0 6px 20px rgba(15,127,47,0.06); }
.lp-searchbar-inner { display: grid; grid-template-columns: 2fr 1.2fr 1.2fr 1.2fr auto; gap: 10px; align-items: end; }
.lp-sf-label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: #334155; margin-bottom: 5px; }
.lp-sf-input, .lp-sf-select { width: 100%; background: #fff; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 8px 10px; font-size: 13px; font-weight: 500; color: #0f172a; outline: none; transition: border-color .15s; font-family: inherit; }
.lp-sf-input:focus, .lp-sf-select:focus { border-color: #0F7F2F; box-shadow: 0 0 0 3px rgba(15,127,47,0.15); }
.lp-search-submit { background: linear-gradient(135deg,#0F7F2F,#083315); color: #ffffff !important; border: none; border-radius: 8px; height: 38px; padding: 0 20px; font-weight: 700; font-size: 13px; cursor: pointer; transition: all .2s; }
.lp-search-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(15,127,47,0.3); }
.lp-main { padding: 28px 0 50px; }
.lp-layout { display: grid !important; grid-template-columns: 260px 1fr !important; gap: 24px !important; align-items: start !important; width: 100% !important; }
.lp-sidebar { position: sticky; top: 80px; }
.lp-hotline { background: linear-gradient(135deg, #173B5E 0%, #102A45 100%) !important; border-radius: 12px; padding: 18px 14px; color: #ffffff !important; text-align: center; margin-bottom: 16px; box-shadow: 0 8px 20px rgba(23,59,94,0.15); border: 1px solid rgba(255,255,255,0.1); }
.lp-hotline-title { color: #cbd5e1 !important; margin: 0 0 6px !important; font-size: 13px !important; font-weight: 600 !important; }
.lp-hotline-num { font-size: 20px !important; display: block !important; color: #FFD166 !important; font-weight: 900 !important; letter-spacing: 0.5px; margin-bottom: 4px; }
.lp-hotline-btn { display: block !important; background: #ffffff !important; color: #173B5E !important; font-weight: 800 !important; font-size: 13px !important; border-radius: 7px !important; padding: 8px 12px !important; text-decoration: none !important; margin-top: 8px; transition: transform .15s, box-shadow .15s; }
.lp-hotline-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.lp-sidebar-card { background: #ffffff; border: 1px solid var(--line); border-radius: 12px; padding: 16px; margin-bottom: 16px; }
.lp-sidebar-card h3 { font-family: 'Oswald', sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; color: #0f172a; margin: 0 0 10px; padding-bottom: 8px; border-bottom: 2px solid #0F7F2F; letter-spacing: 0.3px; }
.lp-sidebar-option { display: flex; align-items: center; gap: 8px; padding: 6px 8px; cursor: pointer; font-size: 13px; color: #334155; font-weight: 500; border-radius: 6px; transition: background .12s; }
.lp-sidebar-option:hover { background: #f1f5f9; }
.lp-sidebar-option input { accent-color: #0F7F2F; width: 15px; height: 15px; cursor: pointer; }
.lp-results-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
.lp-results-count { font-size: 14.5px; color: #334155; font-weight: 600; margin: 0; }
.lp-results-count strong { color: #0F7F2F; font-size: 16px; font-weight: 800; }
.lp-sort-select { background: #fff; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 6px 10px; font-size: 13px; font-weight: 600; color: #0f172a; outline: none; cursor: pointer; }
.lp-grid { display: grid !important; grid-template-columns: repeat(3, minmax(0, 1fr)) !important; gap: 16px !important; min-height: 400px !important; width: 100% !important; list-style: none !important; margin: 0 !important; padding: 0 !important; }
.lp-card { display: flex !important; flex-direction: column !important; width: 100% !important; min-width: 0 !important; max-width: 100% !important; float: none !important; clear: none !important; margin: 0 !important; background: #ffffff !important; border: 1px solid var(--line) !important; border-radius: 12px !important; overflow: hidden !important; text-decoration: none !important; color: inherit !important; box-sizing: border-box !important; transition: transform .18s, box-shadow .18s, border-color .18s !important; }
.lp-card:hover { transform: translateY(-3px) !important; border-color: #94a3b8 !important; box-shadow: 0 12px 28px rgba(0,0,0,.08) !important; }
.lp-card-thumb { aspect-ratio: 16/10 !important; width: 100% !important; overflow: hidden !important; position: relative !important; background: #e2e8f0 !important; display: block !important; }
.lp-card-thumb img { width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important; transition: transform .3s ease !important; }
.lp-card:hover .lp-card-thumb img { transform: scale(1.05) !important; }
.lp-card-badge { position: absolute; top: 8px; left: 8px; background: var(--orange); color: #fff; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 4px; text-transform: uppercase; }
.lp-card-badge.green { background: var(--green); }
.lp-card-area { position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,.75); color: #fff; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px; }
.lp-card-body { padding: 14px !important; display: flex !important; flex-direction: column !important; flex: 1 1 auto !important; }
.lp-card-kicker { display: flex; justify-content: space-between; font-size: 10.5px; text-transform: uppercase; letter-spacing: .04em; color: #64748b; font-weight: 700; margin-bottom: 5px; }
.lp-card-title { font-weight: 700 !important; font-size: 14.5px !important; color: #0f172a !important; margin: 0 0 6px !important; line-height: 1.4 !important; display: -webkit-box !important; -webkit-line-clamp: 2 !important; -webkit-box-orient: vertical !important; overflow: hidden !important; }
.lp-card-loc { font-size: 12.5px; color: #475569; font-weight: 600; margin-bottom: 8px; }
.lp-card-specs { display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 10px; }
.lp-card-spec { background: #f1f5f9; border-radius: 4px; padding: 2px 6px; font-size: 11px; color: #334155; font-weight: 600; }
.lp-card-price { margin-top: auto !important; padding-top: 10px !important; border-top: 1px solid var(--line) !important; display: flex !important; align-items: center !important; justify-content: space-between !important; }
.lp-card-price strong { font-family: 'Oswald', sans-serif; font-size: 16.5px; color: #0F7F2F; font-weight: 700; }
.lp-card-cta { font-size: 12px; font-weight: 700; color: #0F7F2F; }
.lp-pagination { display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 36px; flex-wrap: wrap; }
.lp-page-btn { min-width: 36px; height: 36px; padding: 0 10px; border: 1.5px solid #cbd5e1; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #1e293b; background: #fff; cursor: pointer; transition: all .15s; user-select: none; }
.lp-page-btn:hover { background: #f0fdf4; border-color: #0F7F2F; color: #0F7F2F; transform: translateY(-1px); }
.lp-page-btn.active { background: #0F7F2F !important; color: #fff !important; border-color: #0F7F2F !important; box-shadow: 0 4px 12px rgba(15,127,47,0.25); }
.lp-page-dots { padding: 0 6px; color: #64748b; font-weight: 700; }
@media (max-width: 1100px) { .lp-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; } }
@media (max-width: 960px) { .lp-searchbar-inner { grid-template-columns: 1fr 1fr !important; } .lp-layout { grid-template-columns: 1fr !important; } .lp-sidebar { position: static !important; } .lp-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; } }
@media (max-width: 600px) { .lp-searchbar-inner { grid-template-columns: 1fr !important; } .lp-grid { grid-template-columns: 1fr !important; } .lp-hero h1 { font-size: 24px !important; } }
"""
    clean_css = " ".join([l.strip() for l in css_content.splitlines() if l.strip()])

    fonts_and_css = f"""<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@600;700&display=swap" rel="stylesheet"><style>{clean_css}</style>"""

    if page_type == "kho_xuong":
        stats_html = '<div class="lp-stat"><strong>1.870+</strong><span>Kho xưởng cho thuê & bán</span></div><div class="lp-stat"><strong>100%</strong><span>Ảnh thật chính chủ</span></div><div class="lp-stat"><strong>500m² – 50.000m²</strong><span>Đa dạng diện tích</span></div><div class="lp-stat"><strong>24/7</strong><span>Hỗ trợ pháp lý & PCCC</span></div>'
        sidebar_title = "Tư vấn kho xưởng"
        item_label = "kho xưởng"
    elif page_type == "dat_cn":
        stats_html = '<div class="lp-stat"><strong>237+</strong><span>Quỹ đất KCN & ngoài KCN</span></div><div class="lp-stat"><strong>50 năm</strong><span>Thời hạn sử dụng</span></div><div class="lp-stat"><strong>1.000m² – 100ha</strong><span>Diện tích linh hoạt</span></div><div class="lp-stat"><strong>100%</strong><span>Pháp lý hoàn chỉnh</span></div>'
        sidebar_title = "Tư vấn đất công nghiệp"
        item_label = "đất công nghiệp"
    else:
        stats_html = '<div class="lp-stat"><strong>1.211</strong><span>Khu công nghiệp toàn quốc</span></div><div class="lp-stat"><strong>63</strong><span>Tỉnh thành</span></div><div class="lp-stat"><strong>100%</strong><span>Hạ tầng hoàn chỉnh</span></div><div class="lp-stat"><strong>2026</strong><span>Dữ liệu cập nhật</span></div>'
        sidebar_title = "Tư vấn đầu tư KCN"
        item_label = "khu công nghiệp"

    # Initial 12 cards
    initial_cards = []
    for item in items[:12]:
        specsHtml = f'<span class="lp-card-spec">{item["area"]}</span><span class="lp-card-spec">PCCC tự động</span><span class="lp-card-spec">Container 24/24</span>'
        areaBadge = f'<span class="lp-card-area">{item["area"]}</span>' if item.get("area") else ''
        badgeClass = 'lp-card-badge green' if item.get("badge") == 'Đang hoạt động' else 'lp-card-badge'
        card = f'''<a href="{item['url']}" class="lp-card" title="{item['title']}"><div class="lp-card-thumb"><img src="{item['thumb']}" alt="{item['title']}" loading="lazy"><span class="{badgeClass}">{item.get('badge', 'Mới nhất')}</span>{areaBadge}</div><div class="lp-card-body"><div class="lp-card-kicker"><span>{item['kicker']}</span><span>Mới cập nhật</span></div><div class="lp-card-title">{item['title']}</div><div class="lp-card-loc">📍 {item['loc']}</div><div class="lp-card-specs">{specsHtml}</div><div class="lp-card-price"><strong>{item['price']}</strong><span class="lp-card-cta">Xem chi tiết →</span></div></div></a>'''
        initial_cards.append(card)

    cards_html = "".join(initial_cards)

    # Hero & Layout HTML
    body_html = f"""<section class="lp-hero"><div class="wrap"><nav class="lp-breadcrumb"><a href="https://batdongsankhucongnghiep.vn/">Trang chủ</a> / {page_title}</nav><h1>{page_title}</h1><p>{page_desc}</p><div class="lp-stats-row">{stats_html}</div><div class="lp-searchbar"><div class="lp-searchbar-inner"><div><div class="lp-sf-label">🔍 Từ khóa tìm kiếm</div><input type="text" class="lp-sf-input" id="ks-kw" placeholder="Tên dự án, vị trí, đặc điểm..."></div><div><div class="lp-sf-label">📍 Tỉnh thành</div><select class="lp-sf-select" id="ks-region"><option value="">Tất cả tỉnh thành</option><option value="Long An">Long An</option><option value="Bình Dương">Bình Dương</option><option value="Đồng Nai">Đồng Nai</option><option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option><option value="Bà Rịa">Bà Rịa - Vũng Tàu</option><option value="Bắc Ninh">Bắc Ninh</option><option value="Hải Phòng">Hải Phòng</option><option value="Hà Nội">Hà Nội</option><option value="Quảng Ninh">Quảng Ninh</option><option value="Đà Nẵng">Đà Nẵng</option><option value="Thái Nguyên">Thái Nguyên</option><option value="Bắc Giang">Bắc Giang</option><option value="Tây Ninh">Tây Ninh</option><option value="Vĩnh Phúc">Vĩnh Phúc</option><option value="Hải Dương">Hải Dương</option></select></div><div><div class="lp-sf-label">📐 Diện tích</div><select class="lp-sf-select" id="ks-area"><option value="">Mọi diện tích</option><option value="0-1000">Dưới 1.000 m²</option><option value="1000-3000">1.000 – 3.000 m²</option><option value="3000-5000">3.000 – 5.000 m²</option><option value="5000-10000">5.000 – 10.000 m²</option><option value="10000-30000">10.000 – 30.000 m²</option><option value="30000-999999999">Trên 30.000 m²</option></select></div><div><div class="lp-sf-label">💰 Mức giá</div><select class="lp-sf-select" id="ks-price"><option value="">Mọi mức giá</option><option value="0-5000">Dưới 5 tỷ / 50 tr</option><option value="5000-20000">5 – 20 tỷ / 200 tr</option><option value="20000-50000">20 – 50 tỷ / 500 tr</option><option value="50000-100000">50 – 100 tỷ / 1 tỷ</option><option value="100000-999999999">Trên 100 tỷ / 1 tỷ+</option></select></div><div><button class="lp-search-submit" id="ks-search-btn">🔍 Tìm kiếm</button></div></div></div></div></section><main class="lp-main"><div class="wrap"><div class="lp-layout"><aside class="lp-sidebar"><div class="lp-hotline"><p class="lp-hotline-title">📞 {sidebar_title}</p><strong class="lp-hotline-num">0909 161 824</strong><a href="tel:0909161824" class="lp-hotline-btn">Gọi ngay (Miễn phí)</a></div><div class="lp-sidebar-card"><h3>Khu vực trọng điểm</h3><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="" checked onclick="document.getElementById('ks-region').value=''; if(window.runFilter) window.runFilter();"> Tất cả khu vực</label><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Long An" onclick="document.getElementById('ks-region').value='Long An'; if(window.runFilter) window.runFilter();"> Long An</label><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Bình Dương" onclick="document.getElementById('ks-region').value='Bình Dương'; if(window.runFilter) window.runFilter();"> Bình Dương</label><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Đồng Nai" onclick="document.getElementById('ks-region').value='Đồng Nai'; if(window.runFilter) window.runFilter();"> Đồng Nai</label><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="TP. Hồ Chí Minh" onclick="document.getElementById('ks-region').value='TP. Hồ Chí Minh'; if(window.runFilter) window.runFilter();"> TP. Hồ Chí Minh</label><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Bắc Ninh" onclick="document.getElementById('ks-region').value='Bắc Ninh'; if(window.runFilter) window.runFilter();"> Bắc Ninh</label><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Hải Phòng" onclick="document.getElementById('ks-region').value='Hải Phòng'; if(window.runFilter) window.runFilter();"> Hải Phòng</label><label class="lp-sidebar-option"><input type="radio" name="side-reg" value="Tây Ninh" onclick="document.getElementById('ks-region').value='Tây Ninh'; if(window.runFilter) window.runFilter();"> Tây Ninh</label></div></aside><div><div class="lp-results-meta"><p class="lp-results-count">Tìm thấy <strong id="lp-count-val">{len(items):,} {item_label}</strong> phù hợp</p><div><label style="font-size:13px; font-weight:700; color:#475569; margin-right:6px;">Sắp xếp:</label><select class="lp-sort-select" id="ks-sort"><option value="newest">Mới nhất</option><option value="area-asc">Diện tích: Nhỏ đến Lớn</option><option value="area-desc">Diện tích: Lớn đến Nhỏ</option><option value="price-asc">Giá: Thấp đến Cao</option></select></div></div><div class="lp-grid" id="lp-grid">{cards_html}</div><div class="lp-pagination" id="lp-pagination"></div></div></div></div></main>"""

    # Client-side JavaScript Pagination Engine
    data_json = json.dumps(items, ensure_ascii=False)
    js_engine = f"""<script>
window.{var_name} = {data_json};
(function(){{
  var PAGE_SIZE = 12;
  var currentPage = 1;
  var filteredItems = [];
  var allData = window.{var_name} || [];

  function formatCount(n) {{
    return n.toString().replace(/\\B(?=(\\d{{3}})+(?!\\d))/g, ".");
  }}

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
    var grid = document.getElementById('lp-grid') || document.querySelector('.lp-grid');
    var countEl = document.getElementById('lp-count-val');
    var total = filteredItems.length;
    var totalPages = Math.ceil(total / PAGE_SIZE) || 1;

    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    if (countEl) countEl.textContent = formatCount(total) + ' {item_label}';

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
    var pagEl = document.getElementById('lp-pagination') || document.querySelector('.lp-pagination');
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
        var heroEl = document.querySelector('.lp-results-meta') || document.querySelector('.lp-grid');
        if (heroEl) heroEl.scrollIntoView({{behavior: 'smooth', block: 'start'}});
      }});
    }});
  }}

  function runFilter() {{
    var kw = ((document.getElementById('ks-kw') || {{}}).value || '').trim().toLowerCase();
    var region = ((document.getElementById('ks-region') || {{}}).value || '').trim().toLowerCase();
    var areaRange = ((document.getElementById('ks-area') || {{}}).value || '').trim();
    var priceRange = ((document.getElementById('ks-price') || {{}}).value || '').trim();
    var sort = ((document.getElementById('ks-sort') || {{}}).value || 'newest');

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

    if (sort === 'area-asc') {{
      filteredItems.sort(function(a, b){{ return (a.area_num || 0) - (b.area_num || 0); }});
    }} else if (sort === 'area-desc') {{
      filteredItems.sort(function(a, b){{ return (b.area_num || 0) - (a.area_num || 0); }});
    }} else if (sort === 'price-asc') {{
      filteredItems.sort(function(a, b){{ return (a.price_num || 0) - (b.price_num || 0); }});
    }}

    currentPage = 1;
    renderGrid();
  }}

  window.runFilter = runFilter;
  window.resetFilters = function() {{
    if (document.getElementById('ks-kw')) document.getElementById('ks-kw').value = '';
    if (document.getElementById('ks-region')) document.getElementById('ks-region').value = '';
    if (document.getElementById('ks-area')) document.getElementById('ks-area').value = '';
    if (document.getElementById('ks-price')) document.getElementById('ks-price').value = '';
    if (document.getElementById('ks-sort')) document.getElementById('ks-sort').value = 'newest';
    document.querySelectorAll('input[name="side-reg"]').forEach(function(r){{ if (r.value === '') r.checked = true; }});
    runFilter();
  }};

  function init() {{
    filteredItems = allData.slice();
    renderGrid();

    var btn = document.getElementById('ks-search-btn');
    var kw = document.getElementById('ks-kw');
    var reg = document.getElementById('ks-region');
    var area = document.getElementById('ks-area');
    var price = document.getElementById('ks-price');
    var sort = document.getElementById('ks-sort');

    if (btn) btn.addEventListener('click', runFilter);
    if (kw) kw.addEventListener('keydown', function(e){{ if(e.key === 'Enter') runFilter(); }});
    if (reg) reg.addEventListener('change', runFilter);
    if (area) area.addEventListener('change', runFilter);
    if (price) price.addEventListener('change', runFilter);
    if (sort) sort.addEventListener('change', runFilter);
  }}

  if (document.readyState === 'loading') {{
    document.addEventListener('DOMContentLoaded', init);
  }} else {{
    init();
  }}
}})();
</script>"""

    return fonts_and_css + "\n" + body_html + "\n" + js_engine

def deploy_page(pid, filename, full_html, slug):
    print(f"\n🚀 Đang triển khai Page {pid} ({slug}) - Dung lượng HTML: {len(full_html):,} bytes...")

    with open(filename, "w", encoding="utf-8") as f:
        f.write(full_html)
    print(f"✅ Đã lưu file: {filename}")

    # Minify HTML để wpautop không bao giờ chèn <p> hay <br>
    # Giữ nguyên cấu trúc thẻ và script
    lines = [l.strip() for l in full_html.splitlines() if l.strip()]
    minified_html = "\n".join(lines)

    payload = {
        "content": minified_html,
        "template": "elementor_header_footer",
        "meta": {
            "_elementor_edit_mode": "",
            "_elementor_template_type": "wp-page"
        }
    }

    headers = get_auth_header()
    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/pages/{pid}"
    resp = requests.post(endpoint, headers=headers, json=payload, timeout=90)

    if resp.status_code == 200:
        print(f"🎉 CẬP NHẬT THÀNH CÔNG LÊN WORDPRESS PAGE {pid} ({slug})!")
    else:
        print(f"❌ Lỗi cập nhật Page {pid}: HTTP {resp.status_code} - {resp.text[:300]}")
        return

    # Kiểm tra trực tiếp trên live
    r_live = requests.get(f"{WP_SITE_URL}/{slug}/", timeout=30)
    print(f"   Live status: {r_live.status_code} | Len: {len(r_live.text):,}")
    print(f"   Có data JSON: {'window.BDS24H_' in r_live.text}")
    print(f"   Lỗi 'tỷ tỷ': {'tỷ tỷ' in r_live.text}")
    print(f"   Hotline title styled: {'lp-hotline-title' in r_live.text}")

def main():
    kho_xuong, dat_cn, kcns = load_all_data()

    # 1. Page 4220: Kho Xưởng
    kx_html = build_listing_page_html(
        page_type="kho_xuong",
        page_title="Kho Xưởng Cho Thuê & Bán",
        page_desc="Hệ thống kho xưởng, nhà máy sản xuất hiện đại tại các khu kinh tế trọng điểm. Tiêu chuẩn PCCC tự động, trạm điện công suất lớn, đường xe container 24/24.",
        items=kho_xuong,
        var_name="BDS24H_KHO_XUONG"
    )
    deploy_page(4220, "kho-xuong.html", kx_html, "kho-xuong")

    # 2. Page 4233: Đất Công Nghiệp
    dcn_html = build_listing_page_html(
        page_type="dat_cn",
        page_title="Đất Công Nghiệp Cho Thuê & Bán",
        page_desc="Tổng hợp quỹ đất công nghiệp trong và ngoài KCN tại các khu vực kinh tế trọng điểm. Đất SKC, đất trả tiền 1 lần, hạ tầng đồng bộ sẵn sàng xây dựng nhà máy.",
        items=dat_cn,
        var_name="BDS24H_DAT_CN"
    )
    deploy_page(4233, "dat-cong-nghiep.html", dcn_html, "dat-cong-nghiep")

    # 3. Page 4299: Khu Công Nghiệp
    kcn_html = build_listing_page_html(
        page_type="kcn",
        page_title="Hồ Sơ Khu Công Nghiệp Việt Nam",
        page_desc="Tra cứu bảng giá thuê đất, tỷ lệ lấp đầy, quy hoạch hạ tầng và chính sách ưu đãi đầu tư tại 1.200+ Khu công nghiệp trên toàn quốc.",
        items=kcns,
        var_name="BDS24H_KCNS"
    )
    deploy_page(4299, "khu-cong-nghiep.html", kcn_html, "kcn")

    print("\n" + "=" * 65)
    print("🎉 HOÀN TẤT ĐỒNG BỘ 100% SẢN PHẨM & PHÂN TRANG LÊN TẤT CẢ CÁC TRANG!")
    print("=" * 65)

if __name__ == "__main__":
    main()
