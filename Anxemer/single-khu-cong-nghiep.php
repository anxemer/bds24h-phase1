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

		/* RESET KHUNG CONTAINER CỦA THEME PEARL THÀNH FULL WIDTH */
		html, body {
			margin: 0 !important;
			padding: 0 !important;
			width: 100% !important;
		}

		#main, #content, .site-content, .stm-single-post, .container, .row, .detail-shell {
			max-width: 100% !important;
			width: 100% !important;
			padding-left: 0 !important;
			padding-right: 0 !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
			border: none !important;
			float: none !important;
		}

		.wrap {
			max-width: 1180px !important;
			width: min(1180px, calc(100% - 40px)) !important;
			margin: auto !important;
		}

		.detail-shell {
			padding-bottom: 48px;
		}

		.detail-view {
			display: block !important;
		}

		.detail-empty {
			display: none !important;
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

		.gallery.no-side {
			grid-template-columns: 1fr !important;
		}

		.gallery.no-side .cover {
			width: 100% !important;
		}

		.kxd-gallery-thumbs {
			display: flex;
			gap: 8px;
			padding: 10px 14px;
			background: #f8fafc;
			border-top: 1px solid #e2e8f0;
			overflow-x: auto;
			scrollbar-width: thin;
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

		.kxd-thumb-item:hover {
			border-color: #2563eb;
			transform: scale(1.04);
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

		/* INFRASTRUCTURE 4-CARD GRID */
		.infra-grid {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 16px;
			margin-top: 14px;
		}
		.infra-card {
			background: #f8fafc;
			border: 1px solid #e2e8f0;
			border-radius: 10px;
			padding: 18px 20px;
			transition: all 0.2s ease;
		}
		.infra-card:hover {
			border-color: var(--navy);
			box-shadow: 0 4px 14px rgba(15, 127, 47, 0.08);
			transform: translateY(-2px);
		}
		.infra-card-header {
			display: flex;
			align-items: center;
			gap: 10px;
			margin-bottom: 10px;
			font-family: 'Oswald', sans-serif;
			font-size: 16px;
			font-weight: 700;
			text-transform: uppercase;
			color: var(--navy);
		}
		.infra-card-icon {
			font-size: 20px;
		}
		.infra-card-desc {
			font-family: 'Roboto', sans-serif;
			font-size: 14px;
			line-height: 1.65;
			color: #334155;
			margin: 0;
		}
		@media (max-width: 640px) {
			.infra-grid {
				grid-template-columns: 1fr;
			}
		}

		/* CHỦ ĐẦU TƯ BANNER */
		.kcn-cdt-box {
			background: #f0fdf4;
			border: 1px solid #bbf7d0;
			border-left: 4px solid var(--navy);
			padding: 14px 18px;
			border-radius: 8px;
			margin-top: 16px;
			font-family: 'Roboto', sans-serif;
			font-size: 15px;
			color: #0f172a;
			display: flex;
			align-items: center;
			gap: 10px;
			flex-wrap: wrap;
		}
		.kcn-cdt-box strong {
			color: var(--navy);
			font-weight: 700;
		}

		/* KẾT NỐI GIAO THÔNG */
		.kcn-traffic-box {
			background: #f8fafc;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			padding: 18px 20px;
			font-family: 'Roboto', sans-serif;
			font-size: 14.5px;
			line-height: 1.7;
			color: #334155;
			display: flex;
			flex-direction: column;
			gap: 10px;
		}
		.kcn-traffic-item {
			display: flex;
			align-items: flex-start;
			gap: 10px;
		}
		.kcn-traffic-icon {
			color: var(--navy);
			font-weight: 700;
			font-size: 16px;
			flex-shrink: 0;
			margin-top: 1px;
		}

		/* BIỂU PHÍ & CHI PHÍ */
		.kcn-fee-grid {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 14px;
			margin-top: 14px;
		}
		.kcn-fee-item {
			background: #f8fafc;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			padding: 14px 18px;
		}
		.kcn-fee-label {
			font-size: 12.5px;
			text-transform: uppercase;
			font-weight: 700;
			color: var(--navy);
			margin-bottom: 4px;
			letter-spacing: 0.03em;
		}
		.kcn-fee-val {
			font-size: 14.5px;
			color: #1e293b;
			line-height: 1.5;
		}
		@media (max-width: 640px) {
			.kcn-fee-grid {
				grid-template-columns: 1fr;
			}
		}

		/* CHÍNH SÁCH ƯU ĐÃI */
		.kcn-incentive-box {
			background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
			border: 1px solid #bbf7d0;
			border-left: 4px solid var(--navy);
			border-radius: 8px;
			padding: 18px 20px;
			margin-bottom: 18px;
		}
		.kcn-inc-tag {
			font-size: 12px;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.05em;
			color: #166534;
			margin-bottom: 6px;
		}
		.kcn-inc-text {
			font-size: 15px;
			font-weight: 600;
			color: #14532d;
			line-height: 1.65;
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
		/* =========================================================
		   HỒ SƠ THUYẾT MINH DỰ ÁN (PROFESSIONAL DOSSIER STYLES)
		========================================================= */
		.kcn-dossier-badge {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			background: #f0fdf4;
			color: #166534;
			border: 1px solid #bbf7d0;
			padding: 4px 14px;
			border-radius: 9999px;
			font-size: 13px;
			font-weight: 600;
			margin-bottom: 14px;
		}

		.kcn-dossier-wrap {
			display: flex;
			flex-direction: column;
			gap: 16px;
			margin-top: 14px;
		}

		.kcn-dossier-card {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 10px;
			padding: 18px 22px;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
			transition: border-color 0.2s, box-shadow 0.2s;
		}

		.kcn-dossier-card:hover {
			border-color: #cbd5e1;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
		}

		.kcn-dossier-card-title {
			font-family: 'Oswald', sans-serif;
			font-size: 18px;
			font-weight: 700;
			color: #0f172a;
			margin: 0 0 12px 0;
			padding-bottom: 8px;
			border-bottom: 2px solid #f1f5f9;
			display: flex;
			align-items: center;
			gap: 10px;
			letter-spacing: 0.3px;
		}

		.kcn-dossier-card-title::before {
			content: '';
			display: inline-block;
			width: 4px;
			height: 18px;
			background: #2563eb;
			border-radius: 2px;
		}

		.kcn-dossier-table {
			display: grid;
			grid-template-columns: 1fr;
			gap: 8px;
		}

		.kcn-dossier-row {
			display: grid;
			grid-template-columns: 220px 1fr;
			gap: 14px;
			padding: 9px 14px;
			background: #f8fafc;
			border-radius: 6px;
			font-size: 14.5px;
			line-height: 1.6;
		}

		@media(max-width: 640px) {
			.kcn-dossier-row {
				grid-template-columns: 1fr;
				gap: 3px;
			}
		}

		.kcn-dossier-key {
			font-weight: 600;
			color: #334155;
		}

		.kcn-dossier-val {
			color: #0f172a;
		}

		.kcn-dossier-p {
			margin: 6px 0;
			font-size: 14.5px;
			line-height: 1.7;
			color: #334155;
			padding-left: 14px;
			position: relative;
		}

		.kcn-dossier-p::before {
			content: '•';
			position: absolute;
			left: 0;
			color: #2563eb;
			font-weight: bold;
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

// BÓC TÁCH DỮ LIỆU THẬT TỪ MÔ TẢ CHI TIẾT DỰ ÁN (NƠI CRAWLER LƯU TOÀN BỘ HỒ SƠ KCN)
$raw_kcn_content = $mo_ta_chi_tiet_kcn ?: get_the_content();
$parsed_kcn = array(
    'chu_dau_tu'   => '',
    'dia_diem'     => '',
    'quy_mo'       => '',
    'thoi_han'     => '',
    'gia_thue'     => '',
    'giao_thong'   => '',
    'dien'         => '',
    'nuoc'         => '',
    'nuoc_thai'    => '',
    'vien_thong'   => '',
    'nganh_nghe'   => '',
    'phi_quan_ly'  => '',
    'gia_dien'     => '',
    'gia_nuoc'     => '',
    'phi_nuoc_thai'=> '',
    'uu_dai'       => '',
);

if ( !empty($raw_kcn_content) ) {
    if (preg_match('/(?:Công\s*ty\s*)?chủ\s*đầu\s*tư\s*:\s*\n*([^\n\r]+)/iu', $raw_kcn_content, $m)) {
        $parsed_kcn['chu_dau_tu'] = trim($m[1]);
    }
    if (preg_match('/(?:Địa\s*điểm|Vị\s*trí)\s*:\s*\n*([^\n\r]+)/iu', $raw_kcn_content, $m)) {
        $parsed_kcn['dia_diem'] = trim(rtrim($m[1], '.'));
    }
    if (preg_match('/(?:Quy\s*mô(?:\s*diện\s*tích)?|Diện\s*tích(?:\s*khu\s*công\s*nghiệp)?)\s*:\s*\n*([^\n\r]+)/iu', $raw_kcn_content, $m)) {
        $parsed_kcn['quy_mo'] = trim($m[1]);
    }
    if (preg_match('/Thời\s*hạn(?:\s*vận\s*hành|\s*sử\s*dụng)?\s*:\s*\n*([^\n\r]+)/iu', $raw_kcn_content, $m)) {
        $parsed_kcn['thoi_han'] = trim($m[1]);
    }
    if (preg_match('/Giá\s*thuê\s*đất[^:\n\r]*:\s*\n*([^\n\r]+)/iu', $raw_kcn_content, $m)) {
        $parsed_kcn['gia_thue'] = trim($m[1]);
    } elseif (preg_match('/Giá\s*thuê[^:\n\r]*:\s*\n*([^\n\r]+)/iu', $raw_kcn_content, $m)) {
        $parsed_kcn['gia_thue'] = trim($m[1]);
    }
    if (preg_match('/II\.\s*Kết\s*nối\s*giao\s*thông[^\n\r]*\n+(.*?)(?=\n+III\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['giao_thong'] = trim($m[1]);
    }
    if (preg_match('/Hệ\s*thống\s*điện\s*:\s*\n*(.*?)(?=\n+Hệ\s*thống|\n+Internet|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['dien'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/Hệ\s*thống\s*nước\s*:\s*\n*(.*?)(?=\n+Hệ\s*thống|\n+Internet|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['nuoc'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/Hệ\s*thống\s*xử\s*lý\s*nước\s*thải\s*:\s*\n*(.*?)(?=\n+Hệ\s*thống|\n+Internet|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['nuoc_thai'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/(?:Internet\s*&\s*viễn\s*thông|Hệ\s*thống\s*viễn\s*thông)\s*:\s*\n*(.*?)(?=\n+Hệ\s*thống|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['vien_thong'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/IV\.\s*Lĩnh\s*vực\s*ưu\s*tiên[^\n\r]*\n+(.*?)(?=\n+V\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['nganh_nghe'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/(?:–|-|\*)?\s*Phí\s*quản\s*lý\s*:\s*\n*([^\n\r]+)/iu', $raw_kcn_content, $m)) {
        $parsed_kcn['phi_quan_ly'] = trim($m[1]);
    }
    if (preg_match('/Giá\s*điện\s*:\s*\n*(.*?)(?=\n+Giá\s*nước|\n+Phí|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['gia_dien'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/Giá\s*nước\s*:\s*\n*(.*?)(?=\n+Giá\s*điện|\n+Phí|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['gia_nuoc'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/Phí\s*xử\s*lý\s*nước\s*thải\s*:\s*\n*(.*?)(?=\n+Giá|\n+Phí|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['phi_nuoc_thai'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
    if (preg_match('/VII\.\s*Chính\s*sách\s*ưu\s*đãi[^\n\r]*\n+(.*?)(?=\n+Thông\s*tin\s*liên\s*hệ|\n+[I|V|X]+\.|\Z)/isu', $raw_kcn_content, $m)) {
        $parsed_kcn['uu_dai'] = trim(preg_replace('/\s+/', ' ', $m[1]));
    }
}

// Hợp nhất dữ liệu: Ưu tiên ACF nếu có, rỗng thì lấy từ kết quả bóc tách
if (empty($chu_dau_tu) && !empty($parsed_kcn['chu_dau_tu'])) {
    $chu_dau_tu = $parsed_kcn['chu_dau_tu'];
}
if (($vi_tri === 'Đang cập nhật' || empty($vi_tri)) && !empty($parsed_kcn['dia_diem'])) {
    $vi_tri = $parsed_kcn['dia_diem'];
    $khu_vuc = $parsed_kcn['dia_diem'];
}
if (($gia_thue === 'Liên hệ báo giá' || empty($gia_thue)) && !empty($parsed_kcn['gia_thue'])) {
    $gia_thue = $parsed_kcn['gia_thue'];
}
if (empty($dien_tich) && !empty($parsed_kcn['quy_mo'])) {
    $dien_tich = $parsed_kcn['quy_mo'];
}
$thoi_han_van_hanh = $parsed_kcn['thoi_han'];
$giao_thong_text = $parsed_kcn['giao_thong'];
$has_infra = !empty($parsed_kcn['dien']) || !empty($parsed_kcn['nuoc']) || !empty($parsed_kcn['nuoc_thai']) || !empty($parsed_kcn['vien_thong']);
$nganh_nghe_text = $nganh_nghe_text ?: $parsed_kcn['nganh_nghe'];
$chinh_sach_uu_dai = $parsed_kcn['uu_dai'];
$phi_quan_ly = $parsed_kcn['phi_quan_ly'];
$gia_dien = $parsed_kcn['gia_dien'];
$gia_nuoc = $parsed_kcn['gia_nuoc'];
$phi_nuoc_thai = $parsed_kcn['phi_nuoc_thai'];
$has_bieu_phi = !empty($phi_quan_ly) || !empty($gia_dien) || !empty($gia_nuoc) || !empty($phi_nuoc_thai);

// =========================================================================
// MULTI-SOURCE IMAGE LOADER CHO KHU CÔNG NGHIỆP
// Tự động gom ảnh từ: Featured Image, WP Media Library stem, Attached Media, 
// ACF gallery_anh, _kcn_gallery_ids và trích xuất ảnh chất lượng cao từ post_content
// =========================================================================
$gallery_images = array();

// 1. Ảnh đại diện featured image
$thumb_url = get_the_post_thumbnail_url($post_id, 'full');
if ($thumb_url) {
	$gallery_images[] = $thumb_url;
}

// 2. Native Gallery Metabox _kcn_gallery_ids
$raw_gallery_ids = get_post_meta($post_id, '_kcn_gallery_ids', true);
if ($raw_gallery_ids) {
	$ids = array_filter(array_map('intval', explode(',', (string)$raw_gallery_ids)));
	foreach ($ids as $img_id) {
		$img_url = wp_get_attachment_image_url($img_id, 'full');
		if ($img_url && !in_array($img_url, $gallery_images, true)) {
			$gallery_images[] = $img_url;
		}
	}
}

// 3. ACF field gallery_anh
$acf_gallery = get_field('gallery_anh');
if (is_array($acf_gallery)) {
	foreach ($acf_gallery as $g) {
		$g_url = is_array($g) ? ($g['url'] ?? '') : (is_numeric($g) ? wp_get_attachment_image_url($g, 'full') : $g);
		if ($g_url && !in_array($g_url, $gallery_images, true)) {
			$gallery_images[] = $g_url;
		}
	}
}

// 4. Media đính kèm bài viết (attached media)
$attached = get_attached_media('image', $post_id);
if (!empty($attached)) {
	foreach ($attached as $att) {
		$att_url = wp_get_attachment_image_url($att->ID, 'full');
		if ($att_url && !in_array($att_url, $gallery_images, true)) {
			$gallery_images[] = $att_url;
		}
	}
}

// 5. Media Library query theo slug stem của bài viết (vd: khu-cong-nghiep-cau-cang-phuoc-dong-long-an_%)
global $wpdb;
$post_slug = get_post_field('post_name', $post_id);
if ($post_slug) {
	$stem_prefix = preg_replace('/-\d+$/', '', $post_slug);
	$like_pattern = $wpdb->esc_like($stem_prefix) . '%';
	$matched_ids = $wpdb->get_col($wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%' AND post_name LIKE %s ORDER BY ID ASC LIMIT 15",
		$like_pattern
	));
	if (!empty($matched_ids)) {
		foreach ($matched_ids as $m_id) {
			$m_url = wp_get_attachment_image_url($m_id, 'full');
			if ($m_url && !in_array($m_url, $gallery_images, true)) {
				$gallery_images[] = $m_url;
			}
		}
	}
}

// 6. Trích xuất ảnh chất lượng cao từ nội dung bài viết (post_content / mo_ta_chi_tiet)
$content_html = get_the_content();
if (empty($content_html)) {
	$content_html = get_field('mo_ta_chi_tiet');
}
if (!empty($content_html)) {
	if (preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i', $content_html, $c_matches)) {
		foreach ($c_matches[1] as $c_img) {
			if (strpos($c_img, '280x280') !== false || stripos($c_img, 'icon') !== false || stripos($c_img, 'logo') !== false || stripos($c_img, 'avatar') !== false) {
				continue;
			}
			$clean_url = preg_replace('/-\d+x\d+(?=\.[a-zA-Z]+$)/', '', $c_img);
			if ($clean_url && !in_array($clean_url, $gallery_images, true)) {
				$gallery_images[] = $clean_url;
			}
		}
	}
}

// Xác định $thumb_url (ảnh chính)
if (empty($thumb_url) && !empty($gallery_images)) {
	$thumb_url = $gallery_images[0];
}
if (!$thumb_url) {
	// SVG placeholder chuẩn thương hiệu BDS24H, tuyệt đối không dùng link đối thủ
	$thumb_url = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22500%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23132B45%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20fill%3D%22%23ffffff%22%20font-family%3D%22sans-serif%22%20font-size%3D%2224%22%20text-anchor%3D%22middle%22%20dy%3D%22.3em%22%3EB%C4%90S%20KHU%20C%C3%94NG%20NGHI%E1%BB%86P%20VI%E1%BB%86T%20NAM%3C%2Ftext%3E%3C%2Fsvg%3E';
}

// Tách riêng side images: các ảnh phụ khác với ảnh cover đang hiển thị
$sub_gallery = array();
foreach ($gallery_images as $g_img) {
	if ($g_img !== $thumb_url) {
		$sub_gallery[] = $g_img;
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
<!-- HERO BANNER VỚI ẢNH ĐẠI DIỆN + DẢI THUMBNAIL TƯƠNG TÁC -->
<div class="hero">
<div class="gallery<?php echo !empty($sub_gallery) ? ' has-side' : ' no-side'; ?>">
<div class="cover" role="img" aria-label="Ảnh toàn cảnh <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($thumb_url); ?>')">
<span class="photo-label">Ảnh dự án · <?php the_title(); ?></span>
</div>
<?php if (!empty($sub_gallery)): ?>
<div class="side">
<?php
$side_images = array_slice($sub_gallery, 0, 2);
foreach ($side_images as $img):
$img_url = is_array($img) ? ($img['sizes']['medium'] ?? $img['url']) : $img;
?>
<div role="img" aria-label="Ảnh thêm <?php the_title(); ?>" style="background-image:url('<?php echo esc_url($img_url); ?>')" onclick="document.querySelector('.gallery .cover').style.backgroundImage='url(<?php echo esc_url($img_url); ?>)';"></div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
<?php if (count($gallery_images) > 1): ?>
<div class="kxd-gallery-thumbs">
<?php foreach ($gallery_images as $img):
$img_url = is_array($img) ? $img['url'] : $img;
?>
<div class="kxd-thumb-item" style="background-image:url('<?php echo esc_url($img_url); ?>');"
     onclick="document.querySelector('.gallery .cover').style.backgroundImage='url(<?php echo esc_url($img_url); ?>)';"
     title="Nhấn để xem ảnh này">
</div>
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
<?php if ($giao_thong_text): ?><a href="#sec-giao-thong" class="toc-item">2. Kết nối giao thông</a><?php endif; ?>
<?php if ($has_infra || $ha_tang_text): ?><a href="#sec-thong-so" class="toc-item">3. Cơ sở hạ tầng kỹ thuật</a><?php endif; ?>
<?php if ($nganh_nghe_text): ?><a href="#sec-nganh-nghe" class="toc-item">4. Ngành nghề thu hút</a><?php endif; ?>
<?php if ($has_bieu_phi): ?><a href="#sec-bieu-phi" class="toc-item">5. Biểu phí &amp; Chi phí</a><?php endif; ?>
<a href="#sec-uu-dai" class="toc-item">6. Chính sách ưu đãi &amp; Hỗ trợ</a>
<a href="#sec-quy-trinh" class="toc-item">7. Quy trình xúc tiến đầu tư</a>
<?php if ($mo_ta_chi_tiet_kcn || get_the_content()): ?><a href="#sec-bo-sung" class="toc-item">8. Hồ sơ chi tiết dự án</a><?php endif; ?>
<a href="#sec-lien-he" class="toc-item">9. Ban Xúc Tiến Đầu Tư</a>
</div>
</section>

<!-- 1. TỔNG QUAN ĐẦU TƯ -->
<section class="panel" id="sec-tong-quan">
<h2>Tổng quan đầu tư</h2>
<div class="facts">
<div class="fact"><b><?php echo esc_html($gia_thue); ?></b><span>Giá thuê đất / hạ tầng</span></div>
<div class="fact"><b><?php echo esc_html($vi_tri); ?></b><span>Địa bàn / Khu vực</span></div>
<?php if ($dien_tich): ?>
<div class="fact"><b><?php echo esc_html($dien_tich); ?></b><span>Quy mô diện tích</span></div>
<?php endif; ?>
<?php if ($thoi_han_van_hanh): ?>
<div class="fact"><b><?php echo esc_html($thoi_han_van_hanh); ?></b><span>Thời hạn sử dụng</span></div>
<?php elseif ($ty_le_lap_day): ?>
<div class="fact"><b><?php echo esc_html($ty_le_lap_day); ?></b><span>Tỷ lệ lấp đầy</span></div>
<?php else: ?>
<div class="fact"><b style="color:var(--navy);"><?php echo esc_html($trang_thai); ?></b><span>Hiện trạng tiếp nhận</span></div>
<?php endif; ?>
</div>
<?php if ($chu_dau_tu): ?>
<div class="kcn-cdt-box">
  <span style="font-size:18px;">🏢</span>
  <div><strong>Chủ đầu tư dự án:</strong> <span><?php echo esc_html($chu_dau_tu); ?></span></div>
</div>
<?php endif; ?>
</section>

<!-- 2. KẾT NỐI GIAO THÔNG -->
<?php if ($giao_thong_text): ?>
<section class="panel" id="sec-giao-thong">
<h2>Kết nối giao thông trọng yếu</h2>
<div class="kcn-traffic-box">
<?php
$traffic_lines = array_filter(array_map('trim', explode("\n", $giao_thong_text)));
foreach ($traffic_lines as $tline):
    if (empty($tline)) continue;
    $tline = preg_replace('/^[–\-+*•]\s*/u', '', $tline);
?>
    <div class="kcn-traffic-item">
        <span class="kcn-traffic-icon">📍</span>
        <span><?php echo esc_html($tline); ?></span>
    </div>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<!-- 3. CƠ SỞ HẠ TẦNG & KỸ THUẬT -->
<?php if ($has_infra || $ha_tang_text): ?>
<section class="panel" id="sec-thong-so">
<h2>Thực trạng cơ sở hạ tầng &amp; kỹ thuật</h2>
<?php if ($has_infra): ?>
<div class="infra-grid">
    <?php if (!empty($parsed_kcn['dien'])): ?>
    <div class="infra-card">
        <div class="infra-card-header"><span class="infra-card-icon">⚡</span><span>Hệ thống cấp điện</span></div>
        <p class="infra-card-desc"><?php echo esc_html($parsed_kcn['dien']); ?></p>
    </div>
    <?php endif; ?>
    <?php if (!empty($parsed_kcn['nuoc'])): ?>
    <div class="infra-card">
        <div class="infra-card-header"><span class="infra-card-icon">💧</span><span>Hệ thống cấp nước</span></div>
        <p class="infra-card-desc"><?php echo esc_html($parsed_kcn['nuoc']); ?></p>
    </div>
    <?php endif; ?>
    <?php if (!empty($parsed_kcn['nuoc_thai'])): ?>
    <div class="infra-card">
        <div class="infra-card-header"><span class="infra-card-icon">♻️</span><span>Xử lý nước thải</span></div>
        <p class="infra-card-desc"><?php echo esc_html($parsed_kcn['nuoc_thai']); ?></p>
    </div>
    <?php endif; ?>
    <?php if (!empty($parsed_kcn['vien_thong'])): ?>
    <div class="infra-card">
        <div class="infra-card-header"><span class="infra-card-icon">🌐</span><span>Viễn thông &amp; Số hóa</span></div>
        <p class="infra-card-desc"><?php echo esc_html($parsed_kcn['vien_thong']); ?></p>
    </div>
    <?php endif; ?>
</div>
<?php else: ?>
<p class="desc"><?php echo esc_html($ha_tang_text); ?></p>
<?php endif; ?>
</section>
<?php endif; ?>

<!-- 4. NGÀNH NGHỀ THU HÚT ĐẦU TƯ -->
<?php if ($nganh_nghe_text): ?>
<section class="panel" id="sec-nganh-nghe">
<h2>Lĩnh vực ưu tiên thu hút đầu tư</h2>
<div class="chips">
<?php
$clean_nganh = preg_replace('/^(?:–|-|\*|Ưu\s*tiên\s*lĩnh\s*vực[^\n:]*[:\s]*|Thu\s*hút\s*đa\s*ngành\s*nghề[^\n:]*[:\s]*)/iu', '', $nganh_nghe_text);
$nganh_items = preg_split('/[;,]|\n+/u', $clean_nganh);
foreach ($nganh_items as $nganh) :
    $n_trim = trim($nganh);
    if (empty($n_trim) || mb_strlen($n_trim) < 3) continue;
?>
<span class="chip">🏭 <?php echo esc_html($n_trim); ?></span>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<!-- 5. BIỂU PHÍ & CHI PHÍ DỊCH VỤ -->
<?php if ($has_bieu_phi): ?>
<section class="panel" id="sec-bieu-phi">
<h2>Phí quản lý &amp; Biểu phí dịch vụ liên quan</h2>
<div class="kcn-fee-grid">
    <?php if (!empty($phi_quan_ly)): ?>
    <div class="kcn-fee-item">
        <div class="kcn-fee-label">🏢 Phí quản lý KCN</div>
        <div class="kcn-fee-val"><strong><?php echo esc_html($phi_quan_ly); ?></strong></div>
    </div>
    <?php endif; ?>
    <?php if (!empty($gia_dien)): ?>
    <div class="kcn-fee-item">
        <div class="kcn-fee-label">⚡ Đơn giá cấp điện</div>
        <div class="kcn-fee-val"><?php echo esc_html($gia_dien); ?></div>
    </div>
    <?php endif; ?>
    <?php if (!empty($gia_nuoc)): ?>
    <div class="kcn-fee-item">
        <div class="kcn-fee-label">💧 Đơn giá cấp nước</div>
        <div class="kcn-fee-val"><?php echo esc_html($gia_nuoc); ?></div>
    </div>
    <?php endif; ?>
    <?php if (!empty($phi_nuoc_thai)): ?>
    <div class="kcn-fee-item">
        <div class="kcn-fee-label">♻️ Phí xử lý nước thải</div>
        <div class="kcn-fee-val"><?php echo esc_html($phi_nuoc_thai); ?></div>
    </div>
    <?php endif; ?>
</div>
</section>
<?php endif; ?>

<!-- 6. ƯU ĐÃI & CHÍNH SÁCH ĐẦU TƯ -->
<section class="panel" id="sec-uu-dai">
<h2>Chính sách ưu đãi thu hút đầu tư</h2>
<?php if (!empty($chinh_sach_uu_dai)): ?>
<div class="kcn-incentive-box">
    <div class="kcn-inc-tag">⭐ Ưu đãi đầu tư đặc biệt tại KCN</div>
    <div class="kcn-inc-text"><?php echo esc_html($chinh_sach_uu_dai); ?></div>
</div>
<?php endif; ?>
<div class="source-note" style="margin-bottom:14px;"><strong>Dịch vụ hỗ trợ trực tiếp từ BDS24H &amp; Ban Quản Lý:</strong></div>
<div class="chips">
<span class="chip">Hỗ trợ thủ tục cấp phép IRC / ERC</span>
<span class="chip">Kết nối trực tiếp Ban Quản Lý KCN &amp; CĐT</span>
<span class="chip">Tư vấn pháp lý &amp; đánh giá tác động môi trường ĐTM</span>
<span class="chip">Thẩm duyệt thiết kế PCCC &amp; Giấy phép xây dựng GPXD</span>
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

<!-- 8. HỒ SƠ CHI TIẾT & THUYẾT MINH DỰ ÁN -->
<?php 
$raw_mota = $mo_ta_chi_tiet_kcn ?: get_the_content();
if (!empty($raw_mota)) : 
    // 1. Cắt bỏ toàn bộ phần liên hệ đối thủ, số điện thoại, WeChat, KCN cùng khu vực ở cuối
    $cut_patterns = array(
        '/(?i)Thông\s*tin\s*liên\s*hệ\s*phòng\s*xúc\s*tiến.*/s',
        '/(?i)Thông\s*tin\s*liên\s*hệ.*/s',
        '/(?i)Hỏi\s*đáp\s*nhanh.*/s',
        '/(?i)KCN\s*cùng\s*khu\s*vực.*/s',
        '/(?i)Lưu\s*ý\s*:\s*Với\s*vai\s*trò\s*là\s*người\s*tạo\s*ra\s*sân\s*chơi.*/s',
        '/(?i)Liên\s*hệ\s*ngay\s*để\s*nhận\s*thông\s*tin\s*chi\s*tiết.*/s',
        '/(?i)Giá\s*thuê\s*đất\s*tham\s*khảo.*/s',
        '/(?i)👉?\s*Xem\s*thêm\s*tại\s*(?:www\.)?khoxuongdep\.com\.vn.*/s',
    );
    $text = $raw_mota;
    foreach ($cut_patterns as $pat) {
        $parts = preg_split($pat, $text);
        if (!empty($parts)) {
            $text = $parts[0];
        }
    }
    
    // Khử số điện thoại đối thủ, wechat, domain đối thủ
    $text = preg_replace('/(?i)0901\s*626\s*248|0932\s*238\s*248|\( Mr Lương \)/u', '', $text);
    $text = preg_replace('/(?i)(?:www\.)?khoxuongdep(?:\.com\.vn)?/u', 'batdongsankhucongnghiep.vn', $text);
    $text = preg_replace('/(?i)(?:WeChat\s*ID|WhatsApp)[^\n]*/u', '', $text);
    
    $raw_lines = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $text))));
    
    // 2. Bỏ breadcrumbs, tiêu đề lặp, tags ở đầu
    $post_title_raw = function_exists('wp_specialchars_decode') ? wp_specialchars_decode(get_the_title(), ENT_QUOTES) : html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8');
    $title_norm = preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower($post_title_raw, 'UTF-8'));
    
    $valid_lines = array();
    $in_header = true;
    foreach ($raw_lines as $l) {
        $l_norm = preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower($l, 'UTF-8'));
        if (in_array($l, array('Trang chủ', '/', 'Khu Công Nghiệp', 'khu-cong-nghiep'), true) || mb_stripos($l, 'trang chủ /') !== false) {
            continue;
        }
        if ($in_header && (in_array($l, array('Đang hoạt động', 'Khu Công Nghiệp', 'Hồ Chí Minh', 'Long An', 'Bình Dương', 'Bà Rịa - Vũng Tàu'), true) || $l_norm === $title_norm)) {
            continue;
        }
        if ($in_header && (!empty($title_norm) && ($l_norm === $title_norm || mb_strpos($l_norm, $title_norm) !== false))) {
            continue;
        }
        $in_header = false;
        $valid_lines[] = $l;
    }
    
    // 3. Gom nhãn và giá trị nằm trên 2 dòng kế tiếp thành các thẻ hồ sơ
    $doc_blocks = array();
    $current_card = null;
    $i = 0;
    $total_lines = count($valid_lines);
    
    while ($i < $total_lines) {
        $line = $valid_lines[$i];
        
        // Nhận diện tiêu đề La Mã (I. , II. , ...)
        if (preg_match('/^[IVXLCDM]+\.\s+(.+)/u', $line, $h_match)) {
            if ($current_card) {
                $doc_blocks[] = $current_card;
            }
            $current_card = array(
                'title' => $line,
                'rows' => array()
            );
            $i++;
            continue;
        }
        
        // Nếu dòng kết thúc bằng dấu : và dòng sau là giá trị
        if (mb_substr($line, -1) === ':' && mb_strlen($line) < 45 && ($i + 1 < $total_lines)) {
            $next_line = $valid_lines[$i + 1];
            if (!preg_match('/^[IVXLCDM]+\.\s+/u', $next_line) && mb_substr($next_line, -1) !== ':') {
                $item = array('type' => 'kv', 'key' => rtrim($line, ':'), 'val' => $next_line);
                if ($current_card) {
                    $current_card['rows'][] = $item;
                } else {
                    $doc_blocks[] = array('title' => 'Tổng quan dự án', 'rows' => array($item));
                }
                $i += 2;
                continue;
            }
        }
        
        // Nếu dòng có dấu : ở giữa
        if (strpos($line, ':') !== false && !preg_match('/^https?:\/\//i', $line)) {
            $parts = explode(':', $line, 2);
            if (mb_strlen(trim($parts[0])) < 40 && trim($parts[1]) !== '') {
                $item = array('type' => 'kv', 'key' => trim($parts[0]), 'val' => trim($parts[1]));
                if ($current_card) {
                    $current_card['rows'][] = $item;
                } else {
                    $doc_blocks[] = array('title' => 'Tổng quan dự án', 'rows' => array($item));
                }
                $i++;
                continue;
            }
        }
        
        // Cự ly (vd "TP. Hồ Chí Minh" dòng sau "15 km")
        if ($i + 1 < $total_lines && preg_match('/^\d+[\s\w,.-]+(?:km|m|ha|m2|m²)$/ui', $valid_lines[$i + 1])) {
            $item = array('type' => 'kv', 'key' => $line, 'val' => $valid_lines[$i + 1]);
            if ($current_card) {
                $current_card['rows'][] = $item;
            } else {
                $doc_blocks[] = array('title' => 'Tổng quan dự án', 'rows' => array($item));
            }
            $i += 2;
            continue;
        }
        
        // Đoạn văn thuyết minh
        $item = array('type' => 'p', 'text' => $line);
        if ($current_card) {
            $current_card['rows'][] = $item;
        } else {
            $doc_blocks[] = array('title' => 'Thuyết minh dự án', 'rows' => array($item));
        }
        $i++;
    }
    if ($current_card) {
        $doc_blocks[] = $current_card;
    }
?>
<?php if (!empty($doc_blocks)): ?>
<section class="panel" id="sec-bo-sung">
<div class="kcn-dossier-badge">✓ Hồ sơ thuyết minh kinh tế - kỹ thuật dự án · Xác thực bởi BDS24H</div>
<h2>Hồ sơ chi tiết &amp; Thuyết minh dự án</h2>

<div class="kcn-dossier-wrap">
<?php foreach ($doc_blocks as $card): ?>
    <div class="kcn-dossier-card">
        <div class="kcn-dossier-card-title"><?php echo esc_html($card['title']); ?></div>
        <div class="kcn-dossier-table">
        <?php foreach ($card['rows'] as $r): ?>
            <?php if ($r['type'] === 'kv'): ?>
                <div class="kcn-dossier-row">
                    <span class="kcn-dossier-key"><?php echo esc_html($r['key']); ?>:</span>
                    <span class="kcn-dossier-val"><?php echo esc_html($r['val']); ?></span>
                </div>
            <?php else: ?>
                <p class="kcn-dossier-p"><?php echo esc_html($r['text']); ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>
<?php endif; ?>

<!-- BANNER PHÒNG XÚC TIẾN ĐẦU TƯ -->
<section class="invest-promo-banner" id="sec-lien-he">
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
<section class="panel source" style="background:#f8fafc; border:1px solid var(--line); border-radius:8px; padding:12px 16px;">
    <div style="font-size:12.5px; color:#475569; display:flex; align-items:center; gap:8px;">
        <span style="color:var(--navy); font-weight:700;">✔</span>
        <span>Hồ sơ dữ liệu công nghiệp được xác thực bởi <strong>BDS24H</strong></span>
    </div>
</section>
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
