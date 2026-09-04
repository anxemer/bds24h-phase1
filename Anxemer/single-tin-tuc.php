<?php
/**
 * Template Name: Chi Tiet Tin Tuc (Chuan 100% news-detail.html)
 * Post Type: tin-tuc, post
 * Description: Template chi tiet bai tin tuc dong - an Header mac dinh Theme, mo rong 1180px chuan news-detail.html
 */

get_header();
?>

<style>
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

html, body {
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    background: #f4f6f3 !important;
}

#main, #content, .site-content, .stm-single-post, .container, .row {
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
    width: min(1180px, calc(100% - 40px)) !important;
    margin: 0 auto !important;
    padding: 0 !important;
}
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;600;700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

<style>
:root { --ink: #000000; --navy: #0f7f2f; --teal: #16c04a; --red: #ff7f2a; --paper: #f4f6f3; --panel: #ffffff; --line: #e2e8f0; --muted: #000000; }
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { background: var(--paper) !important; color: #000000; font-family: 'Roboto', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important; font-size: 15px; line-height: 1.65; -webkit-font-smoothing: antialiased; }
a { color: inherit; text-decoration: none; }

.crumb { padding: 16px 0 12px; color: #000000 !important; font-family: 'Roboto', sans-serif; font-size: 12.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
.crumb a { color: #000000 !important; font-weight: 600; }
.crumb a:hover { color: var(--navy); }
.news-shell { padding-bottom: 48px; }

.article-header { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 28px 32px; margin-bottom: 16px; }
.meta-tag { display: inline-block; background: #e8f5e9; color: var(--navy); font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 10px; }
.article-header h1 { font-family: 'Oswald', sans-serif; font-size: 32px; font-weight: 700; line-height: 1.25; text-transform: uppercase; color: #000000 !important; margin: 0 0 14px; letter-spacing: 0.5px; }
.article-meta { display: flex; align-items: center; gap: 16px; font-size: 13.5px; color: #000000 !important; font-weight: 500; border-top: 1px solid var(--line); padding-top: 14px; margin-top: 14px; flex-wrap: wrap; }
.article-meta span { display: inline-flex; align-items: center; gap: 6px; }

.layout { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 20px; align-items: start; }
.content-panel { background: var(--panel); border: 1px solid var(--line); border-radius: 10px; padding: 28px 32px; }

.hero-image { width: 100%; border-radius: 8px; overflow: hidden; margin-bottom: 20px; }
.hero-image img { width: 100%; height: auto; display: block; object-fit: cover; }
.hero-caption { font-size: 13px; color: #000000 !important; font-weight: 500; text-align: center; margin-top: 6px; font-style: italic; }

/* MỤC LỤC TỰ ĐỘNG */
.toc-box { background: #f8fafc; border: 1.5px solid #cbd5e1; border-left: 4px solid var(--navy); border-radius: 8px; padding: 18px 22px; margin: 24px 0 30px; }
.toc-title { font-family: 'Oswald', sans-serif !important; font-size: 17px !important; font-weight: 700 !important; text-transform: uppercase; color: var(--navy); margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
.toc-list { margin: 0; padding-left: 22px; font-size: 14.5px; line-height: 1.6; }
.toc-list li { margin-bottom: 7px; }
.toc-list li.toc-h3 { margin-left: 18px; font-size: 13.5px; list-style-type: circle; }
.toc-list a { color: #1e3a8a; font-weight: 600; transition: color 0.15s; }
.toc-list a:hover { color: #0f7f2f; text-decoration: underline; }

/* ÉP CHUẨN TOÀN BỘ FONT CHỮ TRONG BÀI VIẾT */
.article-body,
.article-body *,
.article-body p,
.article-body span,
.article-body div,
.article-body strong,
.article-body b,
.article-body em,
.article-body i,
.article-body li,
.article-body a {
    font-family: 'Roboto', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
    letter-spacing: normal !important;
    word-spacing: normal !important;
}

.article-body h1,
.article-body h2,
.article-body h3,
.article-body h4,
.article-body h5,
.article-body h6 {
    scroll-margin-top: 100px;
    letter-spacing: 0.5px !important;
    word-spacing: normal !important;
}

.article-body h2,
.article-body h2 * {
    font-family: 'Oswald', 'Roboto', sans-serif !important;
    font-size: 22px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    color: var(--navy) !important;
    padding-bottom: 6px;
    border-bottom: 2px solid var(--navy);
    margin: 32px 0 16px;
}

.article-body h3,
.article-body h3 * {
    font-family: 'Roboto', 'Inter', sans-serif !important;
    font-size: 17px !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    margin: 24px 0 10px;
}

.article-body p { font-size: 15px; line-height: 1.7; color: #000000; margin-bottom: 16px; }
.lead-paragraph { font-size: 16.5px; font-weight: 500; line-height: 1.65; color: #000000; margin-bottom: 0; }
.quote-box { background: #f0fdf4; border-left: 4px solid var(--navy); padding: 16px 20px; margin: 20px 0; border-radius: 0 8px 8px 0; font-size: 15px; font-style: italic; color: #166534; }
.highlight-box { background: #fff7ed; border: 1px solid #ffedd5; border-left: 4px solid var(--red); padding: 16px 20px; margin: 20px 0; border-radius: 4px; }
.highlight-box b { color: #c2410c; display: block; font-size: 14px; text-transform: uppercase; margin-bottom: 4px; }
.article-body img { max-width: 100%; height: auto; border-radius: 8px; margin: 16px 0 6px; }
.article-body ul, .article-body ol { padding-left: 22px; margin-bottom: 18px; }
.article-body li { margin-bottom: 8px; font-size: 15px; line-height: 1.6; }

.author-footer { margin-top: 36px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; background: #f8fafc; padding: 16px 20px; border-radius: 8px; }
.author-info { display: flex; align-items: center; gap: 12px; }
.avatar { width: 44px; height: 44px; border-radius: 50%; background: var(--navy); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-family: 'Oswald', sans-serif; font-size: 13px; flex-shrink: 0; }
.author-name b { display: block; font-size: 14px; color: var(--ink); }
.author-name span { font-size: 12px; color: var(--muted); }
.source-link { font-size: 12px; color: var(--muted); }
.source-link a { color: var(--navy); font-weight: 700; }

.sticky { position: -webkit-sticky; position: sticky; top: 92px; align-self: start; z-index: 90; }
.sidebar-widget { background: #fff; border: 1px solid var(--line); border-radius: 8px; padding: 20px; margin-bottom: 16px; }
.sidebar-widget h3 { font-family: 'Oswald', sans-serif; font-size: 17px; font-weight: 700; text-transform: uppercase; color: var(--navy); margin: 0 0 14px; padding-bottom: 6px; border-bottom: 2px solid var(--navy); letter-spacing: 0.5px; }

.hot-news-item { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); }
.hot-news-item:last-child { border-bottom: none; }
.hot-news-img { width: 70px; height: 52px; border-radius: 6px; object-fit: cover; flex-shrink: 0; }
.hot-news-title { font-size: 13px; font-weight: 700; line-height: 1.35; color: var(--ink); display: block; }
.hot-news-title:hover { color: var(--navy); }
.hot-news-date { font-size: 11.5px; color: var(--muted); margin-top: 4px; }

.cta-widget { background: #0d3559; border-top: 3px solid #0F7F2F; color: #fff; border-radius: 8px; padding: 22px 20px; text-align: center; }
.cta-widget h3 { color: #fff; border-bottom: none; font-size: 18px; margin-bottom: 6px; padding-bottom: 0; text-transform: uppercase; font-family: 'Oswald', sans-serif; letter-spacing: 0.5px; }
.cta-widget p { font-size: 13px; color: #d1e2f3; margin: 0 0 16px; line-height: 1.5; }
.cta-btn { display: block; width: 100%; padding: 11px; background: #D9531E; color: #fff; font-weight: 700; font-size: 14px; text-transform: uppercase; border-radius: 4px; margin-bottom: 10px; text-align: center; transition: opacity 0.2s; }
.cta-btn:hover { opacity: 0.9; }
.cta-btn.alt { background: #0F7F2F; border: none; margin-bottom: 10px; }

.tag-list { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 4px; }
.tag { display: inline-block; background: #f0fdf4; border: 1px solid #d1fae5; color: var(--navy); font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }

@media(max-width: 900px) { .layout { grid-template-columns: 1fr; } .article-header { padding: 20px; } .content-panel { padding: 20px; } .article-header h1 { font-size: 24px; } .sticky { position: static; } }
@media(max-width: 768px) { .wrap { width: min(100% - 24px, 1180px); } }
</style>

<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
    $loai_bai      = get_field('loai_bai');
    if (!$loai_bai || $loai_bai === 'Tin tuc BDS') {
        $loai_bai = 'Tin tức BĐS';
    }
    $ten_tac_gia   = get_field('ten_tac_gia');
    if (!$ten_tac_gia || $ten_tac_gia === 'Ban Bien Tap BDS24H') {
        $ten_tac_gia = 'Ban Biên Tập BDS24H';
    }
    $chuyen_san    = get_field('chuyen_san');
    if (!$chuyen_san || $chuyen_san === 'Tin tuc & Phan tich BDS Cong nghiep') {
        $chuyen_san = 'Tin tức & Phân tích BĐS Công nghiệp';
    }
    $thoi_gian_doc = get_field('thoi_gian_doc');
    if (!$thoi_gian_doc || $thoi_gian_doc === '5 phut') {
        $thoi_gian_doc = '5 phút';
    }
    $luot_xem      = get_field('luot_xem')            ? get_field('luot_xem')           : '1.200';
    $nguon_url     = get_field('nguon_url')           ? get_field('nguon_url')          : 'https://khoxuongdep.com.vn/';
    $nguon_ten     = get_field('nguon_ten')           ? get_field('nguon_ten')          : 'Khoxuongdep.com.vn';

    $hero_img_url  = get_field('hero_image')          ? get_field('hero_image')         : get_the_post_thumbnail_url(get_the_ID(), 'full');
    if (!$hero_img_url) { $hero_img_url = 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/moi-gioi-kho-xuong-quang-tri-cong-ty-chuyen-768x432.png'; }
    $hero_img_caption = get_field('hero_image_caption') ? get_field('hero_image_caption') : '';
    $lead_paragraph   = get_field('lead_paragraph')  ? get_field('lead_paragraph')      : '';

    $toc_raw          = get_field('muc_luc');
    $noi_dung_acf     = get_field('noi_dung_chinh');
    $content_from_editor = get_the_content();

    // XỬ LÝ NỘI DUNG VÀ MỤC LỤC TỰ ĐỘNG
    $raw_content = $noi_dung_acf ? wpautop(wp_kses_post($noi_dung_acf)) : apply_filters('the_content', $content_from_editor);
    $toc_items   = array();
    $final_content = $raw_content;

    if (!empty($toc_raw)) {
        // Dùng mục lục nhập tay qua ACF nếu có
        $toc_lines = explode("\n", trim($toc_raw));
        foreach ($toc_lines as $line) {
            $line = trim($line); if (!$line) continue;
            $parts = explode('|', $line, 2);
            $ttl = trim($parts[0]); 
            $anc = isset($parts[1]) ? trim($parts[1]) : '#';
            $toc_items[] = array(
                'title'  => $ttl,
                'anchor' => $anc,
                'level'  => 2
            );
        }
    } else {
        // Tự động quét các thẻ Heading (h2, h3) trong nội dung
        $heading_idx = 0;
        if (preg_match('/<h[23][^>]*>/i', $raw_content)) {
            $final_content = preg_replace_callback('/<h([23])([^>]*)>(.*?)<\/h\1>/is', function($matches) use (&$toc_items, &$heading_idx) {
                $heading_idx++;
                $level = intval($matches[1]);
                $attrs = $matches[2];
                $inner = $matches[3];
                $plain_title = trim(strip_tags($inner));

                if (empty($plain_title)) {
                    return $matches[0];
                }

                if (preg_match('/id=[\'"]([^\'"]+)[\'"]/i', $attrs, $id_match)) {
                    $anchor_id = $id_match[1];
                } else {
                    $anchor_id = 'muc-luc-' . $heading_idx;
                    $attrs .= ' id="' . $anchor_id . '"';
                }

                $toc_items[] = array(
                    'title'  => $plain_title,
                    'anchor' => '#' . $anchor_id,
                    'level'  => $level
                );

                return '<h' . $level . $attrs . '>' . $inner . '</h' . $level . '>';
            }, $raw_content);
        } else {
            // Fallback: Quét các đoạn <p><strong>1. Tiêu đề...</strong></p> do AI tự động tạo
            $final_content = preg_replace_callback('/<p>\s*<strong>\s*([0-9]+[\.\:\-]\s*[^<]+)<\/strong>\s*<\/p>/iu', function($matches) use (&$toc_items, &$heading_idx) {
                $heading_idx++;
                $plain_title = trim(strip_tags($matches[1]));
                $anchor_id = 'muc-luc-' . $heading_idx;

                $toc_items[] = array(
                    'title'  => $plain_title,
                    'anchor' => '#' . $anchor_id,
                    'level'  => 2
                );

                return '<h2 id="' . $anchor_id . '">' . $plain_title . '</h2>';
            }, $raw_content);
        }
    }

    $quote_text      = get_field('quote_box')         ? get_field('quote_box')          : '';
    $highlight_title = get_field('highlight_title')   ? get_field('highlight_title')    : '';
    $highlight_text  = get_field('highlight_box')     ? get_field('highlight_box')      : '';
    $tags_raw        = get_field('the_tags')          ? get_field('the_tags')           : '';

    $bai_lien_quan = get_posts(array(
        'post_type' => array('post', 'tin-tuc'),
        'posts_per_page' => 4,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish',
    ));

    $cta_title = get_field('cta_sidebar_title');
    if (!$cta_title || $cta_title === 'Can tu van mat bang BDS?') {
        $cta_title = 'CẦN TƯ VẤN MẶT BẰNG BĐS?';
    }
    $cta_desc  = get_field('cta_sidebar_desc');
    if (!$cta_desc || $cta_desc === 'Nhan bao gia, ho so phap ly va khao sat thuc dia mien phi 24/7.') {
        $cta_desc = 'Nhận báo giá, hồ sơ pháp lý và khảo sát thực địa miễn phí 24/7.';
    }
    $hotline   = get_field('hotline');
    if (!$hotline || strpos($hotline, '0901') !== false || strpos($hotline, '626248') !== false) {
        $hotline = '0909 161 824';
    }
    $link_zalo = get_field('link_zalo');
    if (!$link_zalo || strpos($link_zalo, '0901') !== false || strpos($link_zalo, '626248') !== false) {
        $link_zalo = 'https://zalo.me/0909161824';
    }
?>

<main class="wrap news-shell">
    <nav class="crumb" aria-label="Breadcrumb">
        <a href="<?php echo home_url(); ?>">Trang chủ</a> /
        <a href="<?php echo home_url('/news-listing'); ?>">Tin tức</a> /
        <span><?php the_title(); ?></span>
    </nav>

    <article>
        <header class="article-header">
            <?php if ($loai_bai) : ?><span class="meta-tag"><?php echo esc_html($loai_bai); ?></span><?php endif; ?>
            <h1><?php the_title(); ?></h1>
            <div class="article-meta">
                <span>👤 Tác giả: <b><?php echo esc_html($ten_tac_gia); ?></b></span>
                <span>📅 Ngày đăng: <b><?php echo get_the_date('d/m/Y'); ?></b></span>
                <span>⏱️ Thời gian đọc: <b><?php echo esc_html($thoi_gian_doc); ?></b></span>
                <span>👁️ Lượt xem: <b><?php echo esc_html($luot_xem); ?></b></span>
            </div>
        </header>

        <div class="layout">
            <div class="content-panel">
                <?php if ($hero_img_url) : ?>
                <div class="hero-image">
                    <img src="<?php echo esc_url($hero_img_url); ?>" alt="<?php the_title(); ?>">
                    <?php if ($hero_img_caption) : ?><div class="hero-caption"><?php echo esc_html($hero_img_caption); ?></div><?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($lead_paragraph) : ?><p class="lead-paragraph"><?php echo esc_html($lead_paragraph); ?></p><?php endif; ?>

                <?php if (!empty($toc_items)) : ?>
                <div class="toc-box">
                    <div class="toc-title">📑 Mục lục bài viết</div>
                    <ol class="toc-list">
                        <?php foreach ($toc_items as $item) : 
                            $li_class = ($item['level'] == 3) ? ' class="toc-h3"' : '';
                        ?>
                        <li<?php echo $li_class; ?>><a href="<?php echo esc_attr($item['anchor']); ?>"><?php echo esc_html($item['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <?php endif; ?>

                <div class="article-body">
                    <?php echo $final_content; ?>
                </div>

                <?php if ($quote_text) : ?><div class="quote-box"><?php echo esc_html($quote_text); ?></div><?php endif; ?>
                <?php if ($highlight_text) : ?>
                <div class="highlight-box">
                    <?php if ($highlight_title) : ?><b><?php echo esc_html($highlight_title); ?></b><?php endif; ?>
                    <?php echo esc_html($highlight_text); ?>
                </div>
                <?php endif; ?>

                <?php if ($tags_raw) : $tags_arr = explode(',', $tags_raw); ?>
                <div class="tag-list" style="margin-top:20px;">
                    <?php foreach ($tags_arr as $tag) : $tag = trim($tag); if ($tag) : ?><span class="tag"><?php echo esc_html($tag); ?></span><?php endif; endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="author-footer" style="margin-top:32px;">
                    <div class="author-info">
                        <div class="avatar">BDS</div>
                        <div class="author-name">
                            <b><?php echo esc_html($ten_tac_gia); ?></b>
                            <span><?php echo esc_html($chuyen_san); ?></span>
                        </div>
                    </div>
                    <?php if ($nguon_url) : ?>
                    <div class="source-link">Nguồn tham khảo: <a href="<?php echo esc_url($nguon_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($nguon_ten); ?></a></div>
                    <?php endif; ?>
                </div>
            </div>

            <aside class="sticky">
                <div class="sidebar-widget cta-widget">
                    <h3><?php echo esc_html($cta_title); ?></h3>
                    <p><?php echo esc_html($cta_desc); ?></p>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>" class="cta-btn">📞 Gọi Hotline: <?php echo esc_html($hotline); ?></a>
                    <a href="<?php echo esc_url($link_zalo); ?>" target="_blank" rel="noopener" class="cta-btn alt">💬 Chat Zalo tư vấn</a>
                    <a href="https://www.facebook.com/share/18skMpo77a/?mibextid=wwXIfr" target="_blank" rel="noopener" class="cta-btn" style="background:#1877f2;color:#ffffff;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:0;"><svg width="15" height="15" viewBox="0 0 24 24" fill="#ffffff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook Fanpage</a>
                </div>

                <?php if ($bai_lien_quan) : ?>
                <div class="sidebar-widget">
                    <h3>Bài viết liên quan</h3>
                    <?php foreach ($bai_lien_quan as $related) :
                        $r_thumb = get_the_post_thumbnail_url($related->ID, 'thumbnail');
                        $r_acf   = get_post_meta($related->ID, 'hero_image', true);
                        $r_img   = $r_acf ? $r_acf : ($r_thumb ? $r_thumb : '');
                    ?>
                    <div class="hot-news-item">
                        <?php if ($r_img) : ?><img src="<?php echo esc_url($r_img); ?>" class="hot-news-img" alt="<?php echo esc_attr($related->post_title); ?>"><?php endif; ?>
                        <div>
                            <a href="<?php echo get_permalink($related->ID); ?>" class="hot-news-title"><?php echo esc_html($related->post_title); ?></a>
                            <div class="hot-news-date"><?php echo get_the_date('d/m/Y', $related->ID); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </article>
</main>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
