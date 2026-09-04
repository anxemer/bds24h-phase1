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

// Lấy dữ liệu — dùng bộ field ĐƠN GIẢN, khớp đúng với "fields_detected" mà
// crawl_kcn.py thực tế trích xuất được (không phải bộ field chi tiết cũ như
// phí điện/nước/hạ tầng riêng lẻ — crawler hiện chưa tách được các số liệu đó).
$khu_vuc = get_field('khu_vuc') ? get_field('khu_vuc') : 'Đang cập nhật';
$vi_tri = $khu_vuc;
$trang_thai = 'ĐANG HOẠT ĐỘNG'; // chưa có nguồn dữ liệu riêng, để mặc định
$gia_thue = get_field('gia') ? get_field('gia') : 'Liên hệ báo giá';
$don_vi_tinh = 'Giá tham khảo';
$chu_dau_tu = get_field('chu_dau_tu') ? get_field('chu_dau_tu') : '';
$dien_tich = get_field('dien_tich') ? get_field('dien_tich') : '';
$ty_le_lap_day = get_field('ty_le_lap_day') ? get_field('ty_le_lap_day') : '';
$nganh_nghe_text = get_field('nganh_nghe') ? get_field('nganh_nghe') : '';
$ha_tang_text = get_field('ha_tang') ? get_field('ha_tang') : ''; // mô tả hạ tầng dạng đoạn văn, KHÔNG tách riêng điện/nước/viễn thông như bản cũ

// Ảnh — dùng gallery đầy đủ (field "gallery_anh") thay vì 3 vị trí cố định
// (ảnh chính/quy hoạch/hạ tầng) như bản cũ, vì crawler không phân loại được
// ảnh nào là quy hoạch/hạ tầng riêng biệt.
$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (!$thumb_url) {
$thumb_url = 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg';
}
$gallery_images = get_field('gallery_anh');
if (!is_array($gallery_images)) {
$gallery_images = array();
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
<div class="gallery">
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
