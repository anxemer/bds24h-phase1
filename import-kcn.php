<?php
/**
 * TÊN FILE: import-kcn.php
 * MỤC ĐÍCH: TỰ ĐỘNG TẠO TOÀN BỘ 14 BÀI VIẾT KHU CÔNG NGHIỆP TRONG 2 GIÂY (FIXED WP ADMIN INCLUDES)
 */

// Bật hiển thị lỗi để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// TỰ ĐỘNG TÌM FILE wp-load.php DÙ ĐẶT Ở BẤT KỲ THƯ MỤC NÀO
$current_dir = __DIR__;
$wp_load_path = false;

for ($i = 0; $i < 6; $i++) {
    if (file_exists($current_dir . '/wp-load.php')) {
        $wp_load_path = $current_dir . '/wp-load.php';
        break;
    }
    $current_dir = dirname($current_dir);
}

if ($wp_load_path) {
    require_once($wp_load_path);
} else {
    die('<h2 style="color:red;">❌ Không tìm thấy file wp-load.php. Vui lòng đặt file import-kcn.php vào thư mục theme hoặc thư mục gốc WordPress.</h2>');
}

// NẠP CÁC FILE CHỨC NĂNG ADMIN CẦN THIẾT CỦA WORDPRESS
if (defined('ABSPATH')) {
    require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');
    require_once(ABSPATH . 'wp-admin/includes/post.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
}

// Kiểm tra quyền Admin
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('<h3 style="color:red; font-family:Arial; padding:20px;">⚠️ Bạn cần ĐĂNG NHẬP tài khoản Admin WordPress trước khi truy cập đường dẫn này.</h3>');
}

// Danh sách 14 Khu công nghiệp chuẩn 100% detail.html
$kcn_list = array(
    array(
        'title' => 'KCN Cầu Cảng Phước Đông',
        'slug'  => 'kcn-cau-cang-phuoc-dong',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg',
        'fields' => array(
            'tinh_thanh' => 'Long An',
            'vi_tri' => 'Cần Giuộc, Long An · liền kề đường tỉnh 826B và sông Vàm Cỏ',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$142 – $163/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'Công ty Cổ phần IMG Phước Đông (IPD)',
            'mo_ta_hinh_thuc_thue' => 'Hình thức thuê gồm đất trống, nhà xưởng xây sẵn hoặc nhà xưởng thiết kế theo yêu cầu.',
            'fact_cang_bien' => '19 km đến cảng quốc tế Long An',
            'fact_nuoc_thai' => '3.000 m³/ngày',
            'ht_dien' => '110/22KV · công suất 63MW',
            'ht_nuoc_sach' => '5.000 m³/ngày · ống 110–315mm',
            'ht_nuoc_thai' => '3.000 m³/ngày · xử lý đạt cột A',
            'ht_vien_thong' => 'Kết nối mạng khu vực Cần Đước',
            'ht_duong_bo' => 'Liền kề tỉnh lộ 826B',
            'ht_duong_thuy' => 'Sông Vàm Cỏ · quy hoạch cảng',
            'ten_logistics_1' => 'Cảng quốc tế Long An',
            'logistics_cang_longan' => 'Khoảng 19km, thuận lợi xuất nhập hàng đường thủy.',
            'ten_logistics_2' => 'Cảng Hiệp Phước',
            'logistics_cang_hiepphuoc' => 'Khoảng 30km, kết nối trực tiếp khu vực TP.HCM.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Khoảng 42km, phù hợp vận chuyển chuyên gia và hàng hóa.',
            'ten_logistics_4' => 'Trục giao thông',
            'logistics_truc_giao_thong' => 'Tiếp cận tỉnh lộ 826B và mạng lưới vận tải đường bộ phía Nam.',
            'nganh_nghe_thu_hut' => 'Cơ khí chế tạo, Điện tử & viễn thông, Hóa chất & dược phẩm, Dệt may & giày dép, Nông sản & thực phẩm, Nội thất & vật liệu xây dựng, Công nghiệp hỗ trợ, Kho vận logistics',
            'phi_quan_ly' => '0,035 USD/m²/tháng.',
            'gia_dien' => 'Bình thường 1.453đ/kWh · thấp điểm 934đ/kWh · cao điểm 2.637đ/kWh',
            'gia_nuoc' => 'Khoảng 3.200đ/m³',
            'phi_xuly_nuocthai' => '0,35 USD/m³, tính 80% nước đầu vào',
            'uu_dai_thue' => 'Miễn thuế TNDN trong 2 năm đầu và giảm 50% trong 4 năm tiếp theo.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/ban-do-kcn-phuoc-dong-cau-cang-long-an.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/hinh-anh-kcn-phuoc-dong.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.589,106.55&z=13&output=embed"></iframe>',
            'hotline' => '0909161824',
            'link_zalo' => 'https://zalo.me/0909161824'
        )
    ),
    array(
        'title' => 'KCN Hựu Thạnh (IDICO)',
        'slug'  => 'kcn-huu-thanh-idico',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-huu-thanh-long-an.jpg',
        'fields' => array(
            'tinh_thanh' => 'Long An',
            'vi_tri' => 'Đức Hòa, Long An · vùng sản xuất phía Tây TP.HCM',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$158 – $163/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'IDICO Corporation',
            'mo_ta_hinh_thuc_thue' => 'Diện tích cho thuê tối thiểu từ 1 ha.',
            'fact_cang_bien' => '52 km đến cảng Long An',
            'fact_nuoc_thai' => '14.400 m³/ngày',
            'ht_dien' => 'Trạm biến áp 22KV',
            'ht_nuoc_sach' => '20.000 m³/ngày',
            'ht_nuoc_thai' => '14.400 m³/ngày',
            'ht_vien_thong' => 'Mạng viễn thông đồng bộ',
            'ht_duong_bo' => 'Kết nối vùng sản xuất phía Tây TP.HCM',
            'ht_duong_thuy' => 'Cách Cảng Long An khoảng 52km',
            'ten_logistics_1' => 'Cảng quốc tế Long An',
            'logistics_cang_longan' => 'Cách Cảng Long An khoảng 52km.',
            'ten_logistics_2' => 'Trục Vành Đai',
            'logistics_cang_hiepphuoc' => 'Kết nối trực tiếp trục giao thông miền Tây.',
            'ten_logistics_3' => 'Sân bay / TP. Tân An',
            'logistics_san_bay' => 'Cách Tân An 35km.',
            'ten_logistics_4' => 'Giao thông vùng',
            'logistics_truc_giao_thong' => 'Kết nối giao thương TP.HCM và Đồng bằng sông Cửu Long.',
            'nganh_nghe_thu_hut' => 'Điện tử, Cơ khí, Dược phẩm, Thực phẩm, Bao bì, Công nghệ cao & R&D, Logistics',
            'phi_quan_ly' => 'Theo quy định CĐT IDICO.',
            'gia_dien' => 'Áp dụng giá điện sản xuất của EVN.',
            'gia_nuoc' => 'Áp dụng giá nước sạch KCN.',
            'phi_xuly_nuocthai' => 'Tính theo m³ xả thải.',
            'uu_dai_thue' => 'Miễn 2 năm đầu, giảm 50% trong 4 năm tiếp theo.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/ban-do-quy-hoach-khu-cong-nghiep-huu-thanh-long-an.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-huu-thanh-long-an.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.65,106.45&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Tân Phú Trung',
        'slug'  => 'kcn-tan-phu-trung',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-tan-phu-trung.jpg',
        'fields' => array(
            'tinh_thanh' => 'TP. Hồ Chí Minh',
            'vi_tri' => 'Củ Chi, TP. Hồ Chí Minh · hành lang Quốc lộ 22',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => 'Từ $265/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'SCD (Sài Gòn Tây Bắc)',
            'mo_ta_hinh_thuc_thue' => 'Định hướng công nghệ sạch, quy hoạch hiện đại.',
            'fact_cang_bien' => '15 km đến sân bay Tân Sơn Nhất',
            'fact_nuoc_thai' => 'Xử lý đạt QCVN',
            'ht_dien' => 'Nguồn điện 24/7 ổn định',
            'ht_nuoc_sach' => 'Nguồn nước sạch TP.HCM',
            'ht_nuoc_thai' => 'Nhà máy xử lý tập trung đạt QCVN',
            'ht_vien_thong' => 'Hạ tầng cáp quang tới rào',
            'ht_duong_bo' => 'Quốc lộ 22 & Vành đai 3',
            'ht_duong_thuy' => 'Cách Cảng Sài Gòn 27 km',
            'ten_logistics_1' => 'Cảng Sài Gòn',
            'logistics_cang_longan' => 'Cách Cảng Sài Gòn khoảng 27km.',
            'ten_logistics_2' => 'Trục Vành Đai 3',
            'logistics_cang_hiepphuoc' => 'Kết nối nhanh Vành đai & QL22.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Cách sân bay Tân Sơn Nhất khoảng 15km.',
            'ten_logistics_4' => 'Quốc lộ 22',
            'logistics_truc_giao_thong' => 'Hành lang xuất nhập khẩu Tây Bắc TP.HCM.',
            'nganh_nghe_thu_hut' => 'Công nghệ cao, Sản xuất sạch, Điện tử, R&D',
            'phi_quan_ly' => 'Theo quy định CĐT.',
            'gia_dien' => 'Giá điện EVN.',
            'gia_nuoc' => 'Giá nước sạch TP.HCM.',
            'phi_xuly_nuocthai' => 'Tính theo QCVN.',
            'uu_dai_thue' => 'Hưởng chính sách ưu đãi đầu tư đối với ngành sản xuất sạch & công nghệ cao.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-do-quy-hoach-kcn-tan-phu-trung.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-tan-phu-trung.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.92,106.53&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Phú Mỹ II',
        'slug'  => 'kcn-phu-my-ii',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-phu-my-ii.jpg',
        'fields' => array(
            'tinh_thanh' => 'Bà Rịa - Vũng Tàu',
            'vi_tri' => 'Phú Mỹ, Bà Rịa - Vũng Tàu · cách Quốc lộ 51 khoảng 1,5km',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => 'Từ $137/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'IDICO Corporation',
            'mo_ta_hinh_thuc_thue' => 'Quỹ đất lớn, vị trí ngay cạnh cụm cảng nước sâu Cái Mép - Thị Vải.',
            'fact_cang_bien' => '1 km đến Cảng Thị Vải',
            'fact_nuoc_thai' => '4.000 m³/ngày',
            'ht_dien' => 'Điện lưới 110/22kV',
            'ht_nuoc_sach' => '50.000 m³/ngày',
            'ht_nuoc_thai' => '4.000 m³/ngày',
            'ht_vien_thong' => 'Mạng viễn thông quốc tế',
            'ht_duong_bo' => 'Đường trục chính 63m',
            'ht_duong_thuy' => 'Cách Cảng PTSC / Phú Mỹ 2km',
            'ten_logistics_1' => 'Cảng Thị Vải',
            'logistics_cang_longan' => 'Cách Cảng Thị Vải 1km.',
            'ten_logistics_2' => 'Cảng Cái Mép',
            'logistics_cang_hiepphuoc' => 'Cách Cảng Cái Mép 5km.',
            'ten_logistics_3' => 'Sân bay Long Thành',
            'logistics_san_bay' => 'Cách sân bay Long Thành 35km.',
            'ten_logistics_4' => 'Quốc lộ 51',
            'logistics_truc_giao_thong' => 'Trục kết nối giao thông huyết mạch.',
            'nganh_nghe_thu_hut' => 'Thực phẩm, Dệt may, Nhựa, Cơ khí lắp ráp, Logistics',
            'phi_quan_ly' => 'Phí quản lý hạ tầng tiêu chuẩn IDICO',
            'gia_dien' => 'Giá điện EVN',
            'gia_nuoc' => 'Giá nước sạch tỉnh Bà Rịa - Vũng Tàu',
            'phi_xuly_nuocthai' => 'Tính theo khối lượng xả thải',
            'uu_dai_thue' => 'Ưu đãi thuế TNDN miễn 2 năm, giảm 50% trong 4 năm tiếp theo.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-do-quy-hoach-kcn-phu-my-ii.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/dat-kcn-phu-my-ii.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.58,107.03&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Châu Đức',
        'slug'  => 'kcn-chau-duc',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-chau-duc.jpg',
        'fields' => array(
            'tinh_thanh' => 'Bà Rịa - Vũng Tàu',
            'vi_tri' => 'Châu Đức, Bà Rịa - Vũng Tàu · kết nối QL56 và QL51',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$80 – $125/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'Sonadezi Châu Đức',
            'mo_ta_hinh_thuc_thue' => 'Khu công nghiệp đô thị quy mô lớn phía Nam.',
            'fact_cang_bien' => '16 km đến cảng Thị Vải',
            'fact_nuoc_thai' => '4.000 m³/ngày',
            'ht_dien' => '110/22kV · 2×63 MVA',
            'ht_nuoc_sach' => '75.000 m³/ngày',
            'ht_nuoc_thai' => '4.000 m³/ngày',
            'ht_vien_thong' => 'Viễn thông tốc độ cao',
            'ht_duong_bo' => 'Quốc lộ 56 và Quốc lộ 51',
            'ht_duong_thuy' => 'Cách Cảng Cái Mép 19km',
            'ten_logistics_1' => 'Cảng Thị Vải',
            'logistics_cang_longan' => 'Cách Cảng Thị Vải 16km.',
            'ten_logistics_2' => 'Cảng Cái Mép',
            'logistics_cang_hiepphuoc' => 'Cách Cảng Cái Mép 19km.',
            'ten_logistics_3' => 'Sân bay Long Thành',
            'logistics_san_bay' => 'Cách sân bay Long Thành 54km.',
            'ten_logistics_4' => 'Quốc lộ 56',
            'logistics_truc_giao_thong' => 'Kết nối hạ tầng đô thị Sonadezi.',
            'nganh_nghe_thu_hut' => 'Điện tử, Nhựa, Dược phẩm, Thiết bị y tế, Cơ khí, Vật liệu xây dựng',
            'phi_quan_ly' => 'Theo quy định Sonadezi',
            'gia_dien' => 'Điện sản xuất EVN',
            'gia_nuoc' => 'Nước cấp 75.000m³/ngày',
            'phi_xuly_nuocthai' => 'Xử lý nước thải chuẩn',
            'uu_dai_thue' => 'Ưu đãi thuế theo quy định KCN Bà Rịa - Vũng Tàu.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-do-quy-hoach-kcn-chau-duc.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-chau-duc.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.62,107.21&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Bình Chiểu',
        'slug'  => 'kcn-binh-chieu',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-binh-chieu.jpg',
        'fields' => array(
            'tinh_thanh' => 'TP. Hồ Chí Minh',
            'vi_tri' => 'Thủ Đức, TP. Hồ Chí Minh · kết nối QL1A, QL1K và QL13',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$300 – $330/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'Bến Thành Corporation',
            'mo_ta_hinh_thuc_thue' => 'Vị trí nội thành TP.HCM, kết nối ga đường sắt Sóng Thần.',
            'fact_cang_bien' => '4 km đến ga Sóng Thần',
            'fact_nuoc_thai' => '1.500 m³/ngày',
            'ht_dien' => 'Lưới điện thành phố',
            'ht_nuoc_sach' => 'Ống cấp nước Φ350',
            'ht_nuoc_thai' => '1.500 m³/ngày',
            'ht_vien_thong' => 'Mạng viễn thông TP.HCM',
            'ht_duong_bo' => 'Nút giao Quốc lộ 1A & QL13',
            'ht_duong_thuy' => 'Cách Cảng Cát Lái 18km',
            'ten_logistics_1' => 'Cảng Cát Lái',
            'logistics_cang_longan' => 'Cách Cảng Cát Lái 18km.',
            'ten_logistics_2' => 'Ga Sóng Thần',
            'logistics_cang_hiepphuoc' => 'Cách Ga Sóng Thần 4km.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Cách sân bay Tân Sơn Nhất 14km.',
            'ten_logistics_4' => 'Quốc lộ 1A',
            'logistics_truc_giao_thong' => 'Trục vận tải huyết mạch TP.HCM.',
            'nganh_nghe_thu_hut' => 'Cơ khí, Điện tử, Bao bì giấy, Thực phẩm, Vật liệu xây dựng',
            'phi_quan_ly' => 'Theo quy định Bến Thành Corp',
            'gia_dien' => 'Lưới điện hạ thế TP.HCM',
            'gia_nuoc' => 'Nước thủy cục TP.HCM',
            'phi_xuly_nuocthai' => 'Xử lý nước thải nội khu',
            'uu_dai_thue' => 'Ưu đãi theo chính sách khu chế xuất & KCN TP.HCM.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-do-quy-hoach-binh-chieu.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-binh-chieu.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.88,106.74&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Lê Minh Xuân 3',
        'slug'  => 'kcn-le-minh-xuan-3',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-le-minh-xuan-3.jpg',
        'fields' => array(
            'tinh_thanh' => 'TP. Hồ Chí Minh',
            'vi_tri' => 'Bình Chánh, TP. Hồ Chí Minh · liền kề QL1A và cao tốc Trung Lương',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$320 – $400/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'Saigon VRG',
            'mo_ta_hinh_thuc_thue' => 'Hạ tầng hiện đại 4 trạm 110KV, định hướng IT & Điện tử.',
            'fact_cang_bien' => '18 km đến sân bay Tân Sơn Nhất',
            'fact_nuoc_thai' => '15.000 m³/ngày',
            'ht_dien' => '4 trạm biến áp 110KV',
            'ht_nuoc_sach' => 'Cấp nước sạch đồng bộ',
            'ht_nuoc_thai' => '15.000 m³/ngày (Đạt cột A)',
            'ht_vien_thong' => 'Cáp quang băng thông rộng',
            'ht_duong_bo' => 'Đường nội bộ 18–40m',
            'ht_duong_thuy' => 'Cách Cảng Cát Lái 35km',
            'ten_logistics_1' => 'Cảng Cát Lái',
            'logistics_cang_longan' => 'Cách Cảng Cát Lái 35km.',
            'ten_logistics_2' => 'Cao tốc Trung Lương',
            'logistics_cang_hiepphuoc' => 'Kết nối trực tiếp Cao tốc Trung Lương.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Cách sân bay Tân Sơn Nhất 18km.',
            'ten_logistics_4' => 'Tỉnh lộ 10',
            'logistics_truc_giao_thong' => 'Kết nối trực tiếp trục giao thông miền Tây.',
            'nganh_nghe_thu_hut' => 'IT & điện tử, Khuôn mẫu, Dược phẩm, Thiết bị y tế, Kho vận',
            'phi_quan_ly' => 'Theo tiêu chuẩn Saigon VRG',
            'gia_dien' => 'Nguồn điện 4 trạm 110KV ổn định',
            'gia_nuoc' => 'Nước sạch KCN',
            'phi_xuly_nuocthai' => 'Xử lý đạt Cột A',
            'uu_dai_thue' => 'Chính sách ưu đãi đối với doanh nghiệp công nghệ & y tế.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-do-le-minh-xuan-3.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-le-minh-xuan-3.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.74,106.52&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Hiệp Phước',
        'slug'  => 'kcn-hiep-phuoc',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-hiep-phuoc-thong-tin.jpg',
        'fields' => array(
            'tinh_thanh' => 'TP. Hồ Chí Minh',
            'vi_tri' => 'Nhà Bè, TP. Hồ Chí Minh · liền kề cảng SPCT / Tân Cảng Hiệp Phước',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => 'Từ $250/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'HIEP PHUOC CORP',
            'mo_ta_hinh_thuc_thue' => 'Vị trí kết nối cảng nước sâu SPCT & Cảng Hiệp Phước.',
            'fact_cang_bien' => '1 km đến Cảng SPCT',
            'fact_nuoc_thai' => '12.000 m³/ngày',
            'ht_dien' => 'Lưới điện EVN 24/7',
            'ht_nuoc_sach' => '45.000 m³/ngày',
            'ht_nuoc_thai' => '12.000 m³/ngày',
            'ht_vien_thong' => 'Mạng viễn thông quốc tế',
            'ht_duong_bo' => 'Cách Cao tốc 2km',
            'ht_duong_thuy' => 'Liền kề Cảng SPCT',
            'ten_logistics_1' => 'Tân Cảng Hiệp Phước',
            'logistics_cang_longan' => 'Liền kề Cảng Tân Cảng Hiệp Phước.',
            'ten_logistics_2' => 'Cảng SPCT',
            'logistics_cang_hiepphuoc' => '1km đến Cảng SPCT.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Cách sân bay Tân Sơn Nhất 25km.',
            'ten_logistics_4' => 'Cao tốc Bến Lức',
            'logistics_truc_giao_thong' => 'Cách Cao tốc Bến Lức - Long Thành 2km.',
            'nganh_nghe_thu_hut' => 'Điện tử, Cơ khí, Dược phẩm, Thực phẩm, Bao bì, Dịch vụ cảng, Logistics',
            'phi_quan_ly' => 'Theo quy định HIEP PHUOC CORP',
            'gia_dien' => 'Giá điện EVN 24/7',
            'gia_nuoc' => '45.000m³/ngày',
            'phi_xuly_nuocthai' => 'Xử lý nước thải tập trung',
            'uu_dai_thue' => 'Ưu đãi thuế suất TNDN 10% trong 15 năm theo chính sách KCN cảng.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-do-quy-hoach-kcn-hiep-phuoc.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/co-so-ha-tang-kcn-hiep-phuoc.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.63,106.75&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN QTIP Quảng Trị',
        'slug'  => 'kcn-qtip-quang-tri',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-qtip-quang-tri-cho-thue-dat-kcn-kho-xuong-1400x788.jpg',
        'fields' => array(
            'tinh_thanh' => 'Quảng Trị',
            'vi_tri' => 'Đông Hà, Quảng Trị · liền kề hành lang kinh tế Đông–Tây (EWEC)',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => 'Từ $50/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'Liên danh BRG & Singapore (QTIP)',
            'mo_ta_hinh_thuc_thue' => 'Hình thức thuê gồm đất trống, xưởng xây sẵn theo tiêu chuẩn sạch.',
            'fact_cang_bien' => '45 km đến cảng Mỹ Thủy',
            'fact_nuoc_thai' => '6.000 m³/ngày',
            'ht_dien' => '110/22KV · ổn định 24/7',
            'ht_nuoc_sach' => '8.000 m³/ngày',
            'ht_nuoc_thai' => '6.000 m³/ngày · cột A',
            'ht_vien_thong' => 'Cáp quang VNPT & Viettel',
            'ht_duong_bo' => 'QL1A & đường EWEC',
            'ht_duong_thuy' => 'Cách Cảng Mỹ Thủy 45km',
            'ten_logistics_1' => 'Cảng Mỹ Thủy',
            'logistics_cang_longan' => 'Cảng Mỹ Thủy khoảng 45km.',
            'ten_logistics_2' => 'Cửa khẩu Lao Bảo',
            'logistics_cang_hiepphuoc' => 'Cửa khẩu Lao Bảo 85km, xuất hàng sang Lào-Thái Lan.',
            'ten_logistics_3' => 'Sân bay Đồng Hới',
            'logistics_san_bay' => 'Cách sân bay Đồng Hới 60km.',
            'ten_logistics_4' => 'Hành lang EWEC',
            'logistics_truc_giao_thong' => 'Hành lang kinh tế Đông Tây.',
            'nganh_nghe_thu_hut' => 'Điện tử & linh kiện, Dệt may, Chế biến thực phẩm, Logistics',
            'phi_quan_ly' => '0,03 USD/m²/tháng',
            'gia_dien' => 'Giá điện EVN',
            'gia_nuoc' => 'Khoảng 8.000 – 9.000đ/m³',
            'phi_xuly_nuocthai' => '0,25 – 0,30 USD/m³',
            'uu_dai_thue' => 'Miễn thuế 4 năm, giảm 50% trong 9 năm; thuế suất 10% trong 15 năm.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-qtip-quang-tri-cho-thue-dat-kcn-kho-xuong-711x400.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/moi-gioi-kho-xuong-quang-tri-cong-ty-chuyen-768x432.png',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=16.8,107.09&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Thủ Thừa',
        'slug'  => 'kcn-thu-thua',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/04/kcn-thu-thua-long-an-1-768x432.jpg',
        'fields' => array(
            'tinh_thanh' => 'Long An',
            'vi_tri' => 'Thủ Thừa, Long An · cạnh cao tốc Bến Lức–Trung Lương (N2)',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$130 – $155/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'IDICO Long An',
            'mo_ta_hinh_thuc_thue' => 'Cung cấp đất trống cho thuê và nhà xưởng tiêu chuẩn KCN.',
            'fact_cang_bien' => '50 km đến TP.HCM trung tâm',
            'fact_nuoc_thai' => '8.000 m³/ngày',
            'ht_dien' => '110/22KV · 63MW',
            'ht_nuoc_sach' => '10.000 m³/ngày',
            'ht_nuoc_thai' => '8.000 m³/ngày',
            'ht_vien_thong' => 'Cáp quang băng rộng',
            'ht_duong_bo' => 'Cao tốc N2 · QL62',
            'ht_duong_thuy' => 'Cách Cảng Long An 40km',
            'ten_logistics_1' => 'Cao tốc N2',
            'logistics_cang_longan' => 'Về TP.HCM dưới 1 giờ.',
            'ten_logistics_2' => 'Cảng Long An',
            'logistics_cang_hiepphuoc' => 'Cảng quốc tế Long An 40km.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Cách sân bay Tân Sơn Nhất 55km.',
            'ten_logistics_4' => 'Quốc lộ 62',
            'logistics_truc_giao_thong' => 'Kết nối cửa khẩu Campuchia.',
            'nganh_nghe_thu_hut' => 'Chế biến thực phẩm, Dệt may, Bao bì & nhựa, Cơ khí nhẹ, Logistics',
            'phi_quan_ly' => '0,04 USD/m²/tháng',
            'gia_dien' => 'Giá điện EVN',
            'gia_nuoc' => 'Khoảng 10.000 – 12.000đ/m³',
            'phi_xuly_nuocthai' => '0,30 – 0,35 USD/m³',
            'uu_dai_thue' => 'Miễn thuế 2 năm, giảm 50% trong 4 năm tiếp theo.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/04/kcn-thu-thua-long-an-1-768x432.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-huu-thanh-long-an.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.64,106.44&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Liên Chiểu',
        'slug'  => 'kcn-lien-chieu',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/06/kcn-gia-re-kcn-da-nang-768x560.jpg',
        'fields' => array(
            'tinh_thanh' => 'Đà Nẵng',
            'vi_tri' => 'Liên Chiểu, Đà Nẵng · gần cảng Liên Chiểu và sân bay Đà Nẵng',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$95 – $120/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'Ban Quản lý KCN Đà Nẵng',
            'mo_ta_hinh_thuc_thue' => 'Cho thuê đất và hạ tầng sản xuất tiêu chuẩn sạch.',
            'fact_cang_bien' => '8 km đến sân bay Đà Nẵng',
            'fact_nuoc_thai' => '10.000 m³/ngày',
            'ht_dien' => '110/22KV · 2 nguồn',
            'ht_nuoc_sach' => '15.000 m³/ngày',
            'ht_nuoc_thai' => '10.000 m³/ngày',
            'ht_vien_thong' => 'Cáp quang tốc độ cao',
            'ht_duong_bo' => 'QL14B · đường ven biển',
            'ht_duong_thuy' => 'Cách Cảng Liên Chiểu 5km',
            'ten_logistics_1' => 'Cảng Liên Chiểu',
            'logistics_cang_longan' => 'Cảng Liên Chiểu 5km.',
            'ten_logistics_2' => 'Hầm Hải Vân',
            'logistics_cang_hiepphuoc' => 'Hầm đường bộ Hải Vân kết nối miền Trung.',
            'ten_logistics_3' => 'Sân bay Đà Nẵng',
            'logistics_san_bay' => 'Cách sân bay Đà Nẵng 8km.',
            'ten_logistics_4' => 'Cao tốc Quảng Ngãi',
            'logistics_truc_giao_thong' => 'Kết nối vùng kinh tế trọng điểm miền Trung.',
            'nganh_nghe_thu_hut' => 'CNTT & phần mềm, Điện tử & vi mạch, Cơ khí chính xác, Dược phẩm',
            'phi_quan_ly' => '0,045 USD/m²/tháng',
            'gia_dien' => 'Giá điện EVN',
            'gia_nuoc' => 'Khoảng 11.000 – 13.000đ/m³',
            'phi_xuly_nuocthai' => '0,32 – 0,38 USD/m³',
            'uu_dai_thue' => 'Miễn thuế 2 năm, giảm 50% trong 4 năm; ưu đãi đặc biệt ngành CNTT.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/06/kcn-gia-re-kcn-da-nang-768x560.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-qtip-quang-tri-cho-thue-dat-kcn-kho-xuong-711x400.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=16.09,108.14&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Nhơn Trạch 2',
        'slug'  => 'kcn-nhon-trach-2',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-chau-duc.jpg',
        'fields' => array(
            'tinh_thanh' => 'Đồng Nai',
            'vi_tri' => 'Nhơn Trạch, Đồng Nai · cạnh cao tốc HCM–Long Thành–Dầu Giây',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$160 – $190/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'SONADEZI Đồng Nai',
            'mo_ta_hinh_thuc_thue' => 'Khu công nghiệp đa ngành, hạ tầng hiện đại.',
            'fact_cang_bien' => '30 km đến trung tâm TP.HCM',
            'fact_nuoc_thai' => '15.000 m³/ngày',
            'ht_dien' => '110/22KV · 80MW',
            'ht_nuoc_sach' => '20.000 m³/ngày',
            'ht_nuoc_thai' => '15.000 m³/ngày',
            'ht_vien_thong' => 'Cáp quang tốc độ cao',
            'ht_duong_bo' => 'Cao tốc Long Thành–Dầu Giây',
            'ht_duong_thuy' => 'Cảng Phú Hữu & Cát Lái 15-25km',
            'ten_logistics_1' => 'Cảng Cát Lái',
            'logistics_cang_longan' => 'Về Cảng Cát Lái 15–25km.',
            'ten_logistics_2' => 'Cầu Phước Khánh',
            'logistics_cang_hiepphuoc' => 'Cầu Phước Khánh kết nối Cần Giờ & TP.HCM.',
            'ten_logistics_3' => 'Sân bay Long Thành',
            'logistics_san_bay' => 'Cách sân bay Long Thành 25km.',
            'ten_logistics_4' => 'Trục Nhơn Trạch',
            'logistics_truc_giao_thong' => 'Kết nối tam giác kinh tế TP.HCM - Đồng Nai - Bà Rịa.',
            'nganh_nghe_thu_hut' => 'Cơ khí chế tạo nặng, Hóa chất công nghiệp, Điện tử & viễn thông, Nhựa',
            'phi_quan_ly' => '0,05 USD/m²/tháng',
            'gia_dien' => 'Giá điện EVN',
            'gia_nuoc' => '12.000 – 13.500đ/m³',
            'phi_xuly_nuocthai' => '0,35 – 0,40 USD/m³',
            'uu_dai_thue' => 'Miễn thuế 2 năm, giảm 50% trong 4 năm tiếp theo.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-phu-my-ii.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-huu-thanh-long-an.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.72,106.95&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN VSIP II',
        'slug'  => 'kcn-vsip-ii',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-phu-my-ii.jpg',
        'fields' => array(
            'tinh_thanh' => 'Bình Dương',
            'vi_tri' => 'Thủ Dầu Một, Bình Dương · mô hình KCN - đô thị - dịch vụ',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$210 – $260/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'Becamex IDC & Sembcorp (Singapore)',
            'mo_ta_hinh_thuc_thue' => 'Mô hình KCN-đô thị-dịch vụ tích hợp chuẩn Singapore.',
            'fact_cang_bien' => '30 km đến trung tâm TP.HCM',
            'fact_nuoc_thai' => '60.000 m³/ngày',
            'ht_dien' => '220/110KV · 200MW',
            'ht_nuoc_sach' => '100.000 m³/ngày',
            'ht_nuoc_thai' => '60.000 m³/ngày',
            'ht_vien_thong' => 'Smart city · Cáp quang tốc độ cao',
            'ht_duong_bo' => 'QL13 · Cao tốc HCM–Bình Phước',
            'ht_duong_thuy' => 'Cảng Cát Lái 40-50km',
            'ten_logistics_1' => 'Cảng Cát Lái',
            'logistics_cang_longan' => 'Cảng Cát Lái & Phú Hữu 40–50km.',
            'ten_logistics_2' => 'Quốc lộ 13',
            'logistics_cang_hiepphuoc' => 'Quốc lộ 13 kết nối trung tâm TP.HCM.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Cách sân bay Tân Sơn Nhất 35km.',
            'ten_logistics_4' => 'Mỹ Phước - Tân Vạn',
            'logistics_truc_giao_thong' => 'Trục vận tải thông minh Bình Dương.',
            'nganh_nghe_thu_hut' => 'Công nghệ cao & bán dẫn, Điện tử, Dược phẩm, Ô tô, Logistics',
            'phi_quan_ly' => '0,055 USD/m²/tháng',
            'gia_dien' => 'Giá điện EVN',
            'gia_nuoc' => '12.100đ/m³',
            'phi_xuly_nuocthai' => '0,38 – 0,42 USD/m³',
            'uu_dai_thue' => 'Miễn thuế 4 năm, giảm 50% trong 9 năm tiếp theo.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-do-quy-hoach-kcn-tan-phu-trung.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-le-minh-xuan-3.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.94,106.7&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'KCN Cát Lái',
        'slug'  => 'kcn-cat-lai',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-hiep-phuoc-thong-tin.jpg',
        'fields' => array(
            'tinh_thanh' => 'TP. Hồ Chí Minh',
            'vi_tri' => 'Quận 2 (Thủ Đức), TP. Hồ Chí Minh · kề cảng container Cát Lái',
            'trang_thai' => 'ĐANG HOẠT ĐỘNG',
            'gia_thue' => '$350 – $420/m²',
            'don_vi_tinh' => 'Đất và hạ tầng · chu kỳ thuê',
            'chu_dau_tu' => 'HEPZA (Ban Quản lý KCN TP.HCM)',
            'mo_ta_hinh_thuc_thue' => 'Vị trí đắc địa nhất TP.HCM dành cho doanh nghiệp xuất nhập khẩu.',
            'fact_cang_bien' => '0,5 km đến cảng Cát Lái',
            'fact_nuoc_thai' => '20.000 m³/ngày',
            'ht_dien' => '220/110KV · dự phòng UPS',
            'ht_nuoc_sach' => '30.000 m³/ngày',
            'ht_nuoc_thai' => '20.000 m³/ngày',
            'ht_vien_thong' => 'Fiber đến từng nhà máy',
            'ht_duong_bo' => 'Đường Mai Chí Thọ · xa lộ HN',
            'ht_duong_thuy' => 'Cát Lái · 10 triệu TEU/năm',
            'ten_logistics_1' => 'Cảng Cát Lái',
            'logistics_cang_longan' => 'Liền kề Cảng Cát Lái 0.5km.',
            'ten_logistics_2' => 'Xa lộ Hà Nội',
            'logistics_cang_hiepphuoc' => 'Xa lộ Hà Nội kết nối trung tâm TP.HCM.',
            'ten_logistics_3' => 'Sân bay Tân Sơn Nhất',
            'logistics_san_bay' => 'Cách sân bay Tân Sơn Nhất 15km.',
            'ten_logistics_4' => 'Mai Chí Thọ',
            'logistics_truc_giao_thong' => 'Trục đại lộ Đông Tây kết nối trung tâm TP.HCM.',
            'nganh_nghe_thu_hut' => 'Xuất nhập khẩu container, Logistics, Điện tử xuất khẩu, Dược phẩm',
            'phi_quan_ly' => '0,06 USD/m²/tháng',
            'gia_dien' => 'Giá điện EVN',
            'gia_nuoc' => '12.100đ/m³',
            'phi_xuly_nuocthai' => '0,40 – 0,45 USD/m³',
            'uu_dai_thue' => 'Miễn thuế 2 năm, giảm 50% trong 4 năm tiếp theo.',
            'anh_quy_hoach' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-binh-chieu.jpg',
            'anh_ha_tang' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-le-minh-xuan-3.jpg',
            'google_map_embed' => '<iframe src="https://maps.google.com/maps?q=10.76,106.78&z=14&output=embed"></iframe>'
        )
    )
);

// Tạo Chuyên mục "Khu Công Nghiệp" sử dụng API An toàn
$cat_name = 'Khu Công Nghiệp';
$cat_slug = 'khu-cong-nghiep';
$cat_id = 1;

$term = term_exists($cat_name, 'category');
if (!$term) {
    $term = wp_insert_term($cat_name, 'category', array('slug' => $cat_slug));
}

if (is_array($term)) {
    $cat_id = $term['term_id'];
} elseif (is_object($term)) {
    $cat_id = $term->term_id;
}

$created_count = 0;
$updated_count = 0;

echo '<div style="font-family:Arial, sans-serif; max-width:850px; margin:40px auto; padding:30px; background:#ffffff; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.1); color:#000000; line-height:1.8;">';
echo '<h2 style="color:#0f7f2f; border-bottom:2px solid #0f7f2f; padding-bottom:12px; margin-top:0;">🚀 TỰ ĐỘNG KHỞI TẠO 14 BÀI VIẾT KHU CÔNG NGHIỆP:</h2><ul style="padding-left:20px;">';

foreach ($kcn_list as $kcn) {
    $post_type = post_type_exists('khu-cong-nghiep') ? 'khu-cong-nghiep' : 'post';
    
    // Tìm bài viết đã tồn tại
    $existing_query = new WP_Query(array(
        'name'        => $kcn['slug'],
        'post_type'   => array('post', 'khu-cong-nghiep'),
        'post_status' => 'any',
        'posts_per_page' => 1
    ));

    $post_id = 0;

    if ($existing_query->have_posts()) {
        $existing_query->the_post();
        $post_id = get_the_ID();
        wp_reset_postdata();

        $updated_count++;
        echo "<li style='color:#27ae60;'>🔄 Đã cập nhật dữ liệu: <strong>{$kcn['title']}</strong> (ID: {$post_id})</li>";
    } else {
        $post_data = array(
            'post_title'    => $kcn['title'],
            'post_name'     => $kcn['slug'],
            'post_status'   => 'publish',
            'post_type'     => $post_type,
            'post_category' => array($cat_id)
        );

        $post_id = wp_insert_post($post_data);
        $created_count++;
        echo "<li style='color:#0f7f2f;'>✅ Đã tạo mới thành công: <strong>{$kcn['title']}</strong> (ID: {$post_id})</li>";
    }

    if ($post_id && !is_wp_error($post_id)) {
        // Cập nhật template page
        update_post_meta($post_id, '_wp_page_template', 'single-khu-cong-nghiep.php');

        // Cập nhật các trường ACF
        foreach ($kcn['fields'] as $key => $val) {
            update_post_meta($post_id, $key, $val);
            if (function_exists('update_field')) {
                update_field($key, $val, $post_id);
            }
        }
    }
}

echo '</ul>';
echo "<div style='background:#f0fdf4; border:1px solid #dcfce7; padding:15px 20px; border-radius:8px; margin-top:20px;'>";
echo "<h3 style='color:#0f7f2f; margin:0 0 8px;'>🎉 HOÀN THÀNH RẤT TỐT!</h3>";
echo "<p style='margin:0;'>Đã tạo mới <strong>{$created_count}</strong> bài viết và cập nhật <strong>{$updated_count}</strong> bài viết KCN kèm toàn bộ thông tin ACF!</p>";
echo "</div>";
echo "<p style='margin-top:20px;'>👉 Bây giờ bạn có thể mở <strong>Admin WordPress -> Posts (Bài viết)</strong> để thấy trọn bộ 14 bài viết KCN đã sẵn sàng!</p>";
echo "<p style='color:#c0392b; font-weight:bold;'>⚠️ ĐỪNG QUÊN: Hãy xóa file <code>import-kcn.php</code> này khỏi theme sau khi hoàn tất để bảo mật website.</p>";
echo '</div>';
