# -*- coding: utf-8 -*-
"""
FILE: build_all_listings_paginated.py
MỤC ĐÍCH:
    1. Trích xuất toàn bộ dữ liệu thật của:
       - Kho Xưởng (~1.873 sp)
       - Đất Công Nghiệp (~237 sp)
       - Khu Công Nghiệp (1.211 KCN)
    2. Tích hợp Header Menu + Toàn bộ Data + Bộ máy Phân trang (Pagination 12 items/page) + Bộ lọc thông minh
       vào các file HTML và đồng bộ lên WordPress:
       - Page 4220: Kho Xưởng (/kho-xuong/)
       - Page 4233: Đất Công Nghiệp (/dat-cong-nghiep/)
       - Page 4299: Khu Công Nghiệp (/kcn/)
       - Page 3613: Trang Chủ (/)
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
# HELPER DATA FORMATTERS
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
            return f"{ty:.2f} tỷ".rstrip('0').rstrip('.').replace('.', ',') + " tỷ"
        elif num >= 1_000_000:
            trieu = num / 1_000_000
            return f"{trieu:.1f} triệu".rstrip('0').rstrip('.').replace('.', ',') + " triệu"
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
                return num * 1000  # Quy về triệu
            return num
        except Exception:
            return 0
    return 0

# ============================================================
# 1. LOAD DATASETS
# ============================================================
def load_datasets():
    print("⏳ Đang tải dữ liệu sản phẩm và KCN...")
    
    products = []
    if os.path.exists("kx-dcn/products.json"):
        with open("kx-dcn/products.json", "r", encoding="utf-8") as f:
            products = json.load(f)

    kcn_list = []
    if os.path.exists("kcn/kcn_list.json"):
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

    print(f"   => Kho xưởng: {len(kho_xuong_items)} items")
    print(f"   => Đất CN: {len(dat_cn_items)} items")
    print(f"   => KCN: {len(kcn_items)} items")

    return kho_xuong_items, dat_cn_items, kcn_items

# ============================================================
# 2. GENERATE JS PAGINATION ENGINE
# ============================================================
def generate_listing_js(var_name, item_type_name):
    return f"""
<script>
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

    if (countEl) countEl.textContent = total.toLocaleString('vi-VN') + ' {item_type_name}';

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
      if (startPage > 2) html.push('<span class="lp-page-dots" style="padding:6px 4px;color:#64748b;">...</span>');
    }}

    for (var i = startPage; i <= endPage; i++) {{
      if (i === currentPage) {{
        html.push('<span class="lp-page-btn active">' + i + '</span>');
      }} else {{
        html.push('<button class="lp-page-btn" data-page="' + i + '">' + i + '</button>');
      }}
    }}

    if (endPage < totalPages) {{
      if (endPage < totalPages - 1) html.push('<span class="lp-page-dots" style="padding:6px 4px;color:#64748b;">...</span>');
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

    // Sorting
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
    document.querySelectorAll('.lp-dd-val').forEach(function(el){{
      el.textContent = el.closest('.lp-dd').querySelector('.lp-dd-opt') ? el.closest('.lp-dd').querySelector('.lp-dd-opt').textContent.trim() : 'Mặc định';
    }});
    runFilter();
  }};

  document.addEventListener('DOMContentLoaded', function(){{
    filteredItems = allData.slice();
    renderGrid();

    var btn = document.getElementById('ks-search-btn');
    var kw = document.getElementById('ks-kw');
    if (btn) btn.addEventListener('click', runFilter);
    if (kw) kw.addEventListener('keydown', function(e){{ if(e.key==='Enter') runFilter(); }});

    document.querySelectorAll('.lp-chip').forEach(function(chip){{
      chip.addEventListener('click', function(){{
        document.querySelectorAll('.lp-chip').forEach(function(c){{ c.classList.remove('active'); }});
        chip.classList.add('active');
        var reg = chip.getAttribute('data-region') || '';
        if (document.getElementById('ks-region')) document.getElementById('ks-region').value = reg;
        runFilter();
      }});
    }});
  }});

  if (document.readyState !== 'loading') {{
    filteredItems = allData.slice();
    renderGrid();
  }}
}})();
</script>
"""

# ============================================================
# 3. UPDATE PAGE FILES & SYNC TO WP
# ============================================================
def update_page_file_and_wp(filename, wp_page_id, items, var_name, type_name):
    print(f"\n🚀 Đang xử lý: {filename} (WP Page ID: {wp_page_id}) với {len(items)} {type_name}...")
    
    if not os.path.exists(filename):
        print(f"❌ Không tìm thấy file {filename}")
        return

    with open(filename, "r", encoding="utf-8") as f:
        html = f.read()

    # Thêm Header Menu nếu chưa có
    if "id=\"kx-header\"" not in html and os.path.exists("menu.html"):
        with open("menu.html", "r", encoding="utf-8") as mf:
            menu_html = mf.read()
        if "<body>" in html:
            html = html.replace("<body>", f"<body>\n{menu_html}\n")
        else:
            html = menu_html + "\n" + html

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

    new_grid_html = "\n".join(initial_cards)

    grid_pattern = r'(<div class="lp-grid"[^>]*>).*?(</div>\s*<div class="lp-pagination")'
    if re.search(grid_pattern, html, re.DOTALL):
        html = re.sub(grid_pattern, rf'\1\n{new_grid_html}\n\t\t\t\t\2', html, flags=re.DOTALL)
    else:
        grid_pattern2 = r'(<div class="lp-grid">).*?(</div>\s*</div>\s*</div>\s*</div>\s*</main>)'
        if re.search(grid_pattern2, html, re.DOTALL):
            html = re.sub(grid_pattern2, rf'\1\n{new_grid_html}\n\t\t\t\t\2', html, flags=re.DOTALL)

    html = re.sub(r'(<p class="lp-results-count">).*?(</p>)', rf'\1Tìm thấy <strong>{len(items):,} {type_name}</strong> phù hợp\2'.replace(',', '.'), html)

    # Clean existing scripts if any
    html = re.sub(r'<script>\s*window\.' + var_name + r'\s*=.*?</script>', '', html, flags=re.DOTALL)
    html = re.sub(r'<script>\s*\(function\(\)\{\s*var PAGE_SIZE = 12;.*?</script>', '', html, flags=re.DOTALL)

    data_json = json.dumps(items, ensure_ascii=False)
    data_script = f"\n<script>\nwindow.{var_name} = {data_json};\n</script>\n"
    pag_script = generate_listing_js(var_name, type_name)

    if "</body>" in html:
        html = html.replace("</body>", f"{data_script}\n{pag_script}\n</body>")
    else:
        html += f"{data_script}\n{pag_script}"

    with open(filename, "w", encoding="utf-8") as f:
        f.write(html)
    print(f"✅ Đã ghi file local: {filename}")

    # Đồng bộ lên WordPress
    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/pages/{wp_page_id}"
    payload = {
        "content": html,
        "template": "elementor_canvas",
        "meta": {
            "_elementor_edit_mode": ""
        }
    }
    resp = requests.post(endpoint, headers=AUTH_HEADER, json=payload, timeout=40)
    if resp.status_code == 200:
        print(f"🎉 ĐÃ ĐỒNG BỘ THÀNH CÔNG LÊN WORDPRESS PAGE {wp_page_id} ({filename})!")
    else:
        print(f"⚠️ Không thể đồng bộ Page {wp_page_id}: HTTP {resp.status_code} - {resp.text[:200]}")

def update_homepage_listing(kcn_items, kho_xuong_items, dat_cn_items):
    print("\n🚀 Đang cập nhật Homepage (Page 3613)...")
    filename = "homepage.html"
    if not os.path.exists(filename): return
    with open(filename, "r", encoding="utf-8") as f: html = f.read()

    top_items = (kcn_items[:8] + kho_xuong_items[:8] + dat_cn_items[:4])
    cards = []
    for item in top_items:
        card = f'''                <a href="{item['url']}" class="bds-card" data-region="{item['loc'].lower()}" data-status="operating"
                    data-title="{item['title']}" title="{item['title']}">
                    <div class="bds-thumb"><img
                            src="{item['thumb']}"
                            alt="{item['title']}"><span class="bds-status">{item.get('badge', 'Đang hoạt động')}</span><span class="bds-thumb-label">{item['title'].upper()[:20]}</span></div>
                    <div class="bds-card-body">
                        <div class="bds-card-kicker"><span>{item['kicker']}</span><span>Mới cập nhật</span></div>
                        <div class="bds-card-title">{item['title']}</div>
                        <div class="bds-card-loc">📍 {item['loc']}</div><span class="bds-spec">{item['area']}</span>
                        <div class="bds-card-meta"><span>{item['area']}</span><span>Hạ tầng hoàn chỉnh</span></div>
                        <div class="bds-price">{item['price']}</div><span class="bds-card-action">Xem chi tiết {item['title']} →</span>
                    </div>
                </a>'''
        cards.append(card)

    new_grid_content = "\n".join(cards)
    pattern = r'(<div class="bds-grid" id="bds-property-grid">).*?(<div class="bds-empty" id="bds-empty">)'
    if re.search(pattern, html, re.DOTALL):
        html = re.sub(pattern, rf'\1\n{new_grid_content}\n                \2', html, flags=re.DOTALL)
        with open(filename, "w", encoding="utf-8") as f: f.write(html)
        print("✅ Đã ghi file local: homepage.html")

    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/pages/3613"
    payload = {
        "content": html,
        "template": "elementor_canvas",
        "meta": {
            "_elementor_edit_mode": ""
        }
    }
    resp = requests.post(endpoint, headers=AUTH_HEADER, json=payload, timeout=40)
    if resp.status_code == 200:
        print("🎉 ĐÃ ĐỒNG BỘ HOMEPAGE LÊN WORDPRESS PAGE 3613!")

def main():
    kho_xuong, dat_cn, kcns = load_datasets()
    
    # 1. Kho Xưởng (Page ID 4220)
    update_page_file_and_wp("kho-xuong.html", 4220, kho_xuong, "BDS24H_KHO_XUONG", "kho xưởng")

    # 2. Đất Công Nghiệp (Page ID 4233)
    update_page_file_and_wp("dat-cong-nghiep.html", 4233, dat_cn, "BDS24H_DAT_CN", "đất công nghiệp")

    # 3. Khu Công Nghiệp (Page ID 4299)
    update_page_file_and_wp("khu-cong-nghiep.html", 4299, kcns, "BDS24H_KCNS", "khu công nghiệp")

    # 4. Homepage (Page ID 3613)
    update_homepage_listing(kcns, kho_xuong, dat_cn)

    print("\n" + "=" * 65)
    print("🎉 HOÀN TẤT CẬP NHẬT TOÀN BỘ CÁC TRANG LISTING KÈM PHÂN TRANG!")
    print("=" * 65)

if __name__ == "__main__":
    main()
