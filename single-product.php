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

    /* Ẩn Header mặc định của theme nếu xung đột */
    .pearl-header-wrap, .stm-header, .header-default, header.pearl-header {
        display: none !important;
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

    /* GALLERY MAIN */
    .kxd-gallery-main {
        position: relative;
        border-radius: var(--kxd-radius);
        overflow: hidden;
        background: #000;
        aspect-ratio: 16 / 10;
    }
    .kxd-gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .kxd-gallery-badge {
        position: absolute;
        bottom: 16px;
        left: 16px;
        background: rgba(0, 0, 0, 0.75);
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 6px;
        backdrop-filter: blur(4px);
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
        font-size: 15px;
        line-height: 1.75;
        color: #000000;
    }
    .kxd-entry-content p {
        margin: 0 0 14px;
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
    .kxd-price-box {
        background: #ffffff;
        border: 1px solid var(--kxd-border);
        border-radius: var(--kxd-radius);
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
    }
    .kxd-price-box .label {
        font-size: 12px;
        text-transform: uppercase;
        color: var(--kxd-text-muted);
        font-weight: 700;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 6px;
    }
    .kxd-price-box .price-display {
        font-family: 'Oswald', sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: var(--kxd-green);
        line-height: 1.2;
        margin-bottom: 6px;
    }
    .kxd-price-box .price-unit {
        font-size: 13.5px;
        color: var(--kxd-text-muted);
        margin-bottom: 18px;
        display: block;
    }
    .kxd-price-box .cta-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 46px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all .2s;
        margin-bottom: 10px;
        border: none;
    }
    .kxd-price-box .cta-btn.primary {
        background: var(--kxd-green);
        color: #ffffff;
    }
    .kxd-price-box .cta-btn.primary:hover {
        background: var(--kxd-green-dark);
        transform: translateY(-2px);
    }
    .kxd-price-box .cta-btn.zalo {
        background: #0068FF;
        color: #ffffff;
    }
    .kxd-price-box .cta-btn.zalo:hover {
        background: #0052cc;
        transform: translateY(-2px);
    }

    .kxd-agent-card {
        background: #ffffff;
        border: 1px solid var(--kxd-border);
        border-radius: var(--kxd-radius);
        padding: 20px;
    }
    .kxd-agent-head {
        display: flex;
        gap: 14px;
        align-items: center;
        margin-bottom: 14px;
    }
    .kxd-agent-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--kxd-green), #16a34a);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 16px;
        flex-shrink: 0;
    }
    .kxd-agent-head h3 {
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 4px;
        color: #000000;
    }
    .kxd-agent-head p {
        font-size: 12.5px;
        color: var(--kxd-text-muted);
        margin: 0;
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
    // Xác định Chuyên mục
    $categories = get_the_category();
    $cat_name = 'Kho Xưởng';
    $cat_url = home_url('/kho-xuong/');
    $loai_hinh_default = 'Kho Xưởng Cho Thuê';

    if ( !empty($categories) ) {
        foreach ($categories as $cat) {
            if ($cat->slug === 'dat-cong-nghiep') {
                $cat_name = 'Đất Công Nghiệp';
                $cat_url = home_url('/dat-cong-nghiep/');
                $loai_hinh_default = 'Đất Công Nghiệp';
                break;
            } elseif ($cat->slug === 'kho-xuong') {
                $cat_name = 'Kho Xưởng';
                $cat_url = home_url('/kho-xuong/');
                $loai_hinh_default = 'Kho Xưởng Cho Thuê';
                break;
            }
        }
    }

    // Lấy dữ liệu ACF — dùng ĐÚNG tên field trong bộ ACF đã tạo cho dữ liệu crawl mới
    // (ma_tin, loai_hinh, khu_vuc, dien_tich, gia, mo_ta_chi_tiet, tien_ich, lat, lng,
    // url_nguon, gallery_anh) — xem file acf-bds-cong-nghiep-fields-simplified.json
    $post_id = get_the_ID();
    $ma_tin = get_post_meta($post_id, 'ma_tin', true) ?: get_field('ma_tin') ?: 'KXD-' . $post_id;
    $dien_tich = get_post_meta($post_id, 'dien_tich', true) ?: get_field('dien_tich') ?: '3.000 m²';
    $gia_thue = get_post_meta($post_id, 'gia', true) ?: get_post_meta($post_id, 'gia_thue', true) ?: get_field('gia') ?: get_field('gia_thue') ?: 'Liên hệ báo giá';
    if (strpos($gia_thue, 'tầng') !== false) $gia_thue = 'Liên hệ báo giá';
    $don_vi_tinh = 'Giá tham khảo';
    $loai_hinh = get_post_meta($post_id, 'loai_hinh', true) ?: get_field('loai_hinh') ?: $loai_hinh_default;
    $khu_vuc = get_post_meta($post_id, 'khu_vuc', true) ?: get_field('khu_vuc') ?: get_post_meta($post_id, 'vi_tri', true) ?: get_field('vi_tri') ?: 'Đang cập nhật';
    $vi_tri = $khu_vuc;
    $trang_thai = 'CÒN TRỐNG';
    $mo_ta_chi_tiet = get_post_meta($post_id, 'mo_ta_chi_tiet', true) ?: get_field('mo_ta_chi_tiet') ?: '';

    // Tiện ích Checklist — field "tien_ich" bên crawl là TEXTAREA, mỗi tiện ích 1 DÒNG
    // (không phải phân cách bằng dấu phẩy như bản cũ) -> tách theo xuống dòng
    $tien_ich_raw = get_field('tien_ich');
    if (!$tien_ich_raw) {
        $tien_ich_arr = array(
            'Hệ thống PCCC tự động đầy đủ',
            'Đường xe container 24/24',
            'Trạm biến áp riêng / Điện 3 pha',
            'Sàn bê tông chịu lực / Sơn Epoxy',
            'Văn phòng làm việc đi kèm',
            'Pháp lý hoàn chỉnh, ký hợp đồng nhanh'
        );
    } else {
        $tien_ich_arr = is_array($tien_ich_raw) ? $tien_ich_raw : array_map('trim', explode("\n", $tien_ich_raw));
    }

    // Ảnh đại diện — ưu tiên Featured Image (script import đã tự gán ảnh đầu tiên làm
    // featured_media), KHÔNG cần field "anh_thuc_te" riêng nữa
    $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    if (!$thumb_url) {
        $thumb_url = 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/cho-thue-kho-xuong-3000m2-kcn-hoa-khanh-da-nang.jpg';
    }

    // Toàn bộ ảnh gallery — ưu tiên đọc từ metabox Native Gallery _kcn_gallery_ids (không cần ACF Pro)
    $gallery_images = array();
    $raw_gallery_ids = get_post_meta(get_the_ID(), '_kcn_gallery_ids', true);
    if ($raw_gallery_ids) {
        $ids = array_filter(array_map('intval', explode(',', (string)$raw_gallery_ids)));
        foreach ($ids as $img_id) {
            $img_url = wp_get_attachment_image_url($img_id, 'full');
            if ($img_url) {
                $gallery_images[] = $img_url;
            }
        }
    }
    // Fallback nếu có ACF field gallery_anh
    if (empty($gallery_images)) {
        $acf_gallery = get_field('gallery_anh');
        if (is_array($acf_gallery)) {
            foreach ($acf_gallery as $g) {
                $g_url = is_array($g) ? ($g['url'] ?? '') : $g;
                if ($g_url) $gallery_images[] = $g_url;
            }
        }
    }

    // Map Embed — field crawl lưu riêng lat/lng (KHÔNG lưu sẵn chuỗi iframe như bản cũ)
    // -> tự dựng chuỗi iframe từ lat/lng nếu có
    $lat = get_field('lat');
    $lng = get_field('lng');
    if ($lat && $lng) {
        $google_map = '<iframe src="https://maps.google.com/maps?q=' . esc_attr($lat) . ',' . esc_attr($lng) . '&z=14&output=embed" style="width:100%;height:100%;border:0;"></iframe>';
    } else {
        $google_map = '<iframe src="https://maps.google.com/maps?q=16.07,108.15&z=13&output=embed" style="width:100%;height:100%;border:0;"></iframe>';
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

                <!-- 1. ẢNH THỰC TẾ DỰ ÁN -->
                <div class="kxd-section-card" style="padding:0; overflow:hidden; border:none;">
                    <div class="kxd-gallery-main">
                        <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title(); ?>">
                        <span class="kxd-gallery-badge">📸 Ảnh thực tế bất động sản</span>
                    </div>
                    <?php if (!empty($gallery_images)): ?>
                    <div class="kxd-gallery-thumbs" style="display:flex; gap:8px; padding:10px; flex-wrap:wrap;">
                        <?php foreach ($gallery_images as $img):
                            $img_src = is_array($img) ? ($img['sizes']['medium'] ?? $img['url']) : $img;
                            $img_full = is_array($img) ? $img['url'] : $img;
                        ?>
                            <img src="<?php echo esc_url($img_src); ?>"
                                 alt="<?php the_title(); ?>"
                                 style="width:110px; height:80px; object-fit:cover; border-radius:6px; cursor:pointer;"
                                 onclick="document.querySelector('.kxd-gallery-main img').src='<?php echo esc_js($img_full); ?>';">
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
                        <?php
                        // Ưu tiên field ACF "mo_ta_chi_tiet" (nơi import script lưu mô tả crawl
                        // được) — get_the_content() thường trống vì script chỉ ghi vào ACF, không
                        // ghi post_content chuẩn của WordPress.
                        $mo_ta_chi_tiet = get_field('mo_ta_chi_tiet');
                        ?>
                        <?php if ( $mo_ta_chi_tiet ) : ?>
                            <p><?php echo nl2br(esc_html($mo_ta_chi_tiet)); ?></p>
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
                <div class="kxd-price-box">
                    <span class="label">Mức giá tham khảo</span>
                    <div class="price-display"><?php echo esc_html($gia_thue); ?></div>
                    <span class="price-unit"><?php echo esc_html($don_vi_tinh); ?></span>
                    
                    <a href="tel:0909161824" class="cta-btn primary">
                        📞 Nhận Báo Giá & Khảo Sát
                    </a>
                    
                    <a href="https://zalo.me/0909161824" class="cta-btn zalo" target="_blank" rel="noopener">
                        💬 Tư Vấn Nhanh Qua Zalo
                    </a>
                    
                    <a href="https://www.facebook.com/share/18skMpo77a/?mibextid=wwXIfr" class="cta-btn" style="background:#1877f2;color:#ffffff;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;" target="_blank" rel="noopener">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#ffffff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook Fanpage
                    </a>
                </div>

                <div class="kxd-agent-card">
                    <div class="kxd-agent-head">
                        <div class="kxd-agent-avatar">BDS</div>
                        <div>
                            <h3>BDS24H – Kho Xưởng Đẹp</h3>
                            <p>Chuyên gia tư vấn BĐS Công Nghiệp</p>
                        </div>
                    </div>
                    <p style="font-size:13px; color:#000000; margin:0 0 12px;">
                        Hotline / Zalo: <strong style="color:var(--kxd-green); font-size:14.5px;">0909 161 824</strong><br>
                        Hỗ trợ thẩm định pháp lý, hồ sơ thuê & kết nối làm việc trực tiếp chủ đầu tư.
                    </p>
                </div>
            </aside>

        </div>
    </div>
</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>