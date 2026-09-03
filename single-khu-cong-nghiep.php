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

		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			background: var(--paper);
			color: #000000;
			font-family: 'Roboto', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			font-size: 15px;
			line-height: 1.6;
			-webkit-font-smoothing: antialiased;
		}

		a {
			color: inherit;
		}

		.wrap {
			width: min(1180px, calc(100% - 40px));
			margin: auto;
		}

		.top {
			background: #fff;
			border-bottom: 1px solid var(--line);
			position: sticky;
			top: 0;
			z-index: 100;
		}

		.topbar {
			height: 58px;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.logo {
			font-family: 'Oswald', sans-serif;
			font-weight: 700;
			font-size: 26px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			text-decoration: none;
			color: var(--ink);
		}

		.logo span {
			color: var(--red);
		}

		.back {
			font-family: 'Roboto', sans-serif;
			font-size: 13.5px;
			font-weight: 500;
			color: var(--navy);
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 6px;
			transition: opacity 0.2s;
		}

		.back:hover {
			opacity: 0.8;
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
		}

		.detail-shell {
			padding-bottom: 48px;
		}

		.detail-view {
			display: none;
		}

		.detail-view:target {
			display: block;
		}

		.detail-empty {
			display: block;
			background: var(--navy);
			color: #fff;
			padding: 42px 36px;
			border-radius: 12px;
		}

		.detail-shell:has(.detail-view:target) .detail-empty {
			display: none;
		}

		.detail-empty h1 {
			font-family: 'Oswald', sans-serif;
			font-weight: 700;
			font-size: 32px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			line-height: 1.25;
			max-width: 620px;
			margin: 0 0 12px;
		}

		.detail-empty p {
			max-width: 620px;
			color: #e5e7eb;
			font-family: 'Roboto', sans-serif;
			font-size: 15px;
			line-height: 1.65;
			margin: 0;
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
			height: 250px;
			border: 0;
			border-radius: 8px;
			margin-top: 10px;
		}

		.sticky {
			position: -webkit-sticky;
			position: sticky;
			top: 72px;
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

		@media(max-width:960px) {
			.gallery {
				height: 280px;
			}

			.heading {
				padding: 20px;
				flex-direction: column;
			}

			.heading h1 {
				font-size: 24px;
			}

			.layout {
				grid-template-columns: minmax(0, 1fr) 280px;
				gap: 14px;
			}

			.specs {
				grid-template-columns: repeat(2, 1fr);
			}
		}

		@media(max-width:768px) {
			.wrap {
				width: min(100% - 24px, 1180px);
			}

			.gallery {
				grid-template-columns: 1fr;
				height: 250px;
			}

			.side {
				display: none;
			}

			.layout {
				grid-template-columns: 1fr;
			}

			.sticky {
				position: -webkit-sticky;
				position: sticky;
				top: 68px;
				z-index: 90;
			}

			.panel {
				padding: 16px;
			}

			.specs,
			.facts,
			.info-list {
				grid-template-columns: 1fr;
			}

			.detail-empty {
				padding: 32px 24px;
			}

			.detail-empty h1 {
				font-size: 26px;
			}
		}

		.gallery .cover,
		.gallery .side div {
			cursor: zoom-in;
		}

		.gallery .cover:focus-visible,
		.gallery .side div:focus-visible {
			outline: 3px solid var(--navy);
			outline-offset: -3px;
		}

		.image-lightbox {
			position: fixed;
			inset: 0;
			z-index: 1000;
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
			background: var(--red);
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

// Lấy dữ liệu — hỗ trợ cả ACF lẫn post_meta được crawl mới
$post_id = get_the_ID();
$khu_vuc = get_post_meta($post_id, 'khu_vuc', true) ?: get_field('khu_vuc') ?: get_field('vi_tri') ?: get_post_meta($post_id, 'vi_tri', true) ?: 'Đang cập nhật';
$vi_tri = $khu_vuc;
$trang_thai = get_post_meta($post_id, 'trang_thai', true) ?: get_field('trang_thai') ?: 'ĐANG HOẠT ĐỘNG';
$gia_thue = get_post_meta($post_id, 'gia_thue', true) ?: get_post_meta($post_id, 'gia', true) ?: get_field('gia_thue') ?: get_field('gia') ?: 'Liên hệ báo giá';
if (strpos($gia_thue, 'tầng') !== false) $gia_thue = 'Liên hệ báo giá';
$don_vi_tinh = 'Giá tham khảo';
$chu_dau_tu = get_post_meta($post_id, 'chu_dau_tu', true) ?: get_field('chu_dau_tu') ?: '';
$dien_tich = get_post_meta($post_id, 'dien_tich', true) ?: get_field('dien_tich') ?: '';
$ty_le_lap_day = get_post_meta($post_id, 'ty_le_lap_day', true) ?: get_field('ty_le_lap_day') ?: '';
$nganh_nghe_text = get_post_meta($post_id, 'nganh_nghe', true) ?: get_post_meta($post_id, 'nganh_nghe_thu_hut', true) ?: get_field('nganh_nghe') ?: get_field('tien_ich') ?: '';
$ha_tang_text = get_post_meta($post_id, 'ha_tang', true) ?: get_field('ha_tang') ?: '';
$mo_ta_chi_tiet_kcn = get_post_meta($post_id, 'mo_ta_chi_tiet', true) ?: get_field('mo_ta_chi_tiet') ?: '';

// Ảnh đại diện
$thumb_url = get_the_post_thumbnail_url($post_id, 'full');
if (!$thumb_url) {
	$thumb_url = 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg';
}

// Gallery ảnh (hỗ trợ cả Native WordPress Gallery Metabox _kcn_gallery_ids lẫn ACF field gallery_anh)
$gallery_images = array();
$raw_gallery_ids = get_post_meta($post_id, '_kcn_gallery_ids', true);
if ($raw_gallery_ids) {
	$ids = array_filter(array_map('intval', explode(',', (string)$raw_gallery_ids)));
	foreach ($ids as $img_id) {
		$img_url = wp_get_attachment_image_url($img_id, 'full');
		if ($img_url) $gallery_images[] = $img_url;
	}
}
if (empty($gallery_images)) {
	$acf_gallery = get_field('gallery_anh');
	if (is_array($acf_gallery)) {
		foreach ($acf_gallery as $g) {
			$g_url = is_array($g) ? ($g['url'] ?? '') : $g;
			if ($g_url) $gallery_images[] = $g_url;
		}
	}
}

// Liên hệ (thông tin công ty cố định, không phụ thuộc dữ liệu crawl)
$hotline = get_field('hotline');
if (!$hotline || strpos($hotline, '0901') !== false || strpos($hotline, '626248') !== false) {
$hotline = '0909 161 824';
}
$zalo = get_field('link_zalo');
if (!$zalo || strpos($zalo, '0901') !== false || strpos($zalo, '626248') !== false) {
$zalo = 'https://zalo.me/0909161824';
}
$file_brochure = null; // chưa có nguồn dữ liệu, luôn ẩn khối tải brochure
?>

<main class="wrap detail-shell">
<nav class="crumb" aria-label="Breadcrumb">
<a href="<?php echo home_url(); ?>">Trang chủ</a> / 
<a href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></a> / 
<span><?php the_title(); ?></span>
</nav>

<article class="detail-view">
<!-- HERO BANNER VỚI ẢNH ĐẠI DIỆN + DẢI THUMBNAIL (không còn tách quy hoạch/hạ
tầng riêng — crawler không phân loại được ảnh nào thuộc loại nào) -->
<div class="hero">
<div class="gallery<?php echo !empty($gallery_images) ? ' has-side' : ' no-side'; ?>">
<div class="cover" role="img" aria-label="Ảnh toàn cảnh <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($thumb_url); ?>')">
<span class="photo-label">Ảnh dự án · <?php the_title(); ?></span>
</div>
<?php if (!empty($gallery_images)): ?>
<div class="side">
<?php
$side_images = array_slice($gallery_images, 0, 2);
foreach ($side_images as $img):
$img_url = is_array($img) ? ($img['sizes']['medium'] ?? $img['url']) : $img;
?>
<div role="img" aria-label="Ảnh thêm <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($img_url); ?>')"></div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
<?php if (count($gallery_images) > 2): ?>
<div class="kxd-gallery-thumbs" style="display:flex; gap:8px; padding:10px; flex-wrap:wrap;">
<?php foreach ($gallery_images as $img):
$img_url = is_array($img) ? $img['url'] : $img;
$img_thumb = is_array($img) ? ($img['sizes']['medium'] ?? $img['url']) : $img;
?>
<img src="<?php echo esc_url($img_thumb); ?>" alt="<?php the_title(); ?>"
style="width:110px; height:80px; object-fit:cover; border-radius:6px; cursor:pointer;"
onclick="document.querySelector('.gallery .cover').style.backgroundImage='url(<?php echo esc_url($img_url); ?>)';">
<?php endforeach; ?>
</div>
<?php endif; ?>
<div class="heading">
<div>
<div class="eyebrow"><?php echo esc_html($eyebrow_prefix); ?> · <?php echo esc_html($khu_vuc); ?></div>
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
<?php if ($ha_tang_text): ?><a href="#sec-thong-so" class="toc-item">2. Hạ tầng</a><?php endif; ?>
<?php if ($nganh_nghe_text): ?><a href="#sec-nganh-nghe" class="toc-item">3. Ngành nghề thu hút</a><?php endif; ?>
<a href="#sec-uu-dai" class="toc-item">4. Hỗ trợ đầu tư</a>
<a href="#sec-quy-trinh" class="toc-item">5. Quy trình xúc tiến đầu tư</a>
<?php if ($mo_ta_chi_tiet_kcn || get_the_content()): ?><a href="#sec-bo-sung" class="toc-item">6. Mô tả chi tiết</a><?php endif; ?>
</div>
</section>

<!-- 1. TỔNG QUAN ĐẦU TƯ -->
<section class="panel" id="sec-tong-quan">
<h2>Tổng quan đầu tư</h2>
<div class="facts">
<div class="fact"><b><?php echo esc_html($gia_thue); ?></b><span>Giá thuê</span></div>
<?php if ($dien_tich): ?>
<div class="fact"><b><?php echo esc_html($dien_tich); ?></b><span>Diện tích</span></div>
<?php endif; ?>
<?php if ($ty_le_lap_day): ?>
<div class="fact"><b><?php echo esc_html($ty_le_lap_day); ?></b><span>Tỷ lệ lấp đầy</span></div>
<?php endif; ?>
</div>
<?php if ($chu_dau_tu): ?>
<div class="source-note">Chủ đầu tư: <strong><?php echo esc_html($chu_dau_tu); ?></strong>.</div>
<?php endif; ?>
</section>

<!-- 2. THÔNG SỐ / HẠ TẦNG — chỉ hiện nếu crawler tách được mô tả hạ tầng
(KHÔNG còn tách riêng điện/nước/viễn thông như bản cũ, vì crawler
hiện chỉ lấy được 1 đoạn mô tả hạ tầng chung, không có số liệu riêng
từng hạng mục) -->
<?php if ($ha_tang_text): ?>
<section class="panel" id="sec-thong-so">
<h2>Hạ tầng</h2>
<p class="desc"><?php echo esc_html($ha_tang_text); ?></p>
</section>
<?php endif; ?>

<!-- 3. NGÀNH NGHỀ THU HÚT — chỉ hiện nếu có dữ liệu -->
<?php if ($nganh_nghe_text): ?>
<section class="panel" id="sec-nganh-nghe">
<h2>Ngành nghề thu hút</h2>
<div class="chips">
<?php
$nganh_nghe_arr = explode(',', $nganh_nghe_text);
foreach ($nganh_nghe_arr as $nganh) : ?>
<span class="chip"><?php echo esc_html(trim($nganh)); ?></span>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<!-- 6. ƯU ĐÃI & CHÍNH SÁCH ĐẦU TƯ — bỏ dòng tuyên bố cụ thể (miễn thuế X năm...)
vì đây là thông tin CHÍNH SÁCH THẬT của từng KCN, crawler chưa trích xuất
được, không nên hiển thị số liệu có thể sai. Giữ lại các chip là dịch vụ
hỗ trợ CHUNG của BDS24H (không phải cam kết cụ thể của riêng KCN này). -->
<section class="panel" id="sec-uu-dai">
<h2>Hỗ trợ đầu tư từ BDS24H</h2>
<div class="chips">
<span class="chip">Hỗ trợ thủ tục IRC / ERC</span>
<span class="chip">Kết nối trực tiếp chủ đầu tư</span>
<span class="chip">Tư vấn pháp lý miễn phí</span>
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

<!-- 8. MÔ TẢ CHI TIẾT — ưu tiên field ACF "mo_ta_chi_tiet" (nơi crawl_kcn.py
lưu mô tả đầy đủ), get_the_content() thường trống vì script chỉ ghi ACF -->
<?php
$mo_ta_chi_tiet_kcn = get_field('mo_ta_chi_tiet');
?>
<?php if ( $mo_ta_chi_tiet_kcn ) : ?>
<section class="panel" id="sec-bo-sung">
<h2>Mô tả chi tiết</h2>
<div class="desc"><?php echo nl2br(esc_html($mo_ta_chi_tiet_kcn)); ?></div>
</section>
<?php elseif ( get_the_content() ) : ?>
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
