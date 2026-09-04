<?php
/**
 * FILE: import-kcn-from-json.php
 * MỤC ĐÍCH: Import toàn bộ KCN từ kcn_list.json lên WordPress
 *
 * CÁCH DÙNG:
 *   1. Upload file này vào thư mục theme WordPress
 *      (wp-content/themes/your-theme/import-kcn-from-json.php)
 *   2. Upload thư mục images-final/ vào cùng thư mục theme
 *   3. Mở trình duyệt: https://batdongsankhucongnghiep.vn/wp-content/themes/your-theme/import-kcn-from-json.php
 *   4. Chạy theo batch: ?batch=0, ?batch=1, ?batch=2 ...
 *   5. Xóa file sau khi hoàn tất!
 */

// ============================================================
// CẤU HÌNH — chỉnh sửa nếu cần
// ============================================================
define('BATCH_SIZE', 50);   // Số KCN xử lý mỗi lần (tránh timeout)
define('JSON_FILENAME',  'kcn_list.json');    // Tên file JSON (đặt cùng thư mục này)
define('IMAGES_DIR_NAME', 'images-final');   // Thư mục ảnh (đặt cùng thư mục này)
define('POST_TYPE',      'khu-cong-nghiep'); // Slug post type
define('PAGE_TEMPLATE',  'single-khu-cong-nghiep.php'); // Template sẽ gán

// ============================================================
// BOOTSTRAP WORDPRESS
// ============================================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@set_time_limit(300);

$current_dir = __DIR__;
$wp_load = false;
for ($i = 0; $i < 8; $i++) {
    if (file_exists($current_dir . '/wp-load.php')) {
        $wp_load = $current_dir . '/wp-load.php';
        break;
    }
    $current_dir = dirname($current_dir);
}
if (!$wp_load) {
    die('<h2 style="color:red">❌ Không tìm thấy wp-load.php. Đặt file vào thư mục theme WordPress.</h2>');
}
require_once $wp_load;

// Nạp hàm admin WP cần thiết để upload ảnh
require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

// Kiểm tra đăng nhập admin
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('<h3 style="color:red;font-family:Arial;padding:20px">⚠️ Cần đăng nhập Admin WordPress trước khi chạy script này.</h3>');
}

// ============================================================
// ĐỌC DỮ LIỆU JSON
// ============================================================
$json_path = __DIR__ . '/' . JSON_FILENAME;
if (!file_exists($json_path)) {
    die("<h2 style='color:red'>❌ Không tìm thấy file: $json_path</h2>");
}

$json_raw  = file_get_contents($json_path);
$all_items = json_decode($json_raw, true);
if (!is_array($all_items)) {
    die('<h2 style="color:red">❌ File JSON không hợp lệ hoặc bị lỗi encoding.</h2>');
}

$total      = count($all_items);
$batch      = max(0, intval($_GET['batch'] ?? 0));
$offset     = $batch * BATCH_SIZE;
$items      = array_slice($all_items, $offset, BATCH_SIZE);
$next_batch = $batch + 1;
$next_offset= $next_batch * BATCH_SIZE;

// Đường dẫn thư mục ảnh (thử cả 2 vị trí)
$images_base_dir = __DIR__ . '/' . IMAGES_DIR_NAME . '/';
if (!is_dir($images_base_dir)) {
    // Thử vị trí trong crawl script
    $images_base_dir = 'C:/Users/ACER/Downloads/python/python/crawled-kcn/images-final/';
}

// ============================================================
// HTML HEADER
// ============================================================
?><!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Import KCN — Batch <?php echo $batch + 1; ?></title>
<style>
  body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; background: #f8fafc; color: #1e293b; }
  h1 { color: #0f7f2f; border-bottom: 2px solid #0f7f2f; padding-bottom: 10px; }
  .progress-bar { background: #e2e8f0; border-radius: 8px; height: 20px; margin: 16px 0; }
  .progress-fill { background: #16c04a; height: 100%; border-radius: 8px; transition: width .3s; }
  .log { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-top: 16px; max-height: 60vh; overflow-y: auto; font-size: 13px; line-height: 1.8; }
  .ok  { color: #15803d; } .update { color: #1d4ed8; } .skip { color: #64748b; } .err { color: #dc2626; font-weight: bold; }
  .next-btn { display: inline-block; margin-top: 20px; background: #0f7f2f; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-size: 15px; font-weight: 700; }
  .done-box { background: #dcfce7; border: 1px solid #86efac; padding: 20px; border-radius: 10px; margin-top: 20px; }
  .stats { display: flex; gap: 24px; flex-wrap: wrap; margin: 16px 0; }
  .stat { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 20px; text-align: center; }
  .stat b { display: block; font-size: 26px; color: #0f7f2f; }
</style>
</head>
<body>
<h1>🚀 Import KCN từ kcn_list.json</h1>
<div class="stats">
  <div class="stat"><b><?php echo $total; ?></b> <span>Tổng KCN</span></div>
  <div class="stat"><b><?php echo $batch + 1; ?></b> <span>Batch hiện tại</span></div>
  <div class="stat"><b><?php echo $offset + 1; ?>–<?php echo min($offset + BATCH_SIZE, $total); ?></b> <span>Đang xử lý</span></div>
  <div class="stat"><b><?php echo ceil($total / BATCH_SIZE); ?></b> <span>Tổng số batch</span></div>
</div>

<div class="progress-bar">
  <div class="progress-fill" style="width:<?php echo round(($offset / $total) * 100); ?>%"></div>
</div>
<p>Tiến độ: <strong><?php echo $offset; ?> / <?php echo $total; ?></strong> (<?php echo round(($offset / $total) * 100); ?>%)</p>

<div class="log">
<?php
// ============================================================
// HÀM UPLOAD ẢNH VÀO WORDPRESS MEDIA
// ============================================================
function bds_upload_image_to_wp($image_path, $post_id, $title) {
    // Tìm file ảnh theo tên file trong cả 2 thư mục có thể có
    if (!file_exists($image_path)) {
        // Thử thư mục images-final gần script
        $alt_path = __DIR__ . '/images-final/' . basename($image_path);
        if (file_exists($alt_path)) {
            $image_path = $alt_path;
        } else {
            return false; // Không tìm thấy ảnh
        }
    }

    // Kiểm tra xem ảnh đã được upload chưa (tránh duplicate)
    $existing = get_posts([
        'post_type'   => 'attachment',
        'post_status' => 'inherit',
        'meta_key'    => '_bds_source_file',
        'meta_value'  => basename($image_path),
        'posts_per_page' => 1,
    ]);
    if (!empty($existing)) {
        return $existing[0]->ID; // Trả về ID đã tồn tại
    }

    // Upload ảnh vào WP Media Library
    $upload_dir = wp_upload_dir();
    $filename   = basename($image_path);
    $filetype   = wp_check_filetype($filename, null);

    $dest_path  = $upload_dir['path'] . '/' . $filename;
    copy($image_path, $dest_path);

    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $filename,
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_text_field($title),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment($attachment, $dest_path, $post_id);
    if (is_wp_error($attach_id)) {
        return false;
    }

    // Tạo metadata ảnh (thumbnail sizes)
    $attach_data = wp_generate_attachment_metadata($attach_id, $dest_path);
    wp_update_attachment_metadata($attach_id, $attach_data);

    // Lưu source file để tránh duplicate lần sau
    update_post_meta($attach_id, '_bds_source_file', $filename);

    return $attach_id;
}

// ============================================================
// HÀM TẠO SLUG TỪ URL NGUỒN
// ============================================================
function bds_slug_from_url($url) {
    $path = parse_url($url, PHP_URL_PATH);
    $parts = array_filter(explode('/', $path));
    return sanitize_title(end($parts));
}

// ============================================================
// HÀM LẤY TỈNH THÀNH TỪ TÊN KCN HOẶC URL
// ============================================================
function bds_guess_tinh_thanh($title, $url) {
    $provinces = [
        'long-an'       => 'Long An',       'hung-yen'     => 'Hưng Yên',
        'ha-noi'        => 'Hà Nội',        'ho-chi-minh'  => 'TP. Hồ Chí Minh',
        'binh-duong'    => 'Bình Dương',    'dong-nai'     => 'Đồng Nai',
        'ba-ria'        => 'Bà Rịa - Vũng Tàu', 'vung-tau' => 'Bà Rịa - Vũng Tàu',
        'bac-ninh'      => 'Bắc Ninh',      'hai-phong'    => 'Hải Phòng',
        'quang-ninh'    => 'Quảng Ninh',    'thai-nguyen'  => 'Thái Nguyên',
        'vinh-phuc'     => 'Vĩnh Phúc',     'bac-giang'    => 'Bắc Giang',
        'hai-duong'     => 'Hải Dương',     'phu-tho'      => 'Phú Thọ',
        'nghe-an'       => 'Nghệ An',       'ha-tinh'      => 'Hà Tĩnh',
        'quang-tri'     => 'Quảng Trị',     'da-nang'      => 'Đà Nẵng',
        'quang-nam'     => 'Quảng Nam',     'binh-dinh'    => 'Bình Định',
        'khanh-hoa'     => 'Khánh Hòa',     'lam-dong'     => 'Lâm Đồng',
        'binh-phuoc'    => 'Bình Phước',    'tay-ninh'     => 'Tây Ninh',
        'tien-giang'    => 'Tiền Giang',    'can-tho'      => 'Cần Thơ',
        'tra-vinh'      => 'Trà Vinh',      'kien-giang'   => 'Kiên Giang',
        'an-giang'      => 'An Giang',      'nam-dinh'     => 'Nam Định',
        'thai-binh'     => 'Thái Bình',     'thanh-hoa'    => 'Thanh Hóa',
        'ninh-binh'     => 'Ninh Bình',     'hoa-binh'     => 'Hòa Bình',
        'tuyen-quang'   => 'Tuyên Quang',   'lao-cai'      => 'Lào Cai',
        'phu-yen'       => 'Phú Yên',       'binh-thuan'   => 'Bình Thuận',
        'ninh-thuan'    => 'Ninh Thuận',    'dak-lak'      => 'Đắk Lắk',
        'gia-lai'       => 'Gia Lai',       'kon-tum'      => 'Kon Tum',
        'quang-ngai'    => 'Quảng Ngãi',    'thua-thien-hue' => 'Thừa Thiên Huế',
        'hue'           => 'Thừa Thiên Huế', 'hau-giang'   => 'Hậu Giang',
        'soc-trang'     => 'Sóc Trăng',     'bac-lieu'     => 'Bạc Liêu',
        'ca-mau'        => 'Cà Mau',        'ben-tre'      => 'Bến Tre',
        'dong-thap'     => 'Đồng Tháp',     'vinh-long'    => 'Vĩnh Long',
    ];
    $combined = strtolower($url . ' ' . $title);
    foreach ($provinces as $slug => $name) {
        if (strpos($combined, $slug) !== false) return $name;
    }
    return '';
}

// ============================================================
// XỬ LÝ TỪNG ITEM TRONG BATCH
// ============================================================
$created = 0;
$updated = 0;
$skipped = 0;
$errors  = 0;

foreach ($items as $item) {
    $title  = trim($item['title'] ?? '');
    $url    = trim($item['url']   ?? '');
    $images = $item['images']     ?? [];

    if (empty($title)) {
        echo "<span class='skip'>⟶ Bỏ qua: không có title</span><br>";
        $skipped++;
        continue;
    }

    // Tạo slug từ URL nguồn
    $slug = bds_slug_from_url($url);
    if (empty($slug)) {
        $slug = sanitize_title($title);
    }

    // Lấy thông tin từ fields_detected hoặc acf
    $fields = array_merge(
        (array)($item['acf']            ?? []),
        (array)($item['fields_detected'] ?? [])
    );

    $tinh_thanh = $fields['tinh_thanh'] ?? $fields['khu_vuc'] ?? bds_guess_tinh_thanh($title, $url);
    $gia        = $fields['gia']        ?? $fields['gia_thue'] ?? 'Liên hệ báo giá';
    $dien_tich  = $fields['dien_tich'] ?? '';
    $loai_hinh  = $fields['loai_hinh'] ?? 'Khu Công Nghiệp';
    $mo_ta      = $fields['mo_ta']     ?? $item['mo_ta_text'] ?? '';
    $mo_ta_html = $item['mo_ta_html']  ?? '';

    // ---- Kiểm tra đã tồn tại chưa ----
    $existing_query = new WP_Query([
        'name'           => $slug,
        'post_type'      => [POST_TYPE, 'post'],
        'post_status'    => 'any',
        'posts_per_page' => 1,
    ]);

    $post_id = 0;
    $is_new  = false;

    if ($existing_query->have_posts()) {
        $existing_query->the_post();
        $post_id = get_the_ID();
        wp_reset_postdata();

        // Cập nhật nội dung nếu có mo_ta mới
        if ($mo_ta_html || $mo_ta) {
            wp_update_post([
                'ID'           => $post_id,
                'post_content' => $mo_ta_html ?: $mo_ta,
            ]);
        }
        $updated++;
        echo "<span class='update'>🔄 Cập nhật: <strong>$title</strong> (ID: $post_id)</span><br>";
    } else {
        // Tạo mới
        $post_data = [
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => POST_TYPE,
            'post_content' => $mo_ta_html ?: $mo_ta,
        ];

        $post_id = wp_insert_post($post_data, true);
        if (is_wp_error($post_id)) {
            echo "<span class='err'>❌ Lỗi tạo post: $title — " . $post_id->get_error_message() . "</span><br>";
            $errors++;
            continue;
        }
        $is_new = true;
        $created++;
        echo "<span class='ok'>✅ Tạo mới: <strong>$title</strong> (ID: $post_id, slug: $slug)</span><br>";
    }

    // ---- Gán template ----
    update_post_meta($post_id, '_wp_page_template', PAGE_TEMPLATE);

    // ---- Lưu ACF fields — dùng cùng bộ field với single-product.php ----
    $meta_to_save = [
        // Fields dùng trong single-product.php
        'ma_tin'          => 'KCN-' . $post_id,
        'dien_tich'       => $dien_tich,
        'gia'             => $gia,
        'loai_hinh'       => $loai_hinh,
        'khu_vuc'         => $tinh_thanh,
        'mo_ta_chi_tiet'  => $mo_ta,
        'tien_ich'        => $fields['nganh_nghe'] ?? $fields['nganh_nghe_thu_hut'] ?? '',

        // Fields mở rộng cho KCN (dùng trong single-khu-cong-nghiep.php)
        'vi_tri'          => $fields['vi_tri']          ?? $tinh_thanh,
        'tinh_thanh'      => $tinh_thanh,
        'trang_thai'      => $fields['trang_thai']       ?? 'ĐANG HOẠT ĐỘNG',
        'gia_thue'        => $gia,
        'don_vi_tinh'     => $fields['don_vi_tinh']      ?? 'Giá tham khảo',
        'chu_dau_tu'      => $fields['chu_dau_tu']       ?? '',
        'nganh_nghe_thu_hut' => $fields['nganh_nghe_thu_hut'] ?? $fields['nganh_nghe'] ?? '',
        'ht_dien'         => $fields['ht_dien']          ?? '',
        'ht_nuoc_sach'    => $fields['ht_nuoc_sach']     ?? '',
        'ht_nuoc_thai'    => $fields['ht_nuoc_thai']     ?? '',
        'ht_vien_thong'   => $fields['ht_vien_thong']    ?? '',
        'ht_duong_bo'     => $fields['ht_duong_bo']      ?? '',
        'ht_duong_thuy'   => $fields['ht_duong_thuy']    ?? '',
        'fact_cang_bien'  => $fields['fact_cang_bien']   ?? '',
        'fact_nuoc_thai'  => $fields['fact_nuoc_thai']   ?? '',
        'phi_quan_ly'     => $fields['phi_quan_ly']      ?? '',
        'gia_dien'        => $fields['gia_dien']         ?? '',
        'gia_nuoc'        => $fields['gia_nuoc']         ?? '',
        'phi_xuly_nuocthai' => $fields['phi_xuly_nuocthai'] ?? '',
        'uu_dai_thue'     => $fields['uu_dai_thue']      ?? '',
        'ten_logistics_1' => $fields['ten_logistics_1']  ?? '',
        'logistics_cang_longan'    => $fields['logistics_cang_longan']    ?? '',
        'ten_logistics_2' => $fields['ten_logistics_2']  ?? '',
        'logistics_cang_hiepphuoc' => $fields['logistics_cang_hiepphuoc'] ?? '',
        'ten_logistics_3' => $fields['ten_logistics_3']  ?? '',
        'logistics_san_bay'        => $fields['logistics_san_bay']        ?? '',
        'ten_logistics_4' => $fields['ten_logistics_4']  ?? '',
        'logistics_truc_giao_thong'=> $fields['logistics_truc_giao_thong']?? '',
        'google_map_embed'=> $fields['google_map_embed'] ?? '',
        'hotline'         => '0909 161 824',
        'link_zalo'       => 'https://zalo.me/0909161824',
        // Lưu URL nguồn để tham chiếu
        '_bds_source_url' => $url,
        '_bds_source_id'  => $item['id'] ?? '',
    ];

    foreach ($meta_to_save as $key => $val) {
        if ($val !== '') {
            update_post_meta($post_id, $key, $val);
            // Sync sang ACF nếu có plugin
            if (function_exists('update_field')) {
                update_field($key, $val, $post_id);
            }
        }
    }

    // ---- Upload ảnh & gán Featured Image ----
    if (!empty($images)) {
        $thumbnail_set = false;

        foreach ($images as $idx => $img_path) {
            // Chuẩn hóa đường dẫn (JSON có thể dùng \ hoặc /)
            $img_path = str_replace('\\', '/', $img_path);
            $basename = basename($img_path);

            // Thử đường dẫn gốc trong JSON, rồi thử images-final gần script
            $try_paths = [
                $img_path,
                __DIR__ . '/images-final/' . $basename,
                'C:/Users/ACER/Downloads/Anxemer/images-final/' . $basename,
                'C:/Users/ACER/Downloads/python/python/crawled-kcn/images-final/' . $basename,
            ];

            $real_path = null;
            foreach ($try_paths as $tp) {
                if (file_exists($tp)) {
                    $real_path = $tp;
                    break;
                }
            }

            if (!$real_path) {
                echo "&nbsp;&nbsp;&nbsp;<span class='skip'>⟶ Không tìm thấy ảnh: $basename</span><br>";
                continue;
            }

            $attach_id = bds_upload_image_to_wp($real_path, $post_id, $title . ' - ảnh ' . ($idx + 1));
            if ($attach_id) {
                // Ảnh đầu tiên → Featured Image (thumbnail)
                if (!$thumbnail_set) {
                    set_post_thumbnail($post_id, $attach_id);
                    $thumbnail_set = true;
                    echo "&nbsp;&nbsp;&nbsp;<span class='ok'>📷 Featured image đã gán: $basename</span><br>";
                } else {
                    echo "&nbsp;&nbsp;&nbsp;<span class='skip'>🖼️ Ảnh thêm: $basename (ID: $attach_id)</span><br>";
                }

                // Lưu ID ảnh đầu vào meta anh_quy_hoach (dùng trong single-khu-cong-nghiep)
                if ($idx === 0) {
                    update_post_meta($post_id, 'anh_quy_hoach', wp_get_attachment_url($attach_id));
                }
                if ($idx === 1) {
                    update_post_meta($post_id, 'anh_ha_tang', wp_get_attachment_url($attach_id));
                }

                // Thêm vào gallery_anh (ACF Gallery field)
                $existing_gallery = get_post_meta($post_id, 'gallery_anh', true);
                if (!is_array($existing_gallery)) $existing_gallery = [];
                if (!in_array($attach_id, $existing_gallery)) {
                    $existing_gallery[] = $attach_id;
                    update_post_meta($post_id, 'gallery_anh', $existing_gallery);
                }
            } else {
                echo "&nbsp;&nbsp;&nbsp;<span class='err'>❌ Upload thất bại: $basename</span><br>";
            }
        }
    } else {
        echo "&nbsp;&nbsp;&nbsp;<span class='skip'>⟶ Không có ảnh</span><br>";
    }

    echo "<hr style='margin:4px 0; border-color:#f1f5f9'>";
    flush();
    ob_flush();
}

// ============================================================
// KẾT QUẢ
// ============================================================
?>
</div>

<div style="margin-top:20px; background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:20px;">
  <h3 style="color:#0f7f2f; margin:0 0 12px;">📊 Kết quả batch <?php echo $batch + 1; ?></h3>
  <p>✅ Tạo mới: <strong><?php echo $created; ?></strong> &nbsp;&nbsp;
     🔄 Cập nhật: <strong><?php echo $updated; ?></strong> &nbsp;&nbsp;
     ⟶ Bỏ qua: <strong><?php echo $skipped; ?></strong> &nbsp;&nbsp;
     ❌ Lỗi: <strong><?php echo $errors; ?></strong></p>
</div>

<?php if ($next_offset < $total): ?>
<a class="next-btn" href="?batch=<?php echo $next_batch; ?>">
  ▶ Tiếp tục Batch <?php echo $next_batch + 1; ?> (<?php echo $next_offset + 1; ?>–<?php echo min($next_offset + BATCH_SIZE, $total); ?> / <?php echo $total; ?>) →
</a>
<p style="color:#64748b; font-size:13px; margin-top:8px;">Hoặc nhấn nút trên để tự động chuyển sang batch tiếp theo</p>
<script>
// Tự động chuyển batch sau 3 giây
var countdown = 3;
var el = document.createElement('p');
el.style = 'color:#0f7f2f; font-weight:bold; font-size:15px;';
document.body.appendChild(el);
var t = setInterval(function() {
  el.textContent = '⏱ Tự động chuyển batch tiếp theo sau ' + countdown + ' giây...';
  if (--countdown < 0) {
    clearInterval(t);
    window.location.href = '?batch=<?php echo $next_batch; ?>';
  }
}, 1000);
</script>
<?php else: ?>
<div class="done-box">
  <h2 style="color:#15803d; margin:0 0 10px;">🎉 HOÀN THÀNH! Đã import toàn bộ <?php echo $total; ?> KCN!</h2>
  <p>Vào <strong>WordPress Admin → Khu Công Nghiệp</strong> để kiểm tra.</p>
  <p>Sau đó vào <strong>Settings → Permalinks → Save Changes</strong> để flush rewrite rules.</p>
  <p style="color:#dc2626; font-weight:bold;">⚠️ Hãy XÓA file <code>import-kcn-from-json.php</code> này ngay sau khi hoàn tất!</p>
</div>
<?php endif; ?>

</body>
</html>
