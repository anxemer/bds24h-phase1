<?php
/**
 * Template Name: Chi Tiết Khu Công Nghiệp (Chuẩn 100% detail.html)
 * Post Type: khu-cong-nghiep, post, product
 * Description: Template chi tiết động ẩn 100% Header mặc định của Theme & mở rộng 1180px chuẩn detail.html
 */

get_header(); 
?>

<!-- =========================
     CSS TRIỆT ĐỂ ẨN HEADER THEME & MỞ RỘNG KHUNG 1180PX
========================= -->
<style>
	/* 1. TRIỆT ĐỂ ẨN HEADER VÀ TOPBAR MẶC ĐỊNH CỦA THEME PEARL / WORDPRESS */
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
	.stm-header__cell {
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
		background: #f4f6f3 !important;
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

	/* 3. KHUNG CHÍNH CHUẨN 1180PX Y HỆT DETAIL.HTML */
	.wrap {
		width: min(1180px, calc(100% - 40px)) !important;
		margin: 0 auto !important;
		padding: 0 !important;
	}
</style>

<!-- =========================
     CSS CHUẨN 100% DETAIL.HTML
========================= -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;600;700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

<style>
	:root {
		--ink: #000000;
		--navy: #0f7f2f;
		--teal: #16c04a;
		--red: #ff7f2a;
		--paper: #f4f6f3;
		--panel: #ffffff;
		--line: #e2e8f0;
		--muted: #000000;
	}

	body {
		background: var(--paper) !important;
		color: #000000;
		font-family: 'Roboto', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
		font-size: 15px;
		line-height: 1.6;
		-webkit-font-smoothing: antialiased;
	}

	.crumb {
		padding: 16px 0 12px;
		color: #000000 !important;
		font-family: 'Roboto', sans-serif;
		font-size: 12.5px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 0.04em;
	}

	.crumb a {
		color: #000000 !important;
		font-weight: 600;
		text-decoration: none;
	}

	.crumb a:hover {
		color: var(--navy);
	}

	.detail-shell {
		padding-bottom: 48px;
	}

	.detail-view {
		display: block !important;
	}

	.hero {
		background: #fff;
		border: 1px solid var(--line);
		border-radius: 12px;
		overflow: hidden;
	}

	.gallery {
		display: grid;
		grid-template-columns: 1.55fr 1fr;
		height: 330px;
		gap: 4px;
		background: #dfe4df;
	}

	.cover,
	.side div {
		background-size: cover;
		background-position: center;
		position: relative;
		cursor: zoom-in;
	}

	.cover:focus-visible,
	.side div:focus-visible {
		outline: 3px solid var(--navy);
		outline-offset: -3px;
	}

	.side {
		display: grid;
		grid-template-rows: 1fr 1fr;
		gap: 4px;
	}

	.photo-label {
		position: absolute;
		left: 14px;
		bottom: 14px;
		background: rgba(0, 0, 0, 0.75);
		color: #fff;
		padding: 5px 10px;
		border-radius: 4px;
		font-family: 'Roboto', sans-serif;
		font-size: 12px;
		font-weight: 500;
	}

	.heading {
		padding: 20px 24px 22px;
		display: flex;
		justify-content: space-between;
		gap: 24px;
		align-items: start;
	}

	.eyebrow {
		font-family: 'Roboto', sans-serif;
		font-size: 12.5px;
		font-weight: 700;
		color: var(--navy);
		text-transform: uppercase;
		letter-spacing: 0.04em;
		margin-bottom: 4px;
	}

	.heading h1, .heading-h2 {
		font-family: 'Oswald', sans-serif;
		font-weight: 700;
		font-size: 28px;
		line-height: 1.3;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin: 0;
		max-width: 740px;
		color: #000000;
	}

	.location {
		font-family: 'Roboto', sans-serif;
		color: #000000;
		font-size: 15px;
		margin-top: 8px;
	}

	.badge {
		background: #e8f5e9;
		color: #0f7f2f;
		border-radius: 20px;
		padding: 6px 14px;
		white-space: nowrap;
		font-family: 'Roboto', sans-serif;
		font-size: 12px;
		font-weight: 700;
	}

	.layout {
		display: grid;
		grid-template-columns: minmax(0, 1fr) 300px;
		gap: 16px;
		margin-top: 16px;
		align-items: start;
		position: relative;
	}

	.layout > div:first-child {
		display: flex;
		flex-direction: column;
		gap: 16px;
		min-width: 0;
	}

	.panel {
		background: var(--panel);
		border: 1px solid var(--line);
		border-radius: 8px;
		padding: 20px 24px;
	}

	.panel h2 {
		font-family: 'Oswald', sans-serif;
		font-size: 19px;
		font-weight: 700;
		line-height: 1.3;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin: 0 0 16px;
		color: var(--navy);
		padding-bottom: 8px;
		border-bottom: 2px solid var(--navy);
	}

	.specs {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 14px 20px;
	}

	.spec {
		padding: 8px 0;
		border-bottom: 1px solid var(--line);
	}

	.spec small {
		display: block;
		color: var(--navy);
		font-family: 'Roboto', sans-serif;
		font-size: 13px;
		font-weight: 700;
		text-transform: uppercase;
		margin-bottom: 4px;
		letter-spacing: 0.02em;
	}

	.spec b {
		font-family: 'Roboto', sans-serif;
		font-size: 15px;
		font-weight: 400;
		color: #000000;
		display: block;
	}

	.desc {
		font-family: 'Roboto', sans-serif;
		font-size: 15px;
		line-height: 1.65;
		color: #000000;
		margin: 0 0 14px;
	}

	.facts {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 12px;
	}

	.fact {
		background: #f0fdf4;
		border: 1px solid #dcfce7;
		padding: 14px;
		border-radius: 8px;
	}

	.fact b {
		display: block;
		font-family: 'Oswald', sans-serif;
		font-weight: 700;
		font-size: 24px;
		color: var(--navy);
		letter-spacing: 0.5px;
	}

	.fact span {
		display: block;
		font-family: 'Roboto', sans-serif;
		color: #000000;
		font-size: 13px;
		margin-top: 4px;
	}

	.chips {
		display: flex;
		gap: 8px;
		flex-wrap: wrap;
	}

	.chip {
		border: 1px solid #d1d5db;
		border-radius: 6px;
		padding: 6px 12px;
		font-family: 'Roboto', sans-serif;
		font-size: 13.5px;
		font-weight: 500;
		color: #000000;
		background: #f9fafb;
		transition: all 0.2s ease;
	}

	.chip:hover {
		background: #f0fdf4;
		border-color: var(--navy);
		color: var(--navy);
	}

	.info-list {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 14px 24px;
		margin: 0;
		padding: 0;
		list-style: none;
	}

	.info-list li {
		padding: 10px 0;
		border-bottom: 1px solid var(--line);
		font-family: 'Roboto', sans-serif;
		font-size: 15px;
		line-height: 1.6;
		color: #000000;
	}

	.info-list b {
		display: block;
		color: var(--navy);
		font-family: 'Roboto', sans-serif;
		font-weight: 700;
		font-size: 13.5px;
		text-transform: uppercase;
		margin-bottom: 4px;
		letter-spacing: 0.02em;
	}

	.faq {
		border-top: 1px solid var(--line);
	}

	.faq details {
		border-bottom: 1px solid var(--line);
		padding: 12px 0;
	}

	.faq summary {
		cursor: pointer;
		font-family: 'Roboto', sans-serif;
		font-weight: 700;
		font-size: 15px;
		color: var(--navy);
		line-height: 1.5;
	}

	.faq p {
		font-family: 'Roboto', sans-serif;
		color: #000000;
		font-size: 14.5px;
		line-height: 1.65;
		margin: 8px 0 4px;
	}

	.source-note {
		margin-top: 16px;
		padding: 12px 16px;
		background: #f0fdf4;
		border-left: 4px solid var(--navy);
		color: #000000;
		font-family: 'Roboto', sans-serif;
		font-size: 14px;
		line-height: 1.6;
		border-radius: 4px;
	}

	.source-note a {
		color: var(--navy);
		font-weight: 700;
	}

	.map {
		width: 100%;
		margin-top: 10px;
	}

	.map iframe {
		width: 100% !important;
		height: 380px !important;
		border: 0 !important;
		border-radius: 8px !important;
	}

	.sticky {
		position: -webkit-sticky;
		position: sticky;
		top: 84px;
		align-self: start;
		z-index: 90;
	}

	.price-card {
		border-top: 4px solid var(--navy);
	}

	.price-label {
		font-family: 'Roboto', sans-serif;
		font-size: 12.5px;
		font-weight: 700;
		color: #000000;
		text-transform: uppercase;
		letter-spacing: 0.04em;
	}

	.price {
		font-family: 'Oswald', sans-serif;
		font-weight: 700;
		font-size: 32px;
		line-height: 1.1;
		color: var(--navy);
		letter-spacing: 0.5px;
		margin: 6px 0 2px;
	}

	.unit {
		font-family: 'Roboto', sans-serif;
		font-size: 13.5px;
		color: #000000;
	}

	.cta {
		display: block;
		text-align: center;
		text-decoration: none;
		padding: 12px 14px;
		border-radius: 6px;
		background: var(--red);
		color: #fff;
		font-family: 'Roboto', sans-serif;
		font-size: 14.5px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin-top: 10px;
		margin-bottom: 10px;
		transition: opacity 0.2s, transform 0.15s;
	}

	.cta:hover {
		opacity: 0.9;
	}

	.cta.alt {
		background: var(--navy);
		margin-top: 10px;
		margin-bottom: 10px;
	}

	/* MỤC LỤC ĐIỀU HƯỚNG NHANH */
	.toc-panel {
		background: #f8fafc;
		border: 1px solid var(--line);
		border-left: 4px solid var(--navy);
		border-radius: 8px;
		padding: 18px 22px;
	}
	.toc-panel .toc-title {
		font-family: 'Oswald', sans-serif;
		font-size: 17px;
		font-weight: 700;
		text-transform: uppercase;
		color: var(--navy);
		letter-spacing: 0.5px;
		margin-bottom: 12px;
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.toc-grid {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 8px 16px;
	}
	.toc-item {
		font-family: 'Roboto', sans-serif;
		font-size: 13.5px;
		font-weight: 600;
		color: #000000;
		text-decoration: none;
		display: flex;
		align-items: center;
		gap: 6px;
		padding: 6px 10px;
		border-radius: 6px;
		background: #ffffff;
		border: 1px solid var(--line);
		transition: all 0.15s ease;
	}
	.toc-item:hover {
		color: var(--navy);
		border-color: var(--navy);
		background: #e8f5e9;
		transform: translateX(3px);
	}
	@media (max-width: 600px) {
		.toc-grid {
			grid-template-columns: 1fr;
		}
	}

	.agent {
		border-top: 1px solid var(--line);
		margin-top: 16px;
		padding-top: 14px;
		font-family: 'Roboto', sans-serif;
		font-size: 13.5px;
		line-height: 1.65;
		color: #000000;
	}

	.agent strong {
		display: block;
		font-size: 14.5px;
		color: #000000;
	}

	.source {
		font-family: 'Roboto', sans-serif;
		font-size: 12px;
		color: #000000;
		line-height: 1.6;
		margin-top: 14px;
	}

	.source a {
		color: var(--navy);
		font-weight: 700;
	}

	/* LIGHTBOX MODAL DÀNH CHO XEM ẢNH */
	.image-lightbox {
		position: fixed;
		inset: 0;
		z-index: 100000;
		display: none;
		align-items: center;
		justify-content: center;
		padding: 28px;
		background: rgba(10, 18, 23, 0.88);
	}

	.image-lightbox.is-open {
		display: flex;
	}

	.image-lightbox img {
		display: block;
		max-width: min(1100px, 92vw);
		max-height: 86vh;
		width: auto;
		height: auto;
		object-fit: contain;
		box-shadow: 0 18px 55px rgba(0, 0, 0, 0.35);
	}

	.image-lightbox-close {
		position: absolute;
		top: 18px;
		right: 22px;
		width: 42px;
		height: 42px;
		border: 1px solid rgba(255, 255, 255, 0.45);
		border-radius: 50%;
		background: rgba(0, 0, 0, 0.3);
		color: #fff;
		font-size: 28px;
		line-height: 1;
		cursor: pointer;
	}

	.image-lightbox-close:hover {
		background: var(--red);
		border-color: var(--red);
	}

	.image-lightbox-caption {
		position: absolute;
		left: 24px;
		bottom: 18px;
		color: #fff;
		font-family: 'Roboto', sans-serif;
		font-size: 14px;
		background: rgba(0, 0, 0, 0.6);
		padding: 6px 14px;
		border-radius: 4px;
	}

	@media(max-width:960px) {
		.gallery { height: 280px; }
		.heading { padding: 20px; flex-direction: column; }
		.heading h1, .heading-h2 { font-size: 24px; }
		.layout { grid-template-columns: minmax(0, 1fr) 280px; gap: 14px; }
		.specs { grid-template-columns: repeat(2, 1fr); }
	}

	@media(max-width:768px) {
		.wrap { width: min(100% - 24px, 1180px); }
		.gallery { grid-template-columns: 1fr; height: 250px; }
		.side { display: none; }
		.layout { grid-template-columns: 1fr; }
		.sticky { position: -webkit-sticky; position: sticky; top: 76px; z-index: 90; }
		.panel { padding: 16px; }
		.specs, .facts, .info-list { grid-template-columns: 1fr; }
	}

	/* =================================================
	   BANNER PHÒNG XÚC TIẾN ĐẦU TƯ
	================================================= */
	.invest-promo-banner {
		background: linear-gradient(135deg, #072a14 0%, #0d4621 55%, #083315 100%) !important;
		border-radius: 12px !important;
		border: 1px solid rgba(22, 192, 74, 0.45) !important;
		padding: 24px 26px !important;
		color: #ffffff !important;
		margin-bottom: 20px !important;
		box-shadow: 0 10px 30px rgba(15, 127, 47, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.12) !important;
		position: relative !important;
		overflow: hidden !important;
		display: block !important;
		box-sizing: border-box !important;
	}

	.invest-promo-banner * {
		box-sizing: border-box !important;
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
		display: flex !important;
		justify-content: space-between !important;
		align-items: center !important;
		flex-wrap: wrap !important;
		gap: 10px !important;
		padding-bottom: 14px !important;
		border-bottom: 1px solid rgba(255, 255, 255, 0.14) !important;
		margin-bottom: 18px !important;
		position: relative !important;
		z-index: 2 !important;
	}

	.ipb-badge-wrap {
		display: inline-flex !important;
		align-items: center !important;
		gap: 8px !important;
		background: rgba(22, 192, 74, 0.22) !important;
		border: 1px solid rgba(22, 192, 74, 0.45) !important;
		padding: 5px 13px !important;
		border-radius: 20px !important;
		font-family: 'Roboto', sans-serif !important;
		font-size: 12px !important;
		font-weight: 700 !important;
		color: #a7f3d0 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.04em !important;
	}

	.ipb-pulse-dot {
		width: 8px !important;
		height: 8px !important;
		background: #10b981 !important;
		border-radius: 50% !important;
		display: inline-block !important;
		box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7) !important;
		animation: ipbPulse 2s infinite !important;
	}

	@keyframes ipbPulse {
		0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
		70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
		100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
	}

	.ipb-live-text {
		font-family: 'Roboto', sans-serif !important;
		font-size: 12.5px !important;
		color: #ffd166 !important;
		font-weight: 600 !important;
		letter-spacing: 0.02em !important;
	}

	.ipb-content-grid {
		display: grid !important;
		grid-template-columns: 1.35fr 1fr !important;
		gap: 24px !important;
		align-items: center !important;
		position: relative !important;
		z-index: 2 !important;
	}

	.ipb-main-info h3 {
		font-family: 'Oswald', sans-serif !important;
		font-size: 23px !important;
		font-weight: 700 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.5px !important;
		line-height: 1.3 !important;
		margin: 0 0 8px !important;
		color: #ffffff !important;
	}

	.ipb-main-info h3 span {
		color: #4ade80 !important;
	}

	.ipb-intro-desc {
		font-family: 'Roboto', sans-serif !important;
		font-size: 13.5px !important;
		line-height: 1.6 !important;
		color: #e2e8f0 !important;
		margin: 0 0 16px !important;
	}

	.ipb-feature-list {
		display: flex !important;
		flex-direction: column !important;
		gap: 10px !important;
	}

	.ipb-feature-item {
		display: flex !important;
		align-items: flex-start !important;
		gap: 10px !important;
		font-size: 13px !important;
		line-height: 1.5 !important;
		color: #f1f5f9 !important;
	}

	.ipb-feature-icon {
		width: 26px !important;
		height: 26px !important;
		background: rgba(255, 255, 255, 0.12) !important;
		border-radius: 6px !important;
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		font-size: 13px !important;
		flex-shrink: 0 !important;
		margin-top: 1px !important;
	}

	.ipb-feature-item strong {
		color: #ffffff !important;
		font-weight: 700 !important;
	}

	.ipb-feature-item span {
		color: #cbd5e1 !important;
	}

	.ipb-action-card {
		background: rgba(0, 0, 0, 0.38) !important;
		border: 1px solid rgba(255, 255, 255, 0.16) !important;
		border-radius: 10px !important;
		padding: 20px 20px !important;
		text-align: center !important;
		backdrop-filter: blur(4px) !important;
	}

	.ipb-action-card-tag {
		font-family: 'Roboto', sans-serif !important;
		font-size: 11.5px !important;
		font-weight: 700 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.06em !important;
		color: #cbd5e1 !important;
		margin-bottom: 4px !important;
	}

	.ipb-phone-highlight {
		font-family: 'Oswald', sans-serif !important;
		font-size: 28px !important;
		font-weight: 700 !important;
		color: #ffffff !important;
		letter-spacing: 1px !important;
		margin-bottom: 4px !important;
		display: block !important;
		text-decoration: none !important;
		text-shadow: 0 2px 8px rgba(0,0,0,0.3) !important;
		transition: color 0.2s, transform 0.2s !important;
	}

	.ipb-phone-highlight:hover {
		color: #ffd166 !important;
		transform: scale(1.03) !important;
	}

	.ipb-phone-desc {
		font-size: 12px !important;
		color: #94a3b8 !important;
		margin-bottom: 14px !important;
	}

	.ipb-buttons {
		display: flex !important;
		flex-direction: column !important;
		gap: 9px !important;
	}

	.ipb-btn-hotline {
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		gap: 8px !important;
		background: var(--red) !important;
		color: #ffffff !important;
		font-family: 'Roboto', sans-serif !important;
		font-size: 14px !important;
		font-weight: 700 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.5px !important;
		padding: 11px 16px !important;
		border-radius: 6px !important;
		text-decoration: none !important;
		transition: background 0.2s, transform 0.15s, box-shadow 0.2s !important;
		box-shadow: 0 4px 14px rgba(255, 127, 42, 0.35) !important;
	}

	.ipb-btn-hotline:hover {
		background: #e66a1a !important;
		transform: translateY(-1px) !important;
		box-shadow: 0 6px 18px rgba(255, 127, 42, 0.45) !important;
		color: #ffffff !important;
	}

	.ipb-btn-zalo {
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		gap: 8px !important;
		background: #0284c7 !important;
		color: #ffffff !important;
		font-family: 'Roboto', sans-serif !important;
		font-size: 14px !important;
		font-weight: 700 !important;
		padding: 10px 16px !important;
		border-radius: 6px !important;
		text-decoration: none !important;
		transition: background 0.2s, transform 0.15s !important;
	}

	.ipb-btn-zalo:hover {
		background: #0369a1 !important;
		transform: translateY(-1px) !important;
		color: #ffffff !important;
	}

	.ipb-footer-note {
		margin-top: 12px !important;
		font-size: 11.5px !important;
		color: #94a3b8 !important;
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		gap: 5px !important;
	}

	@media (max-width: 768px) {
		.ipb-content-grid {
			grid-template-columns: 1fr !important;
			gap: 18px !important;
		}
		.invest-promo-banner {
			padding: 20px 16px !important;
		}
		.ipb-main-info h3 {
			font-size: 19px !important;
		}
		.ipb-phone-highlight {
			font-size: 24px !important;
		}
	}
</style>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
		// Xác định Chuyên mục (Kho xưởng / Đất công nghiệp / Khu công nghiệp)
		$categories = get_the_category();
		$cat_slug = 'kcn';
		$cat_name = 'Khu công nghiệp';
		$cat_url = home_url('/kcn/');
		$eyebrow_prefix = 'Khu công nghiệp';

		if ( !empty($categories) ) {
			foreach ($categories as $cat) {
				if ($cat->slug === 'kho-xuong') {
					$cat_slug = 'kho-xuong';
					$cat_name = 'Kho xưởng';
					$cat_url = home_url('/kho-xuong/');
					$eyebrow_prefix = 'Kho xưởng';
					break;
				} elseif ($cat->slug === 'dat-cong-nghiep') {
					$cat_slug = 'dat-cong-nghiep';
					$cat_name = 'Đất công nghiệp';
					$cat_url = home_url('/dat-cong-nghiep/');
					$eyebrow_prefix = 'Đất công nghiệp';
					break;
				}
			}
		}

		// Lấy dữ liệu ACF Free hoặc Fallback dữ liệu mặc định chuẩn detail.html
		$tinh_thanh = get_field('tinh_thanh') ? get_field('tinh_thanh') : 'Long An';
		$vi_tri = get_field('vi_tri') ? get_field('vi_tri') : 'Đang cập nhật vị trí';
		$trang_thai = get_field('trang_thai') ? get_field('trang_thai') : 'ĐANG HOẠT ĐỘNG';
		$gia_thue = get_field('gia_thue') ? get_field('gia_thue') : '$142 – $163/m²';
		$don_vi_tinh = get_field('don_vi_tinh') ? get_field('don_vi_tinh') : 'Đất và hạ tầng · chu kỳ thuê';
		$chu_dau_tu = get_field('chu_dau_tu') ? get_field('chu_dau_tu') : '';
		$mo_ta_thue = get_field('mo_ta_hinh_thuc_thue') ? get_field('mo_ta_hinh_thuc_thue') : 'Hình thức thuê gồm đất trống, nhà xưởng xây sẵn hoặc nhà xưởng thiết kế theo yêu cầu.';
		
		// Facts
		$fact_cang = get_field('fact_cang_bien') ? get_field('fact_cang_bien') : '19 km đến cảng gần nhất';
		$fact_nuoc_thai = get_field('fact_nuoc_thai') ? get_field('fact_nuoc_thai') : '3.000 m³/ngày';

		// Thông số hạ tầng
		$ht_dien = get_field('ht_dien') ? get_field('ht_dien') : '110/22KV · công suất 63MW';
		$ht_nuoc_sach = get_field('ht_nuoc_sach') ? get_field('ht_nuoc_sach') : '5.000 m³/ngày · ống 110–315mm';
		$ht_nuoc_thai = get_field('ht_nuoc_thai') ? get_field('ht_nuoc_thai') : '3.000 m³/ngày · xử lý đạt cột A';
		$ht_vien_thong = get_field('ht_vien_thong') ? get_field('ht_vien_thong') : 'Kết nối mạng viễn thông';
		$ht_duong_bo = get_field('ht_duong_bo') ? get_field('ht_duong_bo') : 'Xe container 24/7';
		$ht_duong_thuy = get_field('ht_duong_thuy') ? get_field('ht_duong_thuy') : 'Quy hoạch đường thủy';

		// Chi phí vận hành
		$phi_quan_ly = get_field('phi_quan_ly') ? get_field('phi_quan_ly') : '0,035 USD/m²/tháng';
		$gia_dien = get_field('gia_dien') ? get_field('gia_dien') : 'Bình thường 1.453đ/kWh · thấp điểm 934đ/kWh · cao điểm 2.637đ/kWh';
		$gia_nuoc = get_field('gia_nuoc') ? get_field('gia_nuoc') : 'Khoảng 3.200đ/m³';
		$phi_xuly_nuocthai = get_field('phi_xuly_nuocthai') ? get_field('phi_xuly_nuocthai') : '0,35 USD/m³, tính 80% nước đầu vào';
		$uu_dai_thue = get_field('uu_dai_thue') ? get_field('uu_dai_thue') : 'Doanh nghiệp có thể được miễn thuế thu nhập doanh nghiệp trong 2 năm đầu và giảm 50% trong 4 năm tiếp theo.';

		// Ảnh đại diện & Ảnh quy hoạch, hạ tầng
		$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
		if (!$thumb_url) {
			$thumb_url = 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg';
		}
		
		$anh_qh = get_field('anh_quy_hoach');
		$anh_qh_url = is_array($anh_qh) ? $anh_qh['url'] : ($anh_qh ? $anh_qh : $thumb_url);

		$anh_ht = get_field('anh_ha_tang');
		$anh_ht_url = is_array($anh_ht) ? $anh_ht['url'] : ($anh_ht ? $anh_ht : $thumb_url);

		// Liên hệ
		$hotline = get_field('hotline');
		if (!$hotline || strpos($hotline, '0901') !== false || strpos($hotline, '626248') !== false) {
			$hotline = '0909 161 824';
		}
		$zalo = get_field('link_zalo');
		if (!$zalo || strpos($zalo, '0901') !== false || strpos($zalo, '626248') !== false) {
			$zalo = 'https://zalo.me/0909161824';
		}
		$file_brochure = get_field('file_brochure');
	?>

	<main class="wrap detail-shell">
		<nav class="crumb" aria-label="Breadcrumb">
			<a href="<?php echo home_url(); ?>">Trang chủ</a> / 
			<a href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></a> / 
			<span><?php the_title(); ?></span>
		</nav>

		<article class="detail-view">
			<!-- HERO BANNER VỚI ẢNH ĐẠI DIỆN + ẢNH QUY HOẠCH + ẢNH HẠ TẦNG -->
			<div class="hero">
				<div class="gallery">
					<div class="cover" role="img" aria-label="Ảnh toàn cảnh <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($thumb_url); ?>')">
						<span class="photo-label">Ảnh dự án · <?php the_title(); ?></span>
					</div>
					<div class="side">
						<div role="img" aria-label="Bản đồ quy hoạch <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($anh_qh_url); ?>')">
							<span class="photo-label">Quy hoạch</span>
						</div>
						<div role="img" aria-label="Hạ tầng <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($anh_ht_url); ?>')">
							<span class="photo-label">Hạ tầng</span>
						</div>
					</div>
				</div>
				<div class="heading">
					<div>
						<div class="eyebrow"><?php echo esc_html($eyebrow_prefix); ?> · <?php echo esc_html($tinh_thanh); ?></div>
						<h1 class="heading-h2"><?php the_title(); ?></h1>
						<div class="location"><?php echo esc_html($vi_tri); ?></div>
					</div>
					<span class="badge">● <?php echo esc_html($trang_thai); ?></span>
				</div>
			</div>

		<!-- BỐ CỤC NỘI DUNG CHÍNH (CHUẨN DETAIL.HTML) -->
		<div class="layout">
			<div>
				<!-- MỤC LỤC ĐIỀU HƯỚNG NHANH -->
				<section class="panel toc-panel">
					<div class="toc-title">📑 Mục lục hồ sơ dự án</div>
					<div class="toc-grid">
						<a href="#sec-tong-quan" class="toc-item">1. Tổng quan đầu tư</a>
						<a href="#sec-thong-so" class="toc-item">2. Thông số dự án &amp; Hạ tầng</a>
						<a href="#sec-logistics" class="toc-item">3. Kết nối logistics</a>
						<?php if ( get_field('nganh_nghe_thu_hut') ) : ?><a href="#sec-nganh-nghe" class="toc-item">4. Ngành nghề thu hút</a><?php endif; ?>
						<a href="#sec-chi-phi" class="toc-item">5. Chi phí vận hành tham khảo</a>
						<a href="#sec-uu-dai" class="toc-item">6. Ưu đãi &amp; Chính sách đầu tư</a>
						<a href="#sec-quy-trinh" class="toc-item">7. Quy trình xúc tiến đầu tư</a>
						<?php if ( get_field('google_map_embed') ) : ?><a href="#sec-vi-tri" class="toc-item">8. Vị trí &amp; Bản đồ</a><?php endif; ?>
					</div>
				</section>

				<!-- 1. TỔNG QUAN ĐẦU TƯ -->
				<section class="panel" id="sec-tong-quan">
					<h2>Tổng quan đầu tư</h2>
					<div class="facts">
						<div class="fact"><b><?php echo esc_html($gia_thue); ?></b><span>Giá thuê đất & hạ tầng/m²</span></div>
						<div class="fact"><b><?php echo esc_html($fact_cang); ?></b><span>Kết nối vận tải</span></div>
						<div class="fact"><b><?php echo esc_html($fact_nuoc_thai); ?></b><span>Công suất nước thải</span></div>
					</div>
					<?php if($chu_dau_tu || $mo_ta_thue): ?>
					<div class="source-note">
						<?php if($chu_dau_tu): ?>Chủ đầu tư: <strong><?php echo esc_html($chu_dau_tu); ?></strong>. <?php endif; ?>
						<?php echo esc_html($mo_ta_thue); ?>
					</div>
					<?php endif; ?>
				</section>

				<!-- 2. THÔNG SỐ DỰ ÁN / KỸ THUẬT -->
				<section class="panel" id="sec-thong-so">
					<h2>Thông số dự án</h2>
					<div class="specs">
						<div class="spec"><small>Điện</small><b><?php echo esc_html($ht_dien); ?></b></div>
						<div class="spec"><small>Nước sạch</small><b><?php echo esc_html($ht_nuoc_sach); ?></b></div>
						<div class="spec"><small>Nước thải</small><b><?php echo esc_html($ht_nuoc_thai); ?></b></div>
						<div class="spec"><small>Viễn thông</small><b><?php echo esc_html($ht_vien_thong); ?></b></div>
						<div class="spec"><small>Đường bộ</small><b><?php echo esc_html($ht_duong_bo); ?></b></div>
						<div class="spec"><small>Đường thủy</small><b><?php echo esc_html($ht_duong_thuy); ?></b></div>
					</div>
				</section>

				<!-- 3. KẾT NỐI LOGISTICS (CHUẨN THEO GIAO DIỆN HÌNH ẢNH) -->
				<section class="panel" id="sec-logistics">
					<h2>Kết nối logistics</h2>
					<ul class="info-list">
						<?php
						$logistics_1_title = get_field('ten_logistics_1') ? get_field('ten_logistics_1') : 'Cảng quốc tế Long An';
						$logistics_1_desc  = get_field('logistics_cang_longan') ? get_field('logistics_cang_longan') : 'Khoảng 19km, thuận lợi xuất nhập hàng đường thủy.';

						$logistics_2_title = get_field('ten_logistics_2') ? get_field('ten_logistics_2') : 'Cảng Hiệp Phước';
						$logistics_2_desc  = get_field('logistics_cang_hiepphuoc') ? get_field('logistics_cang_hiepphuoc') : 'Khoảng 30km, kết nối trực tiếp khu vực TP.HCM.';

						$logistics_3_title = get_field('ten_logistics_3') ? get_field('ten_logistics_3') : 'Sân bay Tân Sơn Nhất';
						$logistics_3_desc  = get_field('logistics_san_bay') ? get_field('logistics_san_bay') : 'Khoảng 42km, phù hợp vận chuyển chuyên gia và hàng hóa.';

						$logistics_4_title = get_field('ten_logistics_4') ? get_field('ten_logistics_4') : 'Trục giao thông';
						$logistics_4_desc  = get_field('logistics_truc_giao_thong') ? get_field('logistics_truc_giao_thong') : 'Tiếp cận tỉnh lộ 826B và mạng lưới vận tải đường bộ phía Nam.';
						?>
						<li><b><?php echo esc_html($logistics_1_title); ?></b><?php echo esc_html($logistics_1_desc); ?></li>
						<li><b><?php echo esc_html($logistics_2_title); ?></b><?php echo esc_html($logistics_2_desc); ?></li>
						<li><b><?php echo esc_html($logistics_3_title); ?></b><?php echo esc_html($logistics_3_desc); ?></li>
						<li><b><?php echo esc_html($logistics_4_title); ?></b><?php echo esc_html($logistics_4_desc); ?></li>
					</ul>
				</section>

				<!-- 4. NGÀNH NỀỀ THU HÚT -->
				<?php if ( get_field('nganh_nghe_thu_hut') ) : ?>
				<section class="panel" id="sec-nganh-nghe">
					<h2>Ngành nghề thu hút</h2>
					<div class="chips">
						<?php 
						$nganh_nghe_arr = explode(',', get_field('nganh_nghe_thu_hut'));
						foreach($nganh_nghe_arr as $nganh) : ?>
							<span class="chip"><?php echo esc_html(trim($nganh)); ?></span>
						<?php endforeach; ?>
					</div>
				</section>
				<?php endif; ?>

				<!-- 5. CHI PHÍ VẬN HÀNH THAM KHẢO -->
				<section class="panel" id="sec-chi-phi">
					<h2>Chi phí vận hành tham khảo</h2>
					<ul class="info-list">
						<li><b>Phí quản lý</b><?php echo esc_html($phi_quan_ly); ?></li>
						<li><b>Giá điện EVN</b><?php echo esc_html($gia_dien); ?></li>
						<li><b>Giá nước</b><?php echo esc_html($gia_nuoc); ?></li>
						<li><b>Xử lý nước thải</b><?php echo esc_html($phi_xuly_nuocthai); ?></li>
					</ul>
				</section>

				<!-- 6. ƯU ĐÃI & CHÍNH SÁCH ĐẦU TƯ -->
				<section class="panel" id="sec-uu-dai">
					<h2>Ưu đãi & chính sách đầu tư</h2>
					<p class="desc"><?php echo esc_html($uu_dai_thue); ?></p>
					<div class="chips">
						<span class="chip">Miễn thuế 2 năm đầu</span>
						<span class="chip">Giảm 50% trong 4 năm</span>
						<span class="chip">Hỗ trợ IRC / ERC</span>
						<span class="chip">Kết nối trực tiếp chủ đầu tư</span>
					</div>
				</section>

				<!-- 7. QUY TRÌNH XÚC TIẾN ĐẦU TƯ -->
				<section class="panel" id="sec-quy-trinh">
					<h2>Quy trình xúc tiến đầu tư</h2>
					<ul class="info-list">
						<li><b>01 · Chọn mặt bằng</b>Nhận thông tin lô đất, nhà xưởng và loại hình thuê.</li>
						<li><b>02 · Kiểm tra hồ sơ</b>Rà soát pháp lý, ngành nghề, hạ tầng và chi phí.</li>
						<li><b>03 · Khảo sát thực địa</b>Kiểm tra vị trí, cốt nền, đường container và hạ tầng kỹ thuật.</li>
						<li><b>04 · Đàm phán & ký kết</b>Hỗ trợ làm việc với chủ đầu tư và triển khai hồ sơ.</li>
					</ul>
				</section>

				<!-- 8. MÔ TẢ NỘI DUNG TỪ EDITOR (NẾU CÓ) -->
				<?php if ( get_the_content() ) : ?>
				<section class="panel" id="sec-bo-sung">
					<h2>Chi tiết bổ sung</h2>
					<div class="desc">
						<?php the_content(); ?>
					</div>
				</section>
				<?php endif; ?>

				<!-- BANNER PHÒNG XÚC TIẾN ĐẦU TƯ -->
				<section class="invest-promo-banner">
					<div class="ipb-top">
						<div class="ipb-badge-wrap">
							<span class="ipb-pulse-dot"></span>
							<span>Ban Xúc Tiến Đầu Tư &amp; Quản Lý Dự Án</span>
						</div>
						<div class="ipb-live-text">⚡ Tiếp nhận hồ sơ &amp; phản hồi trong 15 phút</div>
					</div>
					<div class="ipb-content-grid">
						<div class="ipb-main-info">
							<h3>Liên hệ <span>Phòng Xúc Tiến Đầu Tư</span> KCN</h3>
							<p class="ipb-intro-desc">Đầu mối chính thức tiếp nhận nhu cầu thuê đất, nhà xưởng xây sẵn và hỗ trợ trọn gói thủ tục pháp lý đầu tư, hưởng đầy đủ chính sách ưu đãi trực tiếp từ Chủ đầu tư.</p>
							<div class="ipb-feature-list">
								<div class="ipb-feature-item">
									<div class="ipb-feature-icon">🏢</div>
									<div><strong>Quỹ đất &amp; xưởng trực tiếp:</strong> <span>Cung cấp diện tích chuẩn theo ngành nghề, nguồn gốc sạch, giá gốc CĐT.</span></div>
								</div>
								<div class="ipb-feature-item">
									<div class="ipb-feature-icon">📑</div>
									<div><strong>Thủ tục pháp lý trọn gói:</strong> <span>Hỗ trợ cấp phép IRC, ERC, ĐTM, thẩm duyệt PCCC &amp; GPXD miễn phí.</span></div>
								</div>
								<div class="ipb-feature-item">
									<div class="ipb-feature-icon">🚗</div>
									<div><strong>Khảo sát thực địa 0đ:</strong> <span>Xe đưa đón tận nơi, kiểm tra hạ tầng kỹ thuật và kết nối logistics 24/7.</span></div>
								</div>
							</div>
						</div>
						<div class="ipb-action-card">
							<div class="ipb-action-card-tag">Hotline Phòng Xúc Tiến</div>
							<a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>" class="ipb-phone-highlight"><?php echo esc_html($hotline); ?></a>
							<div class="ipb-phone-desc">Chuyên viên tư vấn hồ sơ &amp; bảng giá 24/7</div>
							<div class="ipb-buttons">
								<a class="ipb-btn-hotline" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>">
									<span>📞</span>
									<span>Gọi Hotline Ngay</span>
								</a>
								<a class="ipb-btn-zalo" href="<?php echo esc_url($zalo); ?>" target="_blank" rel="noopener">
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

				<!-- 9. VỊ TRÍ & BẢN ĐỒ -->
				<?php if ( get_field('google_map_embed') ) : ?>
				<section class="panel" id="sec-vi-tri">
					<h2>Vị trí & bản đồ</h2>
					<div class="map">
						<?php echo get_field('google_map_embed'); ?>
					</div>
				</section>
				<?php endif; ?>
			</div>

			<!-- CỘT PHẢI CỐ ĐỊNH SIDEBAR -->
			<aside class="sticky">
				<section class="panel price-card">
					<div class="price-label">Giá tham khảo</div>
					<div class="price"><?php echo esc_html($gia_thue); ?></div>
					<div class="unit"><?php echo esc_html($don_vi_tinh); ?></div>
					
					<a class="cta" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>">📞 Nhận tư vấn &amp; khảo sát</a>
					<a class="cta alt" href="<?php echo esc_url($zalo); ?>" target="_blank" rel="noopener">💬 Chat Zalo tư vấn</a>
					<a class="cta alt" style="background:#1877f2;color:#ffffff;border:none;display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:0;" href="https://www.facebook.com/share/18skMpo77a/?mibextid=wwXIfr" target="_blank" rel="noopener"><svg width="15" height="15" viewBox="0 0 24 24" fill="#ffffff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook Fanpage</a>
					
					<?php if ( $file_brochure ) : ?>
						<a class="cta alt" style="background:#27ae60;" href="<?php echo esc_url(is_array($file_brochure) ? $file_brochure['url'] : $file_brochure); ?>" target="_blank" download>📄 Tải Brochure PDF</a>
					<?php endif; ?>

					<div class="agent">
						<strong>Chuyên viên BDS24H</strong>
						Hotline / Zalo: <?php echo esc_html($hotline); ?><br>
						Hỗ trợ hồ sơ pháp lý và kết nối chủ đầu tư
					</div>
				</section>
				<section class="panel source">Thông tin tham khảo từ <a href="https://khoxuongdep.com.vn/" target="_blank" rel="noopener">Khoxuongdep.com.vn</a>.</section>
			</aside>
		</div>
	</article>

	<?php endwhile; endif; ?>
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
		var preview = lightbox.querySelector('img');
		var caption = lightbox.querySelector('.image-lightbox-caption');
		var closeButton = lightbox.querySelector('.image-lightbox-close');
		var lastTrigger;

		function getImageUrl(element) {
			var match = (element.style.backgroundImage || '').match(/url\(["']?(.*?)["']?\)/);
			return match ? match[1] : '';
		}

		function closeLightbox() {
			lightbox.classList.remove('is-open');
			preview.removeAttribute('src');
			if (lastTrigger) lastTrigger.focus();
		}

		document.querySelectorAll('.gallery .cover, .gallery .side div').forEach(function (image) {
			image.setAttribute('tabindex', '0');
			image.setAttribute('role', 'button');
			image.setAttribute('aria-label', 'Mở ảnh phóng to');
			image.addEventListener('click', function () {
				var url = getImageUrl(image);
				if (!url) return;
				lastTrigger = image;
				preview.src = url;
				preview.alt = image.querySelector('.photo-label') ? image.querySelector('.photo-label').textContent : 'Ảnh dự án';
				caption.textContent = preview.alt;
				lightbox.classList.add('is-open');
				closeButton.focus();
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
	}());

	// SCRIPT DÍNH SIDEBAR STICKY DỘNG
	(function () {
		function updateStickyPositions() {
			var screenWidth = window.innerWidth || document.documentElement.clientWidth;
			var visibleArticle = document.querySelector('.detail-view');
			if (!visibleArticle) return;

			var layout = visibleArticle.querySelector('.layout');
			var sticky = visibleArticle.querySelector('.sticky');
			if (!layout || !sticky) return;

			if (screenWidth <= 900) {
				sticky.style.position = '';
				sticky.style.top = '';
				sticky.style.left = '';
				sticky.style.width = '';
				sticky.style.zIndex = '';
				return;
			}

			var layoutRect = layout.getBoundingClientRect();
			var stickyHeight = sticky.offsetHeight;
			var adminBar = document.getElementById('wpadminbar');
			var adminBarHeight = (adminBar && window.getComputedStyle(adminBar).position === 'fixed') ? adminBar.offsetHeight : 0;
			var headerOffset = 84 + adminBarHeight;

			var layoutTop = layoutRect.top;
			var layoutBottom = layoutRect.bottom;

			if (layoutTop <= headerOffset && layoutBottom >= (headerOffset + stickyHeight)) {
				sticky.style.position = 'fixed';
				sticky.style.top = headerOffset + 'px';
				sticky.style.left = (layoutRect.right - 300) + 'px';
				sticky.style.width = '300px';
				sticky.style.zIndex = '90';
			} else if (layoutBottom < (headerOffset + stickyHeight)) {
				sticky.style.position = 'absolute';
				sticky.style.top = 'auto';
				sticky.style.bottom = '0px';
				sticky.style.left = 'auto';
				sticky.style.right = '0px';
				sticky.style.width = '300px';
			} else {
				sticky.style.position = 'static';
				sticky.style.top = '';
				sticky.style.left = '';
				sticky.style.width = '';
			}
		}

		window.addEventListener('scroll', updateStickyPositions, { passive: true });
		window.addEventListener('resize', updateStickyPositions, { passive: true });
		document.addEventListener('DOMContentLoaded', updateStickyPositions);
		setTimeout(updateStickyPositions, 100);
		updateStickyPositions();
	}());
</script>

<?php get_footer(); ?>
