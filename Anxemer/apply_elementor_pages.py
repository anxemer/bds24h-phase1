# -*- coding: utf-8 -*-
import requests, base64, json

AUTH = base64.b64encode(b"admin:Q5qz 5BX0 20LM uEYs 7b0i ud9n").decode()
HEADERS = {"Authorization": f"Basic {AUTH}", "Content-Type": "application/json"}
SITE = "https://batdongsankhucongnghiep.vn"

pages_info = [
    (4220, "kho-xuong.html", "9e8f25e", "9b2d8ea", "kho-xuong"),
    (4233, "dat-cong-nghiep.html", "f2940fa", "0479cde", "dat-cong-nghiep"),
    (4299, "khu-cong-nghiep.html", "a72d647", "066434b", "kcn")
]

for pid, filename, cid, wid, slug in pages_info:
    with open(filename, "r", encoding="utf-8") as f:
        html = f.read()

    el_data = [
        {
            "id": cid,
            "elType": "container",
            "settings": {"content_width": "full"},
            "elements": [
                {
                    "id": wid,
                    "elType": "widget",
                    "widgetType": "html",
                    "settings": {
                        "html": html
                    }
                }
            ]
        }
    ]

    payload = {
        "content": html,
        "template": "elementor_header_footer",
        "meta": {
            "_elementor_edit_mode": "builder",
            "_elementor_template_type": "wp-page",
            "_elementor_data": json.dumps(el_data, ensure_ascii=False)
        }
    }

    r = requests.post(f"{SITE}/wp-json/wp/v2/pages/{pid}", headers=HEADERS, json=payload)
    print(f"Page {pid} ({filename}) update status: {r.status_code}")

    # Test live
    r_live = requests.get(f"{SITE}/{slug}/")
    has_hero = ".lp-hero" in r_live.text
    has_grid = "lp-grid" in r_live.text
    print(f"  Live {slug} length: {len(r_live.text)} | Has .lp-hero: {has_hero} | Has lp-grid: {has_grid}")
