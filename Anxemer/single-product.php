<?php
/**
 * Template Name: Chi Tiết Sản Phẩm BĐS (Kho Xưởng & Đất Công Nghiệp)
 * Template Post Type: post, khu-cong-nghiep, product, page
 * 
 * Thiết kế chuẩn 100% theo layout Kho Xưởng Đẹp:
 * - Breadcrumb & Meta pills (Loại hình, Khu vực, Thời gian cập nhật)
 * - Ảnh thực tế dự án
 * - Bảng thông tin tổng quan (Mã tin, Diện tích, Giá, Loại hình, Khu vực)
 * - Mô tả chi tiết
 * - Tiện ích & đặc điểm nổi bật (Checklist)
 * - Vị trí & Bản đồ Google Maps
 * - Sidebar Giá & Hotline / Zalo
 */

get_header(); ?>

<style>
    /* RESET & VARS */
    *, *::before, *::after { box-sizing: border-box; }
    
    :root {
        --kxd-green: #0f7f2f;
        --kxd-green-dark: #083315;
        --kxd-orange: #FF7F2A;
        --kxd-bg: #f8fafc;
        --kxd-card-bg: #ffffff;
        --kxd-border: #e2e8f0;
        --kxd-text: #000000;
        --kxd-text-muted: #000000;
        --kxd-radius: 12px;
    }

    body {
        background-color: var(--kxd-bg);
        color: var(--kxd-text);
        font-family: 'Roboto', 'Inter', sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    /* Ẩn triệt để Header và Topbar mặc định của Theme Pearl / WordPress */
    body > header,
    #header,
    .stm-header,
    .stm_mobile_header,
    .top_bar,
    .top_nav,
    .stm-header-builder,
    header:not(#kx-header),
    div[class*="stm-header"],
    div[class*="top_bar"],
    div[class*="topbar"],
    div[class*="header_"],
    .header_default,
    .header_center,
    .stm-header__cell,
    .pearl-header-wrap {
        display: none !important;
        height: 0 !important;
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    /* 2. RESET KHUNG CONTAINER CỦA THEME PEARL THÀNH FULL WIDTH (XÓA BỎ BÓP KHUNG) */
    html, body {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        background: var(--kxd-bg) !important;
    }

    #main, #content, .site-content, .stm-single-post, .container, .row, .post-type-archive-product, .single-product-container {
        max-width: 100% !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        border: none !important;
        float: none !important;
    }

    .kxd-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* =================================================
       HEADER CUSTOM ĐỒNG BỘ
    ================================================= */
    #kx-header {
        background: #ffffff;
        border-bottom: 1px solid var(--kxd-border);
        position: sticky;
        top: 0;
        z-index: 999;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .kx-header-inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .kx-logo {
        flex: 0 0 auto;
        display: inline-flex;
        flex-direction: column;
        justify-content: center;
        text-decoration: none;
        padding: 4px 0;
    }
    .kx-logo-main {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .kx-logo-icon {
        height: 52px;
        width: auto;
        max-height: 56px;
        object-fit: contain;
        display: block;
        flex-shrink: 0;
    }
    .kx-logo-brand {
        display: flex;
        flex-direction: column;
        line-height: 1.05;
    }
    .kx-brand-sub {
        font-family: 'Montserrat', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 11.5px;
        font-weight: 800;
        color: #0f5999;
        letter-spacing: -0.2px;
        line-height: 1.15;
    }
    .kx-brand-main {
        font-family: 'Montserrat', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 13.5px;
        font-weight: 900;
        color: #c4161c;
        text-transform: uppercase;
        letter-spacing: 0.2px;
        line-height: 1.1;
        white-space: nowrap;
    }
    .kx-brand-vn {
        font-family: 'Montserrat', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #0f5999;
        font-size: 11px;
        font-weight: 800;
        text-transform: lowercase;
    }
    .kx-logo-slogan {
        font-family: 'Montserrat', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 8.5px;
        font-style: italic;
        font-weight: 700;
        color: #0f5999;
        letter-spacing: 0.2px;
        margin-top: 2px;
        line-height: 1.2;
        white-space: nowrap;
    }
    .kx-nav-list {
        display: flex;
        gap: 20px;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
    }
    .kx-nav-item a {
        color: #000000;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 700;
        transition: color .2s;
    }
    .kx-nav-item a:hover {
        color: var(--kxd-green);
    }
    .kx-nav-hotline-item {
        margin-left: 6px;
    }
    .kx-menu-hotline-link {
        color: #c4161c !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        background: #fff5f5;
        border: 1px solid #fed7d7;
        padding: 4px 10px !important;
        border-radius: 14px;
        text-decoration: none !important;
        transition: background .15s, transform .15s, box-shadow .15s !important;
    }
    .kx-menu-hotline-link strong {
        font-size: 12.5px;
        font-weight: 800;
    }
    .kx-menu-hotline-link:hover {
        background: #fee2e2 !important;
        color: #a31217 !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(196, 22, 28, 0.12);
    }
    .kx-menu-hotline-icon {
        font-size: 11px;
        color: #c4161c;
    }
    .kx-header-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .kx-phone {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #000000;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 700;
    }
    .kx-phone strong {
        color: #000000;
        font-weight: 800;
    }
    .kx-submit {
        background: var(--kxd-green);
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 700;
        transition: background .2s;
    }
    .kx-submit:hover {
        background: var(--kxd-green-dark);
    }

    /* =================================================
       PAGE HERO & BREADCRUMB
    ================================================= */
    .kxd-page-hero {
        background: #ffffff;
        border-bottom: 1px solid var(--kxd-border);
        padding: 24px 0 20px;
    }
    .kxd-breadcrumb {
        font-size: 13px;
        color: var(--kxd-text-muted);
        margin-bottom: 12px;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
    }
    .kxd-breadcrumb a {
        color: var(--kxd-text-muted);
        text-decoration: none;
        transition: color .15s;
    }
    .kxd-breadcrumb a:hover {
        color: var(--kxd-green);
    }
    .kxd-breadcrumb span.sep {
        color: #000000;
    }
    .kxd-page-title {
        font-family: 'Oswald', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #000000;
        margin: 0 0 14px;
        line-height: 1.35;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .kxd-page-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }
    .kxd-meta-pill {
        background: #ecfdf5;
        color: var(--kxd-green);
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #a7f3d0;
    }
    .kxd-meta-pill.gray {
        background: #f1f5f9;
        color: #000000;
        border-color: #e2e8f0;
        font-weight: 500;
    }

    /* =================================================
       MAIN LAYOUT
    ================================================= */
    .kxd-main-content {
        padding: 30px 0 60px;
    }
    .kxd-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 28px;
        align-items: start;
    }

    /* SECTION CARDS */
    .kxd-section-card {
        background: var(--kxd-card-bg);
        border: 1px solid var(--kxd-border);
        border-radius: var(--kxd-radius);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .kxd-section-card h2 {
        font-family: 'Oswald', sans-serif;
        font-size: 20px;
        font-weight: 700;
        text-transform: uppercase;
        color: #000000;
        margin: 0 0 18px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--kxd-green);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* UNIFIED GALLERY */
    .gallery {
        display: grid;
        grid-template-columns: 1.55fr 1fr;
        height: 340px;
        gap: 4px;
        background: #0f172a;
        border-radius: var(--kxd-radius);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .gallery.no-side {
        grid-template-columns: 1fr !important;
    }
    .gallery.no-side .cover {
        width: 100% !important;
    }
    .gallery .cover,
    .gallery .side div {
        background-size: cover;
        background-position: center;
        position: relative;
        cursor: zoom-in;
        transition: transform 0.25s ease;
    }
    .gallery .cover:hover,
    .gallery .side div:hover {
        opacity: 0.96;
    }
    .side {
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: 4px;
    }
    .side:empty {
        display: none;
    }
    .photo-label {
        position: absolute;
        left: 14px;
        bottom: 14px;
        background: rgba(0, 0, 0, 0.75);
        color: #fff;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        backdrop-filter: blur(4px);
        z-index: 2;
    }
    .kxd-gallery-thumbs {
        display: flex;
        gap: 8px;
        padding: 10px 14px;
        background: #ffffff;
        border: 1px solid var(--kxd-border);
        border-top: none;
        border-bottom-left-radius: var(--kxd-radius);
        border-bottom-right-radius: var(--kxd-radius);
        overflow-x: auto;
        scrollbar-width: thin;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .kxd-gallery-thumbs::-webkit-scrollbar {
        height: 6px;
    }
    .kxd-gallery-thumbs::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .kxd-thumb-item {
        flex: 0 0 auto;
        width: 100px;
        height: 68px;
        border-radius: 6px;
        overflow: hidden;
        border: 2px solid #cbd5e1;
        cursor: pointer;
        background-size: cover;
        background-position: center;
        transition: transform 0.15s, border-color 0.15s;
    }
    .kxd-thumb-item:hover, .kxd-thumb-item.active {
        border-color: var(--kxd-green);
        transform: scale(1.04);
    }

    /* KHÓA CUỘN TRANG VÀ ẨN HOÀN TOÀN THANH MENU HEADER KHI MỞ LIGHTBOX (CHỐNG ĐÈ 100%) */
    html.lightbox-open,
    body.lightbox-open {
        overflow: hidden !important;
        height: 100% !important;
    }
    html.lightbox-open #kx-header,
    body.lightbox-open #kx-header,
    html.lightbox-open .kx-sticky,
    body.lightbox-open .kx-sticky,
    html.lightbox-open .stm-header,
    body.lightbox-open .stm-header,
    html.lightbox-open .stm_mobile__header,
    body.lightbox-open .stm_mobile__header,
    html.lightbox-open header,
    body.lightbox-open header,
    html.lightbox-open #wpadminbar,
    body.lightbox-open #wpadminbar {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
        z-index: -1 !important;
    }

    /* LIGHTBOX MODAL BẬT XEM ẢNH PHÓNG TO (Z-INDEX TỐI ĐA CHỐNG ĐÈ MENU) */
    .image-lightbox {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 2147483647 !important;
        display: none;
        align-items: center !important;
        justify-content: center !important;
        padding: 24px !important;
        background: rgba(8, 14, 11, 0.95) !important;
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        cursor: zoom-out;
        box-sizing: border-box !important;
    }
    .image-lightbox.is-open {
        display: flex !important;
    }
    .image-lightbox * {
        z-index: 2147483647 !important;
    }
    .image-lightbox img {
        display: block !important;
        max-width: min(1200px, 92vw) !important;
        max-height: 85vh !important;
        width: auto !important;
        height: auto !important;
        object-fit: contain !important;
        border-radius: 8px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6) !important;
        cursor: default;
    }
    .image-lightbox-close {
        position: absolute !important;
        top: 20px !important;
        right: 24px !important;
        width: 46px !important;
        height: 46px !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        border-radius: 50% !important;
        background: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        font-size: 32px !important;
        font-weight: 300 !important;
        line-height: 1 !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
        z-index: 2147483647 !important;
    }
    .image-lightbox-close:hover {
        background: #e11d48 !important;
        border-color: #e11d48 !important;
        transform: scale(1.08) !important;
    }
    .image-lightbox-caption {
        position: absolute !important;
        bottom: 20px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        background: rgba(0, 0, 0, 0.75) !important;
        color: #ffffff !important;
        padding: 8px 20px !important;
        border-radius: 20px !important;
        font-family: 'Roboto', 'Inter', sans-serif !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        letter-spacing: 0.02em !important;
        max-width: 90vw !important;
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        pointer-events: none !important;
    }

    /* FEATURE OVERVIEW GRID */
    .kxd-feature-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .kxd-feature-item {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 8px;
        padding: 14px 16px;
    }
    .kxd-feature-item .label {
        display: block;
        font-size: 12px;
        color: var(--kxd-text-muted);
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: 0.03em;
    }
    .kxd-feature-item .value {
        font-size: 16px;
        font-weight: 700;
        color: #000000;
    }
    .kxd-feature-item .value.price {
        color: var(--kxd-green);
        font-family: 'Oswald', sans-serif;
        font-size: 19px;
    }

    /* CONTENT & CHECKLIST */
    .kxd-entry-content {
        font-size: 15.5px;
        line-height: 1.85;
        color: #1e293b;
    }
    .kxd-entry-content p {
        margin: 0 0 16px;
    }
    .kxd-desc-para {
        margin: 0 0 16px;
        font-size: 15.5px;
        line-height: 1.85;
        color: #334155;
    }
    .kxd-desc-highlights {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-left: 4px solid var(--kxd-green);
        border-radius: 10px;
        padding: 16px 20px;
        margin: 20px 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(15, 127, 47, 0.06);
    }
    .kxd-desc-point {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 15px;
        font-weight: 600;
        color: #166534;
        line-height: 1.6;
    }
    .kxd-point-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: var(--kxd-green);
        color: #ffffff;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 900;
        flex-shrink: 0;
        margin-top: 2px;
        box-shadow: 0 2px 4px rgba(15, 127, 47, 0.2);
    }
    .kxd-desc-contact-card {
        background: linear-gradient(135deg, #0f7f2f 0%, #064e1b 100%);
        color: #ffffff;
        border-radius: 12px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin: 24px 0 12px;
        box-shadow: 0 6px 18px rgba(15, 127, 47, 0.22);
    }
    .kxd-dcc-icon {
        font-size: 32px;
        flex-shrink: 0;
    }
    .kxd-dcc-body {
        flex: 1;
    }
    .kxd-dcc-title {
        font-size: 12.5px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #86efac;
        font-weight: 700;
        margin-bottom: 3px;
    }
    .kxd-dcc-text {
        font-size: 16px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.4;
    }
    .kxd-dcc-btn {
        background: #ffffff;
        color: var(--kxd-green);
        font-weight: 700;
        font-size: 14px;
        padding: 10px 22px;
        border-radius: 8px;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .kxd-dcc-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.22);
        background: #f0fdf4;
        color: var(--kxd-green-dark);
    }
    @media (max-width: 640px) {
        .kxd-desc-contact-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
            padding: 18px 20px;
        }
        .kxd-dcc-btn {
            width: 100%;
            justify-content: center;
            text-align: center;
        }
    }
    .kxd-entry-content ul {
        padding-left: 20px;
        margin-bottom: 16px;
    }

    .kxd-checklist {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 20px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .kxd-checklist li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14.5px;
        color: #000000;
        font-weight: 500;
    }
    .kxd-checklist li::before {
        content: "✓";
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: #ecfdf5;
        color: var(--kxd-green);
        border: 1px solid #a7f3d0;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 900;
        flex-shrink: 0;
    }

    /* MAP WRAP */
    .kxd-map-wrap {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--kxd-border);
        margin-top: 14px;
        aspect-ratio: 16 / 9;
        max-height: 380px;
    }
    .kxd-map-wrap iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }

    /* =================================================
       SIDEBAR
    ================================================= */
    .kxd-sidebar {
        position: sticky;
        top: 80px;
    }
    /* SIDEBAR PRICE CARD THEO CHUẨN ẢNH 1 */
    .price-card {
        background: #ffffff;
        border: 1px solid var(--kxd-border);
        border-top: 4px solid #0f7f2f !important;
        border-radius: var(--kxd-radius);
        padding: 24px 22px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    .price-label {
        font-family: 'Roboto', 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 800;
        color: #000000;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 6px;
        display: block;
    }
    .price {
        font-family: 'Oswald', sans-serif;
        font-weight: 700;
        font-size: 32px;
        line-height: 1.15;
        color: #0f7f2f !important;
        letter-spacing: 0.3px;
        margin: 4px 0 2px;
    }
    .unit {
        font-family: 'Roboto', 'Inter', sans-serif;
        font-size: 13.5px;
        color: #475569;
        margin-bottom: 18px;
        display: block;
    }
    .cta {
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        box-sizing: border-box;
        text-align: center;
        text-decoration: none;
        padding: 13px 14px;
        border-radius: 8px;
        font-family: 'Roboto', 'Inter', sans-serif;
        font-size: 14.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        margin-top: 10px;
        margin-bottom: 10px;
        transition: all 0.2s ease;
        border: none !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }
    .cta:hover {
        transform: translateY(-2px);
        opacity: 1 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .cta.cta-orange {
        background: #f26522 !important;
        color: #ffffff !important;
    }
    .cta.cta-green {
        background: #0f7f2f !important;
        color: #ffffff !important;
    }
    .cta.cta-fb {
        background: #1877f2 !important;
        color: #ffffff !important;
        margin-bottom: 16px;
    }
    .agent {
        border-top: 1px solid #e2e8f0;
        margin-top: 18px;
        padding-top: 16px;
        font-family: 'Roboto', 'Inter', sans-serif;
    }
    .agent strong {
        display: block;
        font-size: 15px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 5px;
    }
    .agent-hotline {
        font-size: 13.5px;
        color: #1e293b;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .agent-desc {
        font-size: 13px;
        color: #475569;
        line-height: 1.45;
    }

    /* =================================================
       BANNER PHÒNG XÚC TIẾN ĐẦU TƯ
    ================================================= */
    .invest-promo-banner {
        background: linear-gradient(135deg, #072a14 0%, #0d4621 55%, #083315 100%);
        border-radius: 12px;
        border: 1px solid rgba(22, 192, 74, 0.45);
        padding: 24px 26px;
        color: #ffffff;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(15, 127, 47, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.12);
        position: relative;
        overflow: hidden;
    }
    .invest-promo-banner::before {
        content: "";
        position: absolute;
        top: -40%;
        right: -15%;
        width: 360px;
        height: 360px;
        background: radial-gradient(circle, rgba(22, 192, 74, 0.22) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .invest-promo-banner::after {
        content: "";
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(255, 127, 42, 0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .ipb-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);
        margin-bottom: 18px;
        position: relative;
        z-index: 2;
    }
    .ipb-badge-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(22, 192, 74, 0.22);
        border: 1px solid rgba(22, 192, 74, 0.45);
        padding: 5px 13px;
        border-radius: 20px;
        font-family: 'Roboto', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #a7f3d0;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .ipb-pulse-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: ipbPulse 2s infinite;
    }
    @keyframes ipbPulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    .ipb-live-text {
        font-family: 'Roboto', sans-serif;
        font-size: 12.5px;
        color: #ffd166;
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .ipb-content-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 24px;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    .ipb-main-info h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 23px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.3;
        margin: 0 0 8px;
        color: #ffffff;
    }
    .ipb-main-info h3 span {
        color: #4ade80;
    }
    .ipb-intro-desc {
        font-family: 'Roboto', sans-serif;
        font-size: 13.5px;
        line-height: 1.6;
        color: #e2e8f0;
        margin: 0 0 16px;
    }
    .ipb-feature-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .ipb-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        line-height: 1.5;
        color: #f1f5f9;
    }
    .ipb-feature-icon {
        width: 26px;
        height: 26px;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .ipb-feature-item strong {
        color: #ffffff;
        font-weight: 700;
    }
    .ipb-feature-item span {
        color: #cbd5e1;
    }
    .ipb-action-card {
        background: rgba(0, 0, 0, 0.38);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 10px;
        padding: 20px 20px;
        text-align: center;
        backdrop-filter: blur(4px);
    }
    .ipb-action-card-tag {
        font-family: 'Roboto', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #cbd5e1;
        margin-bottom: 4px;
    }
    .ipb-phone-highlight {
        font-family: 'Oswald', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 1px;
        margin-bottom: 4px;
        display: block;
        text-decoration: none;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        transition: color 0.2s, transform 0.2s;
    }
    .ipb-phone-highlight:hover {
        color: #ffd166;
        transform: scale(1.03);
    }
    .ipb-phone-desc {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 14px;
    }
    .ipb-buttons {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }
    .ipb-btn-hotline {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--kxd-orange);
        color: #ffffff;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 11px 16px;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 4px 14px rgba(255, 127, 42, 0.35);
    }
    .ipb-btn-hotline:hover {
        background: #e66a1a;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(255, 127, 42, 0.45);
        color: #ffffff;
    }
    .ipb-btn-zalo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0284c7;
        color: #ffffff;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        font-weight: 700;
        padding: 10px 16px;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.2s, transform 0.15s;
    }
    .ipb-btn-zalo:hover {
        background: #0369a1;
        transform: translateY(-1px);
        color: #ffffff;
    }
    .ipb-footer-note {
        margin-top: 12px;
        font-size: 11.5px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    @media (max-width: 768px) {
        .ipb-content-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }
        .invest-promo-banner {
            padding: 20px 16px;
        }
        .ipb-main-info h3 {
            font-size: 19px;
        }
        .ipb-phone-highlight {
            font-size: 24px;
        }
    }
</style>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    $post_id = get_the_ID();
    $title = get_the_title();

    // 1. Nhận diện Chuyên mục & Loại hình thông minh
    $raw_loai_hinh = get_post_meta($post_id, 'loai_hinh', true) ?: (function_exists('get_field') ? get_field('loai_hinh') : '');
    $text_to_check = mb_strtolower($title . ' ' . $raw_loai_hinh, 'UTF-8');
    $is_dat = (strpos($text_to_check, 'đất') !== false || strpos($text_to_check, 'dat') !== false);

    if ($is_dat) {
        $cat_name = 'Đất Công Nghiệp';
        $cat_url = home_url('/dat-cong-nghiep/');
        $loai_hinh_default = 'Đất Công Nghiệp';
    } else {
        $cat_name = 'Kho Xưởng';
        $cat_url = home_url('/kho-xuong/');
        $loai_hinh_default = 'Kho Xưởng Cho Thuê';
    }
    $loai_hinh = $raw_loai_hinh ?: $loai_hinh_default;

    // 2. Mã tin
    $ma_tin = get_post_meta($post_id, 'ma_tin', true) ?: (function_exists('get_field') ? get_field('ma_tin') : '');
    if (!$ma_tin) {
        $ma_tin = 'BDS-' . $post_id;
    }

    // 3. Diện tích thông minh (xử lý số nguyên thô, chuỗi có đơn vị, mét vuông, ha, dải số)
    $raw_dien_tich = get_post_meta($post_id, 'dien_tich', true) ?: (function_exists('get_field') ? get_field('dien_tich') : '');
    $dien_tich = 'Đang cập nhật';
    if ($raw_dien_tich) {
        $raw_dien_tich = trim((string)$raw_dien_tich);
        if (preg_match('/^\d+$/', $raw_dien_tich)) {
            $dien_tich = number_format((float)$raw_dien_tich, 0, ',', '.') . ' m²';
        } elseif (preg_match('/^(\d+)(?:-(\d+))+$/', $raw_dien_tich)) {
            $nums = explode('-', $raw_dien_tich);
            $min_n = number_format((float)$nums[0], 0, ',', '.');
            $max_n = number_format((float)end($nums), 0, ',', '.');
            $dien_tich = $min_n . ' - ' . $max_n . ' m²';
        } elseif (preg_match('/([\d,.]+\s*(?:m[²2]|mét vuông|hecta|ha))/iu', $raw_dien_tich, $m_dt)) {
            $matched_dt = trim($m_dt[1]);
            $matched_dt = preg_replace('/mét\s*vuông/iu', 'm²', $matched_dt);
            $dien_tich = $matched_dt;
        } elseif (mb_strlen($raw_dien_tich, 'UTF-8') > 30) {
            $dien_tich = mb_substr($raw_dien_tich, 0, 26, 'UTF-8') . '...';
        } else {
            $dien_tich = $raw_dien_tich;
            if (!preg_match('/(m[²2]|ha|hecta|mét)/iu', $dien_tich)) {
                $dien_tich .= ' m²';
            }
        }
    }

    // 4. Mức giá & Đơn vị tính thông minh (chuẩn hóa tỷ / triệu)
    $raw_gia = get_post_meta($post_id, 'gia', true) ?: get_post_meta($post_id, 'gia_thue', true) ?: (function_exists('get_field') ? (get_field('gia') ?: get_field('gia_thue')) : '');
    $raw_gia = trim((string)$raw_gia);

    $gia_thue = 'Liên hệ báo giá';
    $don_vi_tinh = 'Giá tham khảo';

    if ($raw_gia && !in_array(mb_strtolower($raw_gia, 'UTF-8'), array('liên hệ', 'thỏa thuận', 'thoa thuan', 'lien he', 'đang cập nhật', 'dang cap nhat'))) {
        $num_clean = str_replace(array('.', ',', ' '), '', $raw_gia);
        if (is_numeric($num_clean)) {
            $num = (float)$num_clean;
            if ($num >= 1000000000) {
                $ty = $num / 1000000000;
                $gia_thue = rtrim(rtrim(number_format($ty, 2, ',', '.'), '0'), ',') . ' tỷ';
                $don_vi_tinh = number_format($num, 0, ',', '.') . ' VNĐ';
            } elseif ($num >= 1000000) {
                $trieu = $num / 1000000;
                $gia_thue = rtrim(rtrim(number_format($trieu, 1, ',', '.'), '0'), ',') . ' triệu';
                $don_vi_tinh = number_format($num, 0, ',', '.') . ' VNĐ';
            } else {
                $gia_thue = number_format($num, 0, ',', '.') . ' VNĐ';
                $don_vi_tinh = 'Giá tham khảo';
            }
        } else {
            $gia_thue = $raw_gia;
            $don_vi_tinh = 'Giá tham khảo';
        }
    }

    // 5. Khu vực & Vị trí
    $khu_vuc = get_post_meta($post_id, 'khu_vuc', true) ?: (function_exists('get_field') ? get_field('khu_vuc') : '') ?: get_post_meta($post_id, 'vi_tri', true) ?: (function_exists('get_field') ? get_field('vi_tri') : '') ?: 'Long An';
    $vi_tri = $khu_vuc;
    $trang_thai = 'CÒN TRỐNG';

    // 6. Tiện ích Checklist làm sạch (loại bỏ tiêu đề mục thừa)
    $tien_ich_raw = get_post_meta($post_id, 'tien_ich', true) ?: (function_exists('get_field') ? get_field('tien_ich') : '');
    $tien_ich_arr = array();
    if ($tien_ich_raw) {
        $lines = is_array($tien_ich_raw) ? $tien_ich_raw : explode("\n", (string)$tien_ich_raw);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            // Loại bỏ dòng là tiêu đề rác của trang nguồn
            if (preg_match('/^(tiện\s*ích|đặc\s*điểm\s*nổi\s*bật|vị\s*trí|bản\s*đồ|mô\s*tả\s*chi\s*tiết|thông\s*tin\s*tổng\s*quan)/iu', $line)) {
                continue;
            }
            if (mb_strlen($line, 'UTF-8') > 120) continue;
            $tien_ich_arr[] = $line;
        }
    }
    if (empty($tien_ich_arr)) {
        if ($is_dat) {
            $tien_ich_arr = array(
                'Pháp lý hoàn chỉnh, ký hợp đồng nhanh',
                'Hạ tầng đồng bộ, đường xe container 24/24',
                'Trạm điện công suất lớn, nguồn nước ổn định',
                'Thuận tiện mở nhà máy, kho bãi, logistics',
                'Chính sách ưu đãi thuế đầu tư tốt',
                'Hỗ trợ xin cấp phép xây dựng & ĐTM'
            );
        } else {
            $tien_ich_arr = array(
                'Hệ thống PCCC nghiệm thu tự động',
                'Đường xe container ra vào 24/24',
                'Trạm biến áp riêng / Điện 3 pha',
                'Sàn bê tông chịu lực / Sơn Epoxy',
                'Văn phòng làm việc đi kèm',
                'Pháp lý đầy đủ, bàn giao sử dụng ngay'
            );
        }
    }

    // 7. Mô tả chi tiết làm sạch (xóa khoảng trống thừa)
    $mo_ta_chi_tiet = get_post_meta($post_id, 'mo_ta_chi_tiet', true) ?: (function_exists('get_field') ? get_field('mo_ta_chi_tiet') : '');
    if ($mo_ta_chi_tiet) {
        $mo_ta_chi_tiet = preg_replace('/^\s*mô\s*tả\s*chi\s*tiết\s*/iu', '', $mo_ta_chi_tiet);
        $mo_ta_chi_tiet = preg_replace("/[\r\n]{3,}/u", "\n\n", trim($mo_ta_chi_tiet));
    }

    // 8. Ảnh đại diện
    $thumb_url = get_the_post_thumbnail_url($post_id, 'full');
    if (!$thumb_url) {
        $thumb_url = 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/cho-thue-kho-xuong-3000m2-kcn-hoa-khanh-da-nang.jpg';
    }

    // 9. Thư viện ảnh Gallery (đa nguồn: _kcn_gallery_ids, attached media, ACF, query theo slug)
    $gallery_images = array();
    $raw_gallery_ids = get_post_meta($post_id, '_kcn_gallery_ids', true);
    if ($raw_gallery_ids) {
        $ids = array_filter(array_map('intval', explode(',', (string)$raw_gallery_ids)));
        foreach ($ids as $img_id) {
            $img_url = wp_get_attachment_image_url($img_id, 'full');
            if ($img_url && !in_array($img_url, $gallery_images)) {
                $gallery_images[] = $img_url;
            }
        }
    }
    if (empty($gallery_images)) {
        $attached = get_attached_media('image', $post_id);
        if (!empty($attached)) {
            foreach ($attached as $att) {
                $img_url = wp_get_attachment_image_url($att->ID, 'full');
                if ($img_url && !in_array($img_url, $gallery_images)) {
                    $gallery_images[] = $img_url;
                }
            }
        }
    }
    if (empty($gallery_images) && function_exists('get_field')) {
        $acf_gallery = get_field('gallery_anh');
        if (is_array($acf_gallery)) {
            foreach ($acf_gallery as $g) {
                $g_url = is_array($g) ? ($g['url'] ?? '') : $g;
                if ($g_url && !in_array($g_url, $gallery_images)) $gallery_images[] = $g_url;
            }
        }
    }
    // Quét bổ sung trong Media Library theo stem của post slug nếu gallery đang trống
    if (empty($gallery_images)) {
        $post_slug = get_post_field('post_name', $post_id);
        if ($post_slug) {
            global $wpdb;
            $stem = preg_replace('/-\d+$/', '', $post_slug);
            $results = $wpdb->get_col($wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%' AND post_name LIKE %s ORDER BY ID ASC LIMIT 10",
                $wpdb->esc_like($stem) . '%'
            ));
            if (!empty($results)) {
                foreach ($results as $att_id) {
                    $u = wp_get_attachment_image_url($att_id, 'full');
                    if ($u && !in_array($u, $gallery_images)) {
                        $gallery_images[] = $u;
                    }
                }
            }
        }
    }
    // Đảm bảo ảnh đại diện luôn có mặt đầu tiên nếu gallery có nhiều ảnh
    if (!empty($gallery_images) && !in_array($thumb_url, $gallery_images)) {
        array_unshift($gallery_images, $thumb_url);
    }

    // 10. Bản đồ Google Maps thông minh (dùng tọa độ hoặc địa chỉ khu vực)
    $lat = get_post_meta($post_id, 'lat', true) ?: (function_exists('get_field') ? get_field('lat') : '');
    $lng = get_post_meta($post_id, 'lng', true) ?: (function_exists('get_field') ? get_field('lng') : '');
    if ($lat && $lng && is_numeric($lat) && is_numeric($lng)) {
        $google_map = '<iframe src="https://maps.google.com/maps?q=' . esc_attr($lat) . ',' . esc_attr($lng) . '&z=14&output=embed" style="width:100%;height:100%;border:0;"></iframe>';
    } else {
        $map_query = (!empty($khu_vuc) && $khu_vuc !== 'Đang cập nhật') ? ($khu_vuc . ', Việt Nam') : 'Long An, Việt Nam';
        $google_map = '<iframe src="https://maps.google.com/maps?q=' . rawurlencode($map_query) . '&z=13&output=embed" style="width:100%;height:100%;border:0;"></iframe>';
    }
?>

<!-- PAGE HERO -->
<section class="kxd-page-hero">
    <div class="kxd-wrap">
        <div class="kxd-breadcrumb">
            <a href="<?php echo home_url('/'); ?>">Trang chủ</a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></a>
            <span class="sep">/</span>
            <span><?php the_title(); ?></span>
        </div>
        <h1 class="kxd-page-title"><?php the_title(); ?></h1>
        <div class="kxd-page-meta">
            <span class="kxd-meta-pill"><?php echo esc_html($loai_hinh); ?></span>
            <span class="kxd-meta-pill gray">📍 <?php echo esc_html($khu_vuc); ?></span>
            <span class="kxd-meta-pill gray">● <?php echo esc_html($trang_thai); ?></span>
            <span class="kxd-meta-pill gray">Cập nhật gần đây</span>
        </div>
    </div>
</section>

<!-- MAIN CONTENT -->
<main class="kxd-main-content">
    <div class="kxd-wrap">
        <div class="kxd-detail-grid">

            <!-- CỘT TRÁI: NỘI DUNG CHI TIẾT -->
            <div class="kxd-stack">

                <!-- 1. ẢNH THỰC TẾ DỰ ÁN & THUMBNAILS -->
                <?php 
                $sub_gallery = array();
                if (!empty($gallery_images)) {
                    foreach ($gallery_images as $g_img) {
                        if ($g_img !== $thumb_url) {
                            $sub_gallery[] = $g_img;
                        }
                    }
                }
                ?>
                <div class="kxd-section-card" style="padding:0; overflow:hidden; border:none; background:transparent;">
                    <div class="gallery<?php echo !empty($sub_gallery) ? ' has-side' : ' no-side'; ?>">
                        <div class="cover" role="img" aria-label="Ảnh thực tế <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($thumb_url); ?>')">
                            <span class="photo-label">📸 Ảnh thực tế · <?php the_title(); ?></span>
                        </div>
                        <?php if (!empty($sub_gallery)): ?>
                        <div class="side">
                            <?php 
                            $side_images = array_slice($sub_gallery, 0, 2);
                            foreach ($side_images as $img):
                                $img_u = is_array($img) ? ($img['sizes']['medium'] ?? $img['url']) : $img;
                            ?>
                            <div role="img" aria-label="Ảnh thêm <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($img_u); ?>')" onclick="document.querySelector('.gallery .cover').style.backgroundImage='url(<?php echo esc_url($img_u); ?>)';"></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if (count($gallery_images) > 1): ?>
                    <div class="kxd-gallery-thumbs">
                        <?php foreach ($gallery_images as $img):
                            $img_u = is_array($img) ? $img['url'] : $img;
                        ?>
                        <div class="kxd-thumb-item" style="background-image:url('<?php echo esc_url($img_u); ?>');"
                             onclick="document.querySelector('.gallery .cover').style.backgroundImage='url(<?php echo esc_url($img_u); ?>)';"
                             title="Nhấn để xem ảnh này">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- 2. THÔNG TIN TỔNG QUAN -->
                <section class="kxd-section-card">
                    <h2>📋 Thông tin tổng quan</h2>
                    <div class="kxd-feature-grid">
                        <div class="kxd-feature-item">
                            <span class="label">Mã tin</span>
                            <span class="value"><?php echo esc_html($ma_tin); ?></span>
                        </div>
                        <div class="kxd-feature-item">
                            <span class="label">Diện tích</span>
                            <span class="value"><?php echo esc_html($dien_tich); ?></span>
                        </div>
                        <div class="kxd-feature-item">
                            <span class="label">Mức giá</span>
                            <span class="value price"><?php echo esc_html($gia_thue); ?></span>
                        </div>
                        <div class="kxd-feature-item">
                            <span class="label">Loại hình</span>
                            <span class="value"><?php echo esc_html($loai_hinh); ?></span>
                        </div>
                        <div class="kxd-feature-item">
                            <span class="label">Khu vực</span>
                            <span class="value"><?php echo esc_html($khu_vuc); ?></span>
                        </div>
                        <div class="kxd-feature-item">
                            <span class="label">Trạng thái</span>
                            <span class="value" style="color:var(--kxd-green);"><?php echo esc_html($trang_thai); ?></span>
                        </div>
                    </div>
                </section>

                <!-- 3. MÔ TẢ CHI TIẾT -->
                <section class="kxd-section-card">
                    <h2>📝 Mô tả chi tiết</h2>
                    <div class="kxd-entry-content">
                        <?php if ( !empty($mo_ta_chi_tiet) ) : 
                            // Làm sạch mô tả chi tiết: bỏ tiêu đề trùng lặp, bỏ link đối thủ, bóc tách bullet points và hotline
                            $desc_clean = preg_replace('/👉?\s*Xem\s*thêm\s*tại\s*(?:www\.)?khoxuongdep\.com\.vn[^\n\r]*/iu', '', $mo_ta_chi_tiet);
                            $desc_clean = preg_replace('/(?:www\.)?khoxuongdep\.com\.vn/iu', 'batdongsankhucongnghiep.vn', $desc_clean);
                            $desc_clean = preg_replace('/^\s*mô\s*tả\s*chi\s*tiết\s*/iu', '', $desc_clean);
                            
                            $desc_lines = explode("\n", str_replace("\r", "", $desc_clean));
                            $title_raw = function_exists('wp_specialchars_decode') ? wp_specialchars_decode(get_the_title(), ENT_QUOTES) : html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8');
                            $title_norm = preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower($title_raw, 'UTF-8'));
                            
                            $valid_lines = array();
                            foreach ($desc_lines as $dl) {
                                $line = trim($dl);
                                if ($line === '') continue;
                                $line_raw = function_exists('wp_specialchars_decode') ? wp_specialchars_decode($line, ENT_QUOTES) : html_entity_decode($line, ENT_QUOTES, 'UTF-8');
                                $line_norm = preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower($line_raw, 'UTF-8'));
                                if (!empty($title_norm) && ($line_norm === $title_norm || (strpos($title_norm, $line_norm) !== false && mb_strlen($line_norm, 'UTF-8') > 20) || (strpos($line_norm, $title_norm) !== false && mb_strlen($title_norm, 'UTF-8') > 20))) {
                                    continue;
                                }
                                // Bỏ dòng chỉ chứa icon emoji đơn độc
                                if (preg_match('/^[\x{1F300}-\x{1F9FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE00}-\x{FE0F}\s]+$/u', $line)) {
                                    continue;
                                }
                                $valid_lines[] = $line;
                            }
                            
                            $pending_bullets = array();
                            foreach ($valid_lines as $vl):
                                if (preg_match('/(?:hotline|zalo|liên\s*hệ|mr\s*lương|\b09\d{8}\b)/iu', $vl)):
                                    if (!empty($pending_bullets)): ?>
                                        <div class="kxd-desc-highlights">
                                            <?php foreach ($pending_bullets as $pb): ?>
                                                <div class="kxd-desc-point">
                                                    <span class="kxd-point-icon">✓</span>
                                                    <span><?php echo esc_html($pb); ?></span>
                                                </div>
                                            <?php endforeach; $pending_bullets = array(); ?>
                                        </div>
                                    <?php endif; 
                                    $phone_clean = '0909 161 824';
                                    if (preg_match('/(0\d{9,10})/', $vl, $pm)) $phone_clean = $pm[1];
                                    $contact_text = trim(preg_replace('/^[\x{1F300}-\x{1F9FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE00}-\x{FE0F}\s]+/u', '', $vl));
                                    ?>
                                    <div class="kxd-desc-contact-card">
                                        <div class="kxd-dcc-icon">📞</div>
                                        <div class="kxd-dcc-body">
                                            <div class="kxd-dcc-title">Liên Hệ Trực Tiếp & Xem Thực Địa</div>
                                            <div class="kxd-dcc-text"><?php echo esc_html($contact_text); ?></div>
                                        </div>
                                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone_clean)); ?>" class="kxd-dcc-btn">Gọi Tư Vấn</a>
                                    </div>
                                <?php elseif (preg_match('/^(?:[–\-+*•]|\d+[.)\/])\s*(.*)$/u', $vl, $bm)):
                                    $pending_bullets[] = trim(preg_replace('/^[\x{1F300}-\x{1F9FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE00}-\x{FE0F}\s]+/u', '', $bm[1]));
                                else:
                                    if (!empty($pending_bullets)): ?>
                                        <div class="kxd-desc-highlights">
                                            <?php foreach ($pending_bullets as $pb): ?>
                                                <div class="kxd-desc-point">
                                                    <span class="kxd-point-icon">✓</span>
                                                    <span><?php echo esc_html($pb); ?></span>
                                                </div>
                                            <?php endforeach; $pending_bullets = array(); ?>
                                        </div>
                                    <?php endif; 
                                    $para_clean = trim(preg_replace('/^[\x{1F300}-\x{1F9FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE00}-\x{FE0F}\s]+/u', '', $vl));
                                    if (!empty($para_clean)):
                                    ?>
                                        <p class="kxd-desc-para"><?php echo esc_html($para_clean); ?></p>
                                    <?php endif; ?>
                                <?php endif;
                            endforeach;
                            if (!empty($pending_bullets)): ?>
                                <div class="kxd-desc-highlights">
                                    <?php foreach ($pending_bullets as $pb): ?>
                                        <div class="kxd-desc-point">
                                            <span class="kxd-point-icon">✓</span>
                                            <span><?php echo esc_html($pb); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php elseif ( get_the_content() ) : ?>
                            <?php
                            $prod_content = get_the_content();
                            $prod_content = preg_replace('/<(style|script)\b[^>]*>(.*?)<\/\1>/isu', '', $prod_content);
                            $prod_content = preg_replace('/<style\b[^>]*>.*?$/isu', '', $prod_content);
                            $prod_content = preg_replace('/<div class="kxd-kxd-banner".*?<\/div>\s*<\/div>/isu', '', $prod_content);
                            $prod_content = preg_replace('/<!--.*?-->/su', '', $prod_content);
                            echo apply_filters('the_content', $prod_content);
                            ?>
                        <?php else: ?>
                            <p><strong><?php the_title(); ?></strong></p>
                            <p>– <strong>Vị trí:</strong> <?php echo esc_html($vi_tri); ?></p>
                            <p>– <strong>Diện tích:</strong> <?php echo esc_html($dien_tich); ?></p>
                            <p>– <strong>Giá tham khảo:</strong> <?php echo esc_html($gia_thue); ?> (<?php echo esc_html($don_vi_tinh); ?>)</p>
                            <p>– <strong>Hiện trạng:</strong> Mặt bằng tiêu chuẩn, sạch đẹp, hệ thống PCCC nghiệm thu, trạm biến áp công suất lớn, nền bê tông chịu tải cao.</p>
                            <p>– <strong>Pháp lý:</strong> Đầy đủ giấy tờ hợp lệ, hỗ trợ ký hợp đồng và bàn giao mặt bằng nhanh chóng.</p>
                            <p>– <strong>Liên hệ:</strong> BDS24H / Kho Xưởng Đẹp – Hotline/Zalo: <strong>0909 161 824</strong></p>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- 4. TIỆN ÍCH & ĐẶC ĐIỂM NỔI BẬT -->
                <section class="kxd-section-card">
                    <h2>⭐ Tiện ích & đặc điểm nổi bật</h2>
                    <ul class="kxd-checklist">
                        <?php foreach($tien_ich_arr as $item): 
                            $text = trim($item);
                            if (!empty($text)): ?>
                                <li><?php echo esc_html($text); ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </section>

                <!-- BANNER PHÒNG XÚC TIẾN ĐẦU TƯ -->
                <section class="invest-promo-banner">
                    <div class="ipb-top">
                        <div class="ipb-badge-wrap">
                            <span class="ipb-pulse-dot"></span>
                            <span>Ban Xúc Tiến Đầu Tư &amp; Hỗ Trợ Doanh Nghiệp</span>
                        </div>
                        <div class="ipb-live-text">⚡ Tiếp nhận yêu cầu &amp; báo giá trong 15 phút</div>
                    </div>
                    <div class="ipb-content-grid">
                        <div class="ipb-main-info">
                            <h3>Liên hệ <span>Phòng Xúc Tiến Đầu Tư</span> BDS24H</h3>
                            <p class="ipb-intro-desc">Đầu mối chuyên trách hỗ trợ tìm kiếm kho xưởng, quỹ đất công nghiệp theo tiêu chuẩn riêng và đồng hành hoàn thiện thủ tục pháp lý, cấp phép đầu tư trọn gói.</p>
                            <div class="ipb-feature-list">
                                <div class="ipb-feature-item">
                                    <div class="ipb-feature-icon">🏭</div>
                                    <div><strong>Quỹ kho xưởng &amp; đất thực tế:</strong> <span>Nắm nguồn chính chủ, khảo sát hiện trạng thực tế, pháp lý rõ ràng.</span></div>
                                </div>
                                <div class="ipb-feature-item">
                                    <div class="ipb-feature-icon">📑</div>
                                    <div><strong>Hỗ trợ pháp lý &amp; hợp đồng:</strong> <span>Tư vấn hợp đồng thuê mua, thủ tục PCCC, ĐTM &amp; giấy phép kinh doanh.</span></div>
                                </div>
                                <div class="ipb-feature-item">
                                    <div class="ipb-feature-icon">🚗</div>
                                    <div><strong>Dẫn xem thực địa miễn phí:</strong> <span>Hỗ trợ xe đưa đón, kiểm tra xe tải container, đường điện và trạm biến áp.</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="ipb-action-card">
                            <div class="ipb-action-card-tag">Hotline Phòng Xúc Tiến</div>
                            <a href="tel:0909161824" class="ipb-phone-highlight">0909 161 824</a>
                            <div class="ipb-phone-desc">Chuyên viên tư vấn &amp; dẫn khảo sát 24/7</div>
                            <div class="ipb-buttons">
                                <a class="ipb-btn-hotline" href="tel:0909161824">
                                    <span>📞</span>
                                    <span>Gọi Hotline Ngay</span>
                                </a>
                                <a class="ipb-btn-zalo" href="https://zalo.me/0909161824" target="_blank" rel="noopener">
                                    <span>💬</span>
                                    <span>Chat Zalo Nhận Báo Giá</span>
                                </a>
                            </div>
                            <div class="ipb-footer-note">
                                <span>⏱️ Hỗ trợ 24/7 (Kể cả Thứ 7 &amp; Chủ Nhật)</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 5. VỊ TRÍ & BẢN ĐỒ -->
                <section class="kxd-section-card">
                    <h2>📍 Vị trí & kết nối giao thông</h2>
                    <p class="kxd-entry-content" style="margin-bottom:12px;">
                        Bất động sản tọa lạc tại <strong><?php echo esc_html($vi_tri); ?></strong>. Kết nối giao thông thuận tiện tới các tuyến quốc lộ huyết mạch, cảng biển và sân bay, đáp ứng xe container và xe tải trọng lớn ra vào 24/7.
                    </p>
                    <div class="kxd-map-wrap">
                        <?php echo $google_map; ?>
                    </div>
                </section>

            </div>

            <!-- CỘT PHẢI: SIDEBAR BÁO GIÁ & LIÊN HỆ -->
            <aside class="kxd-sidebar">
                <section class="panel price-card">
                    <div class="price-label">GIÁ THAM KHẢO</div>
                    <div class="price"><?php echo esc_html($gia_thue); ?></div>
                    <div class="unit"><?php echo esc_html($don_vi_tinh); ?></div>

                    <a class="cta cta-orange" href="tel:0909161824">📞 NHẬN TƯ VẤN &amp; KHẢO SÁT</a>
                    <a class="cta cta-green" href="https://zalo.me/0909161824" target="_blank" rel="noopener">💬 CHAT ZALO TƯ VẤN</a>
                    <a class="cta cta-fb" href="https://www.facebook.com/share/18skMpo77a/?mibextid=wwXIfr" target="_blank" rel="noopener">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#ffffff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>FACEBOOK FANPAGE</span>
                    </a>

                    <div class="agent">
                        <strong>Chuyên viên BDS24H</strong>
                        <div class="agent-hotline">Hotline / Zalo: 0909 161 824</div>
                        <div class="agent-desc">Hỗ trợ hồ sơ pháp lý và kết nối chủ đầu tư</div>
                    </div>
                </section>
                <section class="panel source" style="background:#ffffff; border:1px solid var(--kxd-border); border-radius:var(--kxd-radius); padding:14px 18px; margin-top:14px; box-shadow:0 2px 8px rgba(0,0,0,0.03);">
                    <div style="font-size:12.5px; color:#475569; display:flex; align-items:center; gap:8px;">
                        <span style="color:var(--kxd-green); font-weight:700;">✔</span>
                        <span>Thông tin bất động sản xác thực bởi <strong>BDS24H</strong></span>
                    </div>
                </section>
            </aside>

        </div>
    </div>
</main>

<!-- LIGHTBOX MODAL BẬT XEM ẢNH PHÓNG TO -->
<div class="image-lightbox" id="image-lightbox" role="dialog" aria-modal="true" aria-label="Xem ảnh phóng to">
    <button class="image-lightbox-close" type="button" aria-label="Đóng ảnh phóng to">×</button>
    <img src="" alt="">
    <div class="image-lightbox-caption"></div>
</div>

<script>
// SCRIPT XEM ẢNH LIGHTBOX
(function () {
    var lightbox = document.getElementById('image-lightbox');
    if (!lightbox) return;

    // Đưa modal trực tiếp ra thẻ <body> để thoát khỏi mọi stacking context hạn chế của theme
    if (lightbox.parentNode !== document.body) {
        document.body.appendChild(lightbox);
    }

    var preview = lightbox.querySelector('img');
    var caption = lightbox.querySelector('.image-lightbox-caption');
    var closeButton = lightbox.querySelector('.image-lightbox-close');
    var lastTrigger;

    function getImageUrl(element) {
        var match = (element.style.backgroundImage || '').match(/url\(["']?(.*?)["']?\)/);
        return match ? match[1] : (element.getAttribute('data-img') || '');
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        preview.removeAttribute('src');
        document.documentElement.classList.remove('lightbox-open');
        document.body.classList.remove('lightbox-open');
        document.body.style.overflow = '';
        if (lastTrigger) lastTrigger.focus();
    }

    function openLightbox(url, altText, trigger) {
        if (!url) return;
        lastTrigger = trigger;
        preview.src = url;
        preview.alt = altText || 'Ảnh bất động sản';
        caption.textContent = preview.alt;
        lightbox.classList.add('is-open');
        document.documentElement.classList.add('lightbox-open');
        document.body.classList.add('lightbox-open');
        document.body.style.overflow = 'hidden';
        closeButton.focus();
    }

    document.querySelectorAll('.gallery .cover, .gallery .side div, .kxd-thumb-item').forEach(function (image) {
        image.setAttribute('tabindex', '0');
        image.setAttribute('role', 'button');
        image.setAttribute('aria-label', 'Mở ảnh phóng to');
        image.addEventListener('click', function (e) {
            if (image.classList.contains('kxd-thumb-item')) {
                return;
            }
            var url = getImageUrl(image);
            if (!url) return;
            var title = image.querySelector('.photo-label') ? image.querySelector('.photo-label').textContent : 'Ảnh thực tế · <?php echo esc_js(get_the_title()); ?>';
            openLightbox(url, title, image);
        });
        image.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                image.click();
            }
        });
    });

    closeButton.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });

    // Chặn cuộn nền khi đang mở lightbox
    lightbox.addEventListener('wheel', function (e) {
        e.preventDefault();
    }, { passive: false });
    lightbox.addEventListener('touchmove', function (e) {
        e.preventDefault();
    }, { passive: false });
}());
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>