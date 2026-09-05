# -*- coding: utf-8 -*-
"""
FILE: fix_homepage_elementor.py
MỤC ĐÍCH:
    Sửa triệt để lỗi trang chủ (Homepage - Page ID: 3613):
    1. Chuẩn hóa HTML (loại bỏ thẻ html, head, body dư thừa, giữ lại fonts, style, markup và script).
    2. Đóng gói vào cấu trúc Elementor container & HTML widget chuẩn.
    3. Đặt template: 'elementor_header_footer', _elementor_edit_mode: 'builder', _elementor_template_type: 'wp-page'.
    4. Cập nhật Page 3613 qua WP REST API và kiểm tra live.
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

def main():
    print("🚀 Bắt đầu sửa và đồng bộ Homepage (Page ID: 3613)...")
    
    with open("homepage.html", "r", encoding="utf-8") as f:
        raw_html = f.read()

    # Tách phần body hoặc dọn dẹp các thẻ doctype/head nếu có
    body_match = re.search(r'<body[^>]*>(.*?)</body>', raw_html, re.DOTALL | re.IGNORECASE)
    if body_match:
        inner_content = body_match.group(1).strip()
    else:
        inner_content = raw_html.strip()

    # Đảm bảo có font Roboto, Inter
    font_tags = (
        '<link rel="preconnect" href="https://fonts.googleapis.com">\n'
        '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>\n'
        '<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">\n'
    )

    clean_html = font_tags + "\n" + inner_content

    # Cấu trúc Elementor JSON
    el_data = [
        {
            "id": "73d3139",
            "elType": "container",
            "settings": {
                "content_width": "full"
            },
            "elements": [
                {
                    "id": "6d9323f",
                    "elType": "widget",
                    "widgetType": "html",
                    "settings": {
                        "html": clean_html
                    }
                }
            ]
        }
    ]

    payload = {
        "title": "Homepage",
        "content": clean_html,
        "template": "elementor_header_footer",
        "meta": {
            "_elementor_edit_mode": "builder",
            "_elementor_template_type": "wp-page",
            "_elementor_data": json.dumps(el_data, ensure_ascii=False)
        }
    }

    headers = get_auth_header()
    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/pages/3613"

    print("📤 Đang gửi cập nhật lên WordPress...")
    resp = requests.post(endpoint, headers=headers, json=payload, timeout=45)

    if resp.status_code == 200:
        print("✅ Thành công cập nhật Page 3613!")
        data = resp.json()
        print(f"   Template: {data.get('template')}")
        print(f"   Link: {data.get('link')}")
    else:
        print(f"❌ Lỗi cập nhật: HTTP {resp.status_code}")
        print(resp.text[:500])
        return

    # Kiểm tra live trang chủ
    print("\n🔍 Kiểm tra trực tiếp live homepage (https://batdongsankhucongnghiep.vn/)...")
    live_resp = requests.get(f"{WP_SITE_URL}/", timeout=30)
    print(f"   Status Code: {live_resp.status_code}")
    print(f"   Content Length: {len(live_resp.text)}")
    print(f"   Có Elementor Container: {'elementor-element-73d3139' in live_resp.text}")
    print(f"   Có Header/Navigation: {'<header' in live_resp.text or 'elementor' in live_resp.text}")
    print(f"   Có Grid Sản phẩm: {'bds-property-grid' in live_resp.text or 'bds-card' in live_resp.text}")
    print(f"   Có Font Roboto/Inter: {'Roboto' in live_resp.text}")

if __name__ == "__main__":
    main()
