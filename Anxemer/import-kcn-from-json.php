<?php
/**
 * FILE: import-kcn-from-json.php
 * MỤC ĐÍCH: Import toàn bộ KCN từ kcn_list.json lên WordPress
 *
 * CÁCH DÙNG:
 *   1. Upload file này + thư mục images-final/ vào thư mục theme WordPress
 *      (wp-content/themes/your-theme/)
 *   2. Mở trình duyệt: https://batdongsankhucongnghiep.vn/wp-content/themes/your-theme/import-kcn-from-json.php
 *   3. Chạy theo batch tự động: ?batch=0, ?batch=1 ...
 *   4. XÓA file sau khi hoàn tất!
 */

define('BATCH_SIZE',     50);
define('JSON_FILENAME',  'kcn_list.json');
define('IMAGES_DIR_NAME','images-final');
define('POST_TYPE',      'khu-cong-nghiep');
define('PAGE_TEMPLATE',  'single-khu-cong-nghiep.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@set_time_limit(300);

// Bootstrap WordPress
$current_dir = __DIR__;
$wp_load = false;
for ($i = 0; $i < 8; $i++) {
    if (file_exists($current_dir . '/wp-load.php')) { $wp_load = $current_dir . '/wp-load.php'; break; }
    $current_dir = dirname($current_dir);
}
if (!$wp_load) die('<h2 style="color:red">❌ Không tìm thấy wp-load.php.</h2>');
require_once $wp_load;
require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('<h3 style="color:red;font-family:Arial;padding:20px">⚠️ Cần đăng nhập Admin WordPress trước.</h3>');
}

// Đọc JSON
$json_path = __DIR__ . '/' . JSON_FILENAME;
if (!file_exists($json_path)) die("<h2 style='color:red'>❌ Không tìm thấy: $json_path</h2>");
$all_items = json_decode(file_get_contents($json_path), true);
if (!is_array($all_items)) die('<h2 style="color:red">❌ File JSON không hợp lệ.</h2>');

$total      = count($all_items);
$batch      = max(0, intval($_GET['batch'] ?? 0));
$offset     = $batch * BATCH_SIZE;
$items      = array_slice($all_items, $offset, BATCH_SIZE);
$next_batch = $batch + 1;
$next_offset= $next_batch * BATCH_SIZE;
?><!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Import KCN — Batch <?php echo $batch+1; ?></title>
<style>
body{font-family:Arial,sans-serif;max-width:960px;margin:40px auto;padding:0 20px;background:#f8fafc;color:#1e293b}
h1{color:#0f7f2f;border-bottom:2px solid #0f7f2f;padding-bottom:10px}
.stats{display:flex;gap:16px;flex-wrap:wrap;margin:16px 0}
.stat{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:10px 18px;text-align:center}
.stat b{display:block;font-size:24px;color:#0f7f2f}
.progress-bar{background:#e2e8f0;border-radius:8px;height:18px;margin:12px 0}
.progress-fill{background:linear-gradient(90deg,#16c04a,#0f7f2f);height:100%;border-radius:8px}
.log{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:14px;margin-top:14px;max-height:58vh;overflow-y:auto;font-size:12.5px;line-height:1.9}
.ok{color:#15803d}.update{color:#1d4ed8}.skip{color:#64748b}.err{color:#dc2626;font-weight:bold}
.next-btn{display:inline-block;margin-top:20px;background:#0f7f2f;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-size:15px;font-weight:700}
.done-box{background:#dcfce7;border:1px solid #86efac;padding:20px;border-radius:10px;margin-top:20px}
</style>
</head>
<body>
<h1>🚀 Import KCN từ kcn_list.json</h1>
<div class="stats">
  <div class="stat"><b><?php echo $total; ?></b>Tổng KCN</div>
  <div class="stat"><b><?php echo $batch+1; ?></b>Batch hiện tại</div>
  <div class="stat"><b><?php echo $offset+1; ?>–<?php echo min($offset+BATCH_SIZE,$total); ?></b>Đang xử lý</div>
  <div class="stat"><b><?php echo ceil($total/BATCH_SIZE); ?></b>Tổng batch</div>
</div>
<div class="progress-bar"><div class="progress-fill" style="width:<?php echo round(($offset/$total)*100); ?>%"></div></div>
<p>Tiến độ: <strong><?php echo $offset; ?> / <?php echo $total; ?></strong> (<?php echo round(($offset/$total)*100); ?>%)</p>
<div class="log">
<?php

// ====== HÀM UPLOAD ẢNH ======
function bds_upload_image($img_path, $post_id, $title) {
    // Chuẩn hóa đường dẫn
    $img_path = str_replace('\\', '/', $img_path);
    $basename = basename($img_path);

    // Thử các đường dẫn có thể có
    $candidates = [
        $img_path,
        __DIR__ . '/images-final/' . $basename,
        'C:/Users/ACER/Downloads/Anxemer/images-final/' . $basename,
        'C:/Users/ACER/Downloads/python/python/crawled-kcn/images-final/' . $basename,
    ];
    $real = null;
    foreach ($candidates as $c) { if (file_exists($c)) { $real = $c; break; } }
    if (!$real) return false;

    // Kiểm tra đã upload chưa (tránh duplicate)
    global $wpdb;
    $existing_id = $wpdb->get_var(
        $wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_bds_src_file' AND meta_value=%s LIMIT 1", $basename)
    );
    if ($existing_id) return (int)$existing_id;

    // Upload
    $upload = wp_upload_dir();
    $dest   = $upload['path'] . '/' . $basename;
    if (!copy($real, $dest)) return false;

    $ft  = wp_check_filetype($basename, null);
    $aid = wp_insert_attachment([
        'guid'           => $upload['url'] . '/' . $basename,
        'post_mime_type' => $ft['type'],
        'post_title'     => sanitize_text_field($title),
        'post_status'    => 'inherit',
    ], $dest, $post_id);

    if (is_wp_error($aid)) return false;
    wp_update_attachment_metadata($aid, wp_generate_attachment_metadata($aid, $dest));
    update_post_meta($aid, '_bds_src_file', $basename);
    return $aid;
}

// ====== HÀM ĐoÁN TỈNH THÀNH ======
function bds_tinh_thanh($title, $url) {
    $map = [
        'long-an'=>'Long An','binh-duong'=>'Bình Dương','dong-nai'=>'Đồng Nai',
        'ba-ria'=>'Bà Rịa - Vũng Tàu','vung-tau'=>'Bà Rịa - Vũng Tàu',
        'bac-ninh'=>'Bắc Ninh','hai-phong'=>'Hải Phòng','ha-noi'=>'Hà Nội',
        'ho-chi-minh'=>'TP. Hồ Chí Minh','quang-ninh'=>'Quảng Ninh',
        'thai-nguyen'=>'Thái Nguyên','vinh-phuc'=>'Vĩnh Phúc','bac-giang'=>'Bắc Giang',
        'hai-duong'=>'Hải Dương','phu-tho'=>'Phú Thọ','nghe-an'=>'Nghệ An',
        'ha-tinh'=>'Hà Tĩnh','quang-tri'=>'Quảng Trị','da-nang'=>'Đà Nẵng',
        'quang-nam'=>'Quảng Nam','binh-dinh'=>'Bình Định','khanh-hoa'=>'Khánh Hòa',
        'lam-dong'=>'Lâm Đồng','binh-phuoc'=>'Bình Phước','tay-ninh'=>'Tây Ninh',
        'tien-giang'=>'Tiền Giang','can-tho'=>'Cần Thơ','kien-giang'=>'Kiên Giang',
        'an-giang'=>'An Giang','nam-dinh'=>'Nam Định','thai-binh'=>'Thái Bình',
        'thanh-hoa'=>'Thanh Hóa','ninh-binh'=>'Ninh Bình','hoa-binh'=>'Hòa Bình',
        'quang-ngai'=>'Quảng Ngãi','hung-yen'=>'Hưng Yên','hue'=>'Thừa Thiên Huế',
        'thua-thien'=>'Thừa Thiên Huế','binh-thuan'=>'Bình Thuận','phu-yen'=>'Phú Yên',
        'ninh-thuan'=>'Ninh Thuận','dak-lak'=>'Đắk Lắk','gia-lai'=>'Gia Lai',
    ];
    $hay = strtolower($url . ' ' . $title);
    foreach ($map as $k=>$v) { if (strpos($hay,$k)!==false) return $v; }
    return '';
}

// ====== XỬ LÝ BATCH ======
$created=$updated=$skipped=$errors=0;

foreach ($items as $item) {
    $title  = trim($item['title'] ?? '');
    $url    = trim($item['url']   ?? '');
    $images = $item['images']     ?? [];
    if (empty($title)) { echo "<span class='skip'>⟶ Bỏ qua: không có title</span><br>"; $skipped++; continue; }

    // Slug từ URL nguồn
    $path_parts = array_filter(explode('/', parse_url($url, PHP_URL_PATH)));
    $slug = sanitize_title(end($path_parts) ?: $title);

    // Fields
    $f = array_merge((array)($item['acf']??[]), (array)($item['fields_detected']??[]));
    $tinh_thanh = $f['tinh_thanh'] ?? $f['khu_vuc'] ?? bds_tinh_thanh($title, $url);
    $gia        = $f['gia']        ?? $f['gia_thue'] ?? 'Liên hệ báo giá';
    $dien_tich  = $f['dien_tich'] ?? '';
    $loai_hinh  = $f['loai_hinh'] ?? 'Khu Công Nghiệp';
    $mo_ta      = $item['mo_ta_html'] ?: ($item['mo_ta_text'] ?? '');

    // Kiểm tra tồn tại
    $eq = new WP_Query(['name'=>$slug,'post_type'=>[POST_TYPE,'post'],'post_status'=>'any','posts_per_page'=>1]);
    $post_id = 0;
    if ($eq->have_posts()) {
        $eq->the_post(); $post_id = get_the_ID(); wp_reset_postdata();
        if ($mo_ta) wp_update_post(['ID'=>$post_id,'post_content'=>$mo_ta]);
        $updated++;
        echo "<span class='update'>🔄 Cập nhật: <strong>".esc_html($title)."</strong> (ID:$post_id)</span><br>";
    } else {
        $post_id = wp_insert_post(['post_title'=>$title,'post_name'=>$slug,'post_status'=>'publish','post_type'=>POST_TYPE,'post_content'=>$mo_ta], true);
        if (is_wp_error($post_id)) { echo "<span class='err'>❌ Lỗi: ".esc_html($title)." — ".$post_id->get_error_message()."</span><br>"; $errors++; continue; }
        $created++;
        echo "<span class='ok'>✅ Tạo mới: <strong>".esc_html($title)."</strong> (ID:$post_id)</span><br>";
    }

    // Template
    update_post_meta($post_id, '_wp_page_template', PAGE_TEMPLATE);

    // ACF fields — dùng chung cho single-product.php VÀ single-khu-cong-nghiep.php
    $metas = [
        // === Dùng trong single-product.php ===
        'ma_tin'            => 'KCN-'.$post_id,
        'dien_tich'         => $dien_tich,
        'gia'               => $gia,
        'loai_hinh'         => $loai_hinh,
        'khu_vuc'           => $tinh_thanh,
        'tien_ich'          => $f['nganh_nghe'] ?? $f['nganh_nghe_thu_hut'] ?? '',
        'mo_ta_chi_tiet'    => $item['mo_ta_text'] ?? '',

        // === Dùng trong single-khu-cong-nghiep.php ===
        'vi_tri'            => $f['vi_tri']          ?? $tinh_thanh,
        'tinh_thanh'        => $tinh_thanh,
        'trang_thai'        => $f['trang_thai']       ?? 'ĐANG HOẠT ĐỘNG',
        'gia_thue'          => $gia,
        'don_vi_tinh'       => $f['don_vi_tinh']      ?? 'Giá tham khảo',
        'chu_dau_tu'        => $f['chu_dau_tu']       ?? '',
        'nganh_nghe_thu_hut'=> $f['nganh_nghe_thu_hut'] ?? $f['nganh_nghe'] ?? '',
        'ht_dien'           => $f['ht_dien']          ?? '',
        'ht_nuoc_sach'      => $f['ht_nuoc_sach']     ?? '',
        'ht_nuoc_thai'      => $f['ht_nuoc_thai']     ?? '',
        'ht_vien_thong'     => $f['ht_vien_thong']    ?? '',
        'ht_duong_bo'       => $f['ht_duong_bo']      ?? '',
        'ht_duong_thuy'     => $f['ht_duong_thuy']    ?? '',
        'fact_cang_bien'    => $f['fact_cang_bien']   ?? '',
        'fact_nuoc_thai'    => $f['fact_nuoc_thai']   ?? '',
        'phi_quan_ly'       => $f['phi_quan_ly']      ?? '',
        'gia_dien'          => $f['gia_dien']         ?? '',
        'gia_nuoc'          => $f['gia_nuoc']         ?? '',
        'phi_xuly_nuocthai' => $f['phi_xuly_nuocthai']?? '',
        'uu_dai_thue'       => $f['uu_dai_thue']      ?? '',
        'ten_logistics_1'   => $f['ten_logistics_1']  ?? '',
        'logistics_cang_longan'    => $f['logistics_cang_longan']    ?? '',
        'ten_logistics_2'   => $f['ten_logistics_2']  ?? '',
        'logistics_cang_hiepphuoc' => $f['logistics_cang_hiepphuoc'] ?? '',
        'ten_logistics_3'   => $f['ten_logistics_3']  ?? '',
        'logistics_san_bay' => $f['logistics_san_bay']?? '',
        'ten_logistics_4'   => $f['ten_logistics_4']  ?? '',
        'logistics_truc_giao_thong'=> $f['logistics_truc_giao_thong']??'',
        'google_map_embed'  => $f['google_map_embed'] ?? '',
        'hotline'           => '0909 161 824',
        'link_zalo'         => 'https://zalo.me/0909161824',
        '_bds_source_url'   => $url,
        '_bds_source_id'    => $item['id'] ?? '',
    ];

    foreach ($metas as $k=>$v) {
        if ($v !== '') {
            update_post_meta($post_id, $k, $v);
            if (function_exists('update_field')) update_field($k, $v, $post_id);
        }
    }

    // Upload & gán ảnh: Ảnh 1 = Featured Image, toàn bộ ảnh còn lại = _kcn_gallery_ids (KHÔNG GIỚI HẠN)
    if (!empty($images)) {
        $gallery_ids = array();
        foreach ($images as $idx=>$img) {
            $aid = bds_upload_image($img, $post_id, $title.' - '.($idx+1));
            if ($aid) {
                if ($idx === 0) {
                    // Ảnh đầu tiên → Featured Image (native WP)
                    set_post_thumbnail($post_id, $aid);
                    echo "&nbsp;&nbsp;&nbsp;<span class='ok'>📷 Featured Image: ".basename($img)."</span><br>";
                } else {
                    // Toàn bộ ảnh thứ 2, 3, 4... bất kể bao nhiêu ảnh → Thư viện Gallery
                    $gallery_ids[] = $aid;
                    echo "&nbsp;&nbsp;&nbsp;<span class='skip'>🖼️ Gallery (#".($idx+1)."): ".basename($img)."</span><br>";
                }
            } else {
                echo "&nbsp;&nbsp;&nbsp;<span class='skip'>⟶ Không tìm thấy: ".basename($img)."</span><br>";
            }
        }
        // Lưu toàn bộ danh sách ID ảnh vào metabox Native Gallery
        if (!empty($gallery_ids)) {
            update_post_meta($post_id, '_kcn_gallery_ids', implode(',', $gallery_ids));
        }
    } else {
        echo "&nbsp;&nbsp;&nbsp;<span class='skip'>⟶ Không có ảnh</span><br>";
    }


    echo "<hr style='margin:4px 0;border-color:#f1f5f9'>";
    flush(); ob_flush();
}
?>
</div>

<div style="margin-top:18px;background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:16px;">
  <strong>📊 Batch <?php echo $batch+1; ?>:</strong>
  ✅ Tạo mới: <strong><?php echo $created; ?></strong> &nbsp;
  🔄 Cập nhật: <strong><?php echo $updated; ?></strong> &nbsp;
  ⟶ Bỏ qua: <strong><?php echo $skipped; ?></strong> &nbsp;
  ❌ Lỗi: <strong><?php echo $errors; ?></strong>
</div>

<?php if ($next_offset < $total): ?>
<a class="next-btn" href="?batch=<?php echo $next_batch; ?>">
  ▶ Batch <?php echo $next_batch+1; ?> (<?php echo $next_offset+1; ?>–<?php echo min($next_offset+BATCH_SIZE,$total); ?> / <?php echo $total; ?>) →
</a>
<script>
var s=3,el=document.createElement('p');
el.style='color:#0f7f2f;font-weight:700;font-size:14px;margin-top:8px';
document.body.appendChild(el);
var t=setInterval(function(){
  el.textContent='⏱ Tự động chạy tiếp sau '+s+' giây...';
  if(--s<0){clearInterval(t);location.href='?batch=<?php echo $next_batch; ?>';}
},1000);
</script>
<?php else: ?>
<div class="done-box">
  <h2 style="color:#15803d;margin:0 0 8px">🎉 HOÀN THÀNH! Đã xử lý <?php echo $total; ?> KCN</h2>
  <ol style="margin:10px 0;padding-left:20px;line-height:2">
    <li>Vào <strong>WP Admin → Settings → Permalinks → Save Changes</strong> (flush rewrite)</li>
    <li>Kiểm tra <strong>WP Admin → Khu Công Nghiệp</strong></li>
    <li style="color:#dc2626;font-weight:bold">⚠️ XÓA FILE <code>import-kcn-from-json.php</code> NGAY!</li>
  </ol>
</div>
<?php endif; ?>
</body></html>
