# -*- coding: utf-8 -*-
"""
FILE: import_news_to_wp.py
MỤC ĐÍCH: Import toàn bộ bài tin tức từ news/articles.json lên WordPress (batdongsankhucongnghiep.vn)
LƯU Ý QUAN TRỌNG: CHỈ upload ảnh đã xóa logo nằm trong thư mục news/images-final/
"""

import os
import re
import json
import base64
import mimetypes
import requests
from urllib.parse import urlparse
from concurrent.futures import ThreadPoolExecutor

WP_SITE_URL = "https://batdongsankhucongnghiep.vn"
WP_USERNAME = os.environ.get("WP_USERNAME", "admin")
WP_APP_PASSWORD = os.environ.get("WP_APP_PASSWORD", "Q5qz 5BX0 20LM uEYs 7b0i ud9n")

CATEGORY_ID_NEWS = 61  # Tin Tuc BDS Cong Nghiep
POST_STATUS = "publish"

ARTICLES_JSON = "./news/articles.json"
NEWS_IMAGES_DIR = "./news/images-final"
TRACKING_FILE = "./news_import_tracking.json"
MEDIA_CACHE_FILE = "./wp_media_cache.json"

def get_auth_header():
    token = base64.b64encode(f"{WP_USERNAME}:{WP_APP_PASSWORD}".encode()).decode()
    return {"Authorization": f"Basic {token}"}

def load_media_cache():
    cache_dict = {}
    if os.path.exists(MEDIA_CACHE_FILE):
        try:
            with open(MEDIA_CACHE_FILE, "r", encoding="utf-8") as f:
                data = json.load(f)
                if isinstance(data, list):
                    for item in data:
                        url = item.get("source_url", "")
                        fname = url.split("/")[-1] if url else ""
                        if fname and "id" in item:
                            cache_dict[fname] = item
                elif isinstance(data, dict):
                    cache_dict = data
        except Exception as e:
            print(f"[Media Cache] Lỗi đọc cache: {e}")
    return cache_dict

def save_media_cache(cache_dict):
    cache_list = list(cache_dict.values())
    with open(MEDIA_CACHE_FILE, "w", encoding="utf-8") as f:
        json.dump(cache_list, f, ensure_ascii=False, indent=2)

def upload_image_if_clean(image_raw_path: str, media_cache: dict) -> dict:
    """
    CHỈ upload ảnh nếu tìm thấy trong news/images-final (đã xóa logo).
    Nếu đã có trong cache, trả về ngay.
    """
    if not image_raw_path:
        return None

    filename = os.path.basename(image_raw_path.replace("\\", "/"))
    clean_local_path = os.path.join(NEWS_IMAGES_DIR, filename)

    # BẮT BUỘC: Kiểm tra ảnh có trong news/images-final không
    if not os.path.exists(clean_local_path):
        return None

    # Đã có trong cache
    if filename in media_cache:
        return media_cache[filename]

    headers = get_auth_header()
    content_type = mimetypes.guess_type(filename)[0] or "image/jpeg"

    try:
        with open(clean_local_path, "rb") as f:
            file_data = f.read()

        upload_headers = dict(headers)
        upload_headers["Content-Disposition"] = f'attachment; filename="{filename}"'
        upload_headers["Content-Type"] = content_type

        resp = requests.post(
            f"{WP_SITE_URL}/wp-json/wp/v2/media",
            headers=upload_headers,
            data=file_data,
            timeout=45
        )
        if resp.status_code == 201:
            data = resp.json()
            res = {"id": data["id"], "slug": data.get("slug", ""), "source_url": data["source_url"]}
            media_cache[filename] = res
            return res
        else:
            print(f"    [Upload Media Lỗi {resp.status_code}] {filename}: {resp.text[:200]}")
            return None
    except Exception as e:
        print(f"    [Upload Media Exception] {filename}: {e}")
        return None

def md_to_html(text: str, extra_images: list = None) -> str:
    """Chuyển đổi text/markdown thành HTML có h2, h3, p, ul, li và chèn ảnh minh họa sạch xen kẽ."""
    if not text:
        return ""

    lines = text.split("\n")
    html_blocks = []
    in_list = False
    img_idx = 0
    extra_images = extra_images or []

    for line in lines:
        stripped = line.strip()
        if not stripped:
            if in_list:
                html_blocks.append("</ul>")
                in_list = False
            continue

        # Tiêu đề cấp 3
        if stripped.startswith("### "):
            if in_list:
                html_blocks.append("</ul>")
                in_list = False
            title = stripped[4:].strip()
            html_blocks.append(f"<h3>{title}</h3>")
        # Tiêu đề cấp 2 hoặc 1
        elif stripped.startswith("## ") or stripped.startswith("# "):
            if in_list:
                html_blocks.append("</ul>")
                in_list = False
            prefix_len = 3 if stripped.startswith("## ") else 2
            title = stripped[prefix_len:].strip()

            # Chèn ảnh minh họa trước tiêu đề mới nếu còn ảnh
            if img_idx < len(extra_images):
                img_obj = extra_images[img_idx]
                img_idx += 1
                if img_obj and img_obj.get("source_url"):
                    html_blocks.append(
                        f'<figure class="wp-block-image" style="margin:24px 0; text-align:center;">'
                        f'<img src="{img_obj["source_url"]}" alt="{title}" style="max-width:100%; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.08);"/>'
                        f'<figcaption style="font-size:13px; color:#64748b; margin-top:8px; font-style:italic;">Hình ảnh: {title}</figcaption>'
                        f'</figure>'
                    )

            html_blocks.append(f"<h2>{title}</h2>")
        # Tiêu đề La Mã: I. ..., II. ...
        elif re.match(r'^(I|II|III|IV|V|VI|VII|VIII|IX|X)\.\s+.*', stripped):
            if in_list:
                html_blocks.append("</ul>")
                in_list = False

            if img_idx < len(extra_images):
                img_obj = extra_images[img_idx]
                img_idx += 1
                if img_obj and img_obj.get("source_url"):
                    html_blocks.append(
                        f'<figure class="wp-block-image" style="margin:24px 0; text-align:center;">'
                        f'<img src="{img_obj["source_url"]}" alt="{stripped}" style="max-width:100%; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.08);"/>'
                        f'<figcaption style="font-size:13px; color:#64748b; margin-top:8px; font-style:italic;">Hình ảnh: {stripped}</figcaption>'
                        f'</figure>'
                    )

            html_blocks.append(f"<h2>{stripped}</h2>")
        # Danh sách
        elif stripped.startswith("- ") or stripped.startswith("– ") or stripped.startswith("* "):
            if not in_list:
                html_blocks.append("<ul>")
                in_list = True
            content = stripped[2:].strip()
            content = re.sub(r'\*\*(.*?)\*\*', r'<strong>\1</strong>', content)
            html_blocks.append(f"<li>{content}</li>")
        else:
            if in_list:
                html_blocks.append("</ul>")
                in_list = False
            content = stripped
            content = re.sub(r'\*\*(.*?)\*\*', r'<strong>\1</strong>', content)
            html_blocks.append(f"<p>{content}</p>")

    if in_list:
        html_blocks.append("</ul>")

    # Nếu vẫn còn ảnh chưa chèn, đặt ở cuối bài
    while img_idx < len(extra_images):
        img_obj = extra_images[img_idx]
        img_idx += 1
        if img_obj and img_obj.get("source_url"):
            html_blocks.append(
                f'<figure class="wp-block-image" style="margin:24px 0; text-align:center;">'
                f'<img src="{img_obj["source_url"]}" alt="Ảnh dự án" style="max-width:100%; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.08);"/>'
                f'</figure>'
            )

    return "\n".join(html_blocks)

def load_tracking():
    if os.path.exists(TRACKING_FILE):
        try:
            with open(TRACKING_FILE, "r", encoding="utf-8") as f:
                return json.load(f)
        except Exception:
            return {}
    return {}

def save_tracking(tracking):
    with open(TRACKING_FILE, "w", encoding="utf-8") as f:
        json.dump(tracking, f, ensure_ascii=False, indent=2)

def import_single_article(article: dict, media_cache: dict, tracking: dict) -> bool:
    title = (article.get("title") or "").strip()
    url = (article.get("url") or "").strip()

    # Bỏ qua bài viết rỗng
    if not title or not url:
        return False

    # Kiểm tra tracking
    if url in tracking:
        return True

    # Upload ảnh sạch từ news/images-final
    images_raw = article.get("images", [])
    uploaded_media = []

    for img_path in images_raw:
        res = upload_image_if_clean(img_path, media_cache)
        if res:
            uploaded_media.append(res)

    featured_media_id = uploaded_media[0]["id"] if uploaded_media else None
    extra_images = uploaded_media[1:] if len(uploaded_media) > 1 else []

    # Chuẩn bị nội dung
    content_raw = article.get("content_paraphrased") or article.get("content_original") or ""
    html_content = md_to_html(content_raw, extra_images)

    # Slug từ URL
    slug = urlparse(url).path.strip("/").split("/")[-1]

    payload = {
        "title": title,
        "content": html_content,
        "status": POST_STATUS,
        "categories": [CATEGORY_ID_NEWS],
    }
    if slug:
        payload["slug"] = slug
    if featured_media_id:
        payload["featured_media"] = featured_media_id

    headers = get_auth_header()
    endpoint = f"{WP_SITE_URL}/wp-json/wp/v2/posts"

    try:
        resp = requests.post(endpoint, headers=headers, json=payload, timeout=30)
        if resp.status_code in (200, 201):
            post_data = resp.json()
            post_id = post_data["id"]
            tracking[url] = post_id
            save_tracking(tracking)
            save_media_cache(media_cache)
            print(f"  [OK] Đã đăng bài (ID: {post_id}): {title[:45]}...")
            return True
        else:
            print(f"  [Lỗi {resp.status_code}] {title[:40]}: {resp.text[:200]}")
            return False
    except Exception as e:
        print(f"  [Exception] {title[:40]}: {e}")
        return False

def main():
    if not os.path.exists(ARTICLES_JSON):
        print(f"[Lỗi] Không tìm thấy file {ARTICLES_JSON}")
        return

    with open(ARTICLES_JSON, "r", encoding="utf-8") as f:
        articles = json.load(f)

    media_cache = load_media_cache()
    tracking = load_tracking()

    print(f"=== BẮT ĐẦU IMPORT {len(articles)} BÀI VIẾT TIN TỨC ===")
    print(f"- Thư mục ảnh sạch: {NEWS_IMAGES_DIR} ({len(os.listdir(NEWS_IMAGES_DIR))} files)")
    print(f"- Đã import trước đó: {len(tracking)} bài")
    print(f"- Bộ nhớ đệm ảnh: {len(media_cache)} media")

    count = 0
    success = 0
    skip = 0

    for i, a in enumerate(articles, 1):
        url = a.get("url", "")
        title = a.get("title", "")
        if not title or not url:
            continue

        if url in tracking:
            skip += 1
            continue

        count += 1
        print(f"[{i}/{len(articles)}] Đang xử lý: {title[:50]}...")
        ok = import_single_article(a, media_cache, tracking)
        if ok:
            success += 1

    print("\n=== HOÀN THÀNH BÀI VIẾT TIN TỨC ===")
    print(f"- Tổng số bài: {len(articles)}")
    print(f"- Bỏ qua (đã có): {skip}")
    print(f"- Thành công mới: {success}")

if __name__ == "__main__":
    main()
