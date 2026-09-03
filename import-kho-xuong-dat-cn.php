<?php
/**
 * TÊN FILE: import-kho-xuong-dat-cn.php
 * MỤC ĐÍCH: TỰ ĐỘNG KHỞI TẠO 16 SẢN PHẨM THỰC TẾ KHO XƯỞNG & ĐẤT CÔNG NGHIỆP TỪ KHO XƯỞNG ĐẸP
 * 
 * TÍNH NĂNG:
 * - Tạo 2 danh mục: "Kho Xưởng" (slug: kho-xuong) & "Đất Công Nghiệp" (slug: dat-cong-nghiep)
 * - Tạo 8 bài viết Kho xưởng & 8 bài viết Đất công nghiệp với 100% ẢNH THẬT HD và THÔNG SỐ CHUẨN
 * - Gán template single-product.php (Layout sản phẩm chuẩn BĐS chi tiết)
 * - Tương thích hoàn toàn ACF Free và Custom Fields mặc định của WordPress
 */

// Bật hiển thị lỗi để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// TỰ ĐỘNG TÌM FILE wp-load.php
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
    die('<h2 style="color:red;">❌ Không tìm thấy file wp-load.php. Vui lòng đặt file import-kho-xuong-dat-cn.php vào thư mục theme hoặc thư mục gốc WordPress.</h2>');
}

// NẠP CÁC FILE CHỨC NĂNG ADMIN CẦN THIẾT
if (defined('ABSPATH')) {
    require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');
    require_once(ABSPATH . 'wp-admin/includes/post.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
}

// Kiểm tra quyền Admin
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('<h3 style="color:red; font-family:Arial; padding:20px;">⚠️ Bạn cần ĐĂNG NHẬP tài khoản Admin WordPress trước khi truy cập đường dẫn này.</h3>');
}

// =========================================================================
// 1. DANH SÁCH 8 SẢN PHẨM KHO XƯỞNG THỰC TẾ (100% ẢNH GỐC HD & THÔNG SỐ)
// =========================================================================
$kho_xuong_list = array(
    array(
        'title' => 'Cho thuê kho xưởng 3000m2 trong KCN Hòa Khánh, Đà Nẵng',
        'slug'  => 'cho-thue-kho-xuong-3000m2-kcn-hoa-khanh-da-nang-3',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/cho-thue-kho-xuong-3000m2-kcn-hoa-khanh-da-nang.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-DN01',
            'dien_tich'         => '3.000 m²',
            'gia_thue'          => '270 triệu/tháng',
            'don_vi_tinh'       => '90.000đ/m²/tháng (Chưa VAT)',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'Đà Nẵng',
            'vi_tri'            => 'KCN Hòa Khánh, Quận Liên Chiểu, TP. Đà Nẵng',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'Có phòng cháy chữa cháy tự động, Đường container 24/24, Sàn sơn Epoxy chống bụi, Văn phòng làm việc tiện nghi, Pháp lý đầy đủ rõ ràng, Có điện hạ bình 3 pha, Sân bãi bê tông rộng, Nước máy sinh hoạt',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/cho-thue-kho-xuong-3000m2-kcn-hoa-khanh-da-nang.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=16.07,108.15&z=14&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Cho Thuê Kho Xưởng 4000-5000m2 KCN Đông Nam, Củ Chi, TP.HCM',
        'slug'  => 'cho-thue-kho-xuong-4-5000m2-kcn-dong-nam-cu-chi',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2024/10/cho-thue-kho-xuong-5000m2-khu-cong-nghiep-dong-nam-cu-chi.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-CC02',
            'dien_tich'         => '5.000 m²',
            'gia_thue'          => '85.000đ/m²/tháng',
            'don_vi_tinh'       => 'Tổng giá thuê: 425 triệu/tháng',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'TP. Hồ Chí Minh',
            'vi_tri'            => 'KCN Đông Nam, Xã Bình Mỹ, Huyện Củ Chi, TP.HCM',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'PCCC tự động Sprinkler nghiệm thu, Trạm biến áp 1.000kVA, Nền bê tông chịu tải 5T/m2, Trục đường 40m xe container 24/7, Văn phòng 2 tầng 250m2, Gần cầu Phú Cường nối Bình Dương',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2024/10/cho-thue-kho-xuong-5000m2-khu-cong-nghiep-dong-nam-cu-chi.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.97,106.63&z=14&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Kho Xưởng Cho Thuê 1.6 Hecta (16.000m²) KCN Đức Hòa 3 – Long An',
        'slug'  => 'kho-xuong-cho-thue-16-hecta-20000m2-kcn-duc-hoa',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/03/cho-thue-xuong-20000m2-kcn-duc-hoa-3-thai-hoa-3-1.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-DH03',
            'dien_tich'         => '16.000 m²',
            'gia_thue'          => '75.000đ/m²/tháng',
            'don_vi_tinh'       => 'Khuôn viên riêng 2.5 ha · Tổng tiền 1.2 tỷ/tháng',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'Long An',
            'vi_tri'            => 'KCN Đức Hòa 3 – Thái Hòa, Huyện Đức Hòa, Tỉnh Long An',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'Khuôn viên độc lập 2.5 ha, Trạm cân xe tải 80 tấn, Trạm điện hạ bình 1.500kVA, PCCC vách tường & tự động, Sàn đánh bóng Hardener, Nhà ăn và văn phòng điều hành đầy đủ',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/03/cho-thue-xuong-20000m2-kcn-duc-hoa-3-thai-hoa-3-1.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.92,106.48&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Cho Thuê Kho Xưởng 3.000m² KCN Nam Đông Hà – Quảng Trị',
        'slug'  => 'cho-thue-kho-xuong-3000m2-kcn-nam-dong-ha-quang-tri',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/cho-thue-kho-xuong-3000m2-kcn-nam-dong-ha-quang-tri.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-QT04',
            'dien_tich'         => '3.000 m²',
            'gia_thue'          => '45.000đ/m²/tháng',
            'don_vi_tinh'       => 'Tổng giá thuê: 135 triệu/tháng',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'Quảng Trị',
            'vi_tri'            => 'KCN Nam Đông Hà, Phường Đông Lương, TP. Đông Hà, Quảng Trị',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'PCCC nghiệm thu đạt chuẩn, Trạm biến áp riêng 560kVA, Sân bãi bê tông 1.500m2, Cách Cảng Cửa Việt 15km, Đường QL1A và QL9 kết nối xuyên suốt',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/cho-thue-kho-xuong-3000m2-kcn-nam-dong-ha-quang-tri.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=16.78,107.10&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Kho Xưởng 5.000m² KCN Quán Ngang – Gio Linh, Quảng Trị',
        'slug'  => 'cho-thue-kho-xuong-5000m2-kcn-quan-ngang-quang-tri',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/cho-thue-kho-xuong-5000m2-kcn-quan-ngang-quang-tri.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-QT05',
            'dien_tich'         => '5.000 m²',
            'gia_thue'          => '40.000đ/m²/tháng',
            'don_vi_tinh'       => 'Tổng giá thuê: 200 triệu/tháng',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'Quảng Trị',
            'vi_tri'            => 'KCN Quán Ngang, Huyện Gio Linh, Tỉnh Quảng Trị',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'Khung thép Zamil cao 9m, Sàn bê tông chịu tải 5 tấn/m2, Trạm biến áp 1.000kVA, Mặt tiền Quốc lộ 1A, Xe container ra vào tận trong xưởng 24/7',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/cho-thue-kho-xuong-5000m2-kcn-quan-ngang-quang-tri.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=16.89,107.08&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Xưởng Cho Thuê 2.500m² KCN Tây Bắc Hồ Xá – Vĩnh Linh',
        'slug'  => 'cho-thue-kho-xuong-2500m2-kcn-tay-bac-ho-xa',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/cho-thue-kho-xuong-2500m2-kcn-tay-bac-ho-xa.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-QT06',
            'dien_tich'         => '2.500 m²',
            'gia_thue'          => '38.000đ/m²/tháng',
            'don_vi_tinh'       => 'Tổng giá thuê: 95 triệu/tháng',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'Quảng Trị',
            'vi_tri'            => 'KCN Tây Bắc Hồ Xá, Huyện Vĩnh Linh, Tỉnh Quảng Trị',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'Văn phòng 2 tầng 150m2, Sân bãi rộng 800m2, Trạm biến áp 400kVA, Hệ thống đèn LED công nghiệp, Giá thuê cạnh tranh nhất khu vực',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/cho-thue-kho-xuong-2500m2-kcn-tay-bac-ho-xa.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=17.06,106.96&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Kho Xưởng 3.200m² KCN Cầu Cảng Phước Đông – Cần Giuộc',
        'slug'  => 'kho-xuong-phuoc-dong-3200m2',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-LA07',
            'dien_tich'         => '3.200 m²',
            'gia_thue'          => '72.000đ/m²/tháng',
            'don_vi_tinh'       => 'Tổng giá thuê: 230 triệu/tháng',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'Long An',
            'vi_tri'            => 'KCN Cầu Cảng Phước Đông, Huyện Cần Giuộc, Long An',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'Hệ thống Dock Leveler tự động, Liền kề cầu cảng đón sà lan sông Vàm Cỏ, Nguồn điện lưới & điện mặt trời 63MW, Cách Cát Lái 30km',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.51,106.65&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Xưởng Lớn 8.500m² Gần Cảng Hiệp Phước – Nhà Bè TP.HCM',
        'slug'  => 'kho-xuong-hiep-phuoc-8500m2',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-hiep-phuoc-thong-tin.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-KX-HCM08',
            'dien_tich'         => '8.500 m²',
            'gia_thue'          => '95.000đ/m²/tháng',
            'don_vi_tinh'       => 'Tổng giá thuê: 807 triệu/tháng',
            'loai_hinh'         => 'Kho Xưởng Cho Thuê',
            'tinh_thanh'        => 'TP. Hồ Chí Minh',
            'vi_tri'            => 'KCN Hiệp Phước (GĐ2), Huyện Nhà Bè, TP. Hồ Chí Minh',
            'trang_thai'        => 'CÒN TRỐNG',
            'tien_ich_list'     => 'Cầu trục dầm đôi 10 tấn, Trạm biến áp 1.500kVA, Hệ thống PCCC sprinkler tự động, Cách Cụm Cảng Hiệp Phước chỉ 1km, Đường xe container 24/7',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-hiep-phuoc-thong-tin.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.63,106.75&z=13&output=embed"></iframe>'
        )
    )
);

// =========================================================================
// 2. DANH SÁCH 8 SẢN PHẨM ĐẤT CÔNG NGHIỆP THỰC TẾ (100% ẢNH GỐC HD & THÔNG SỐ)
// =========================================================================
$dat_cong_nghiep_list = array(
    array(
        'title' => 'Bán đất KCN VSIP 2, Bắc Tân Uyên: 30.000 - 100.000m2 (3 - 10 ha)',
        'slug'  => 'ban-dat-30-100000-trong-kcn-visip-2-binh-duong',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2024/12/ban-dat-100.000m2-khu-cong-nghiep-vsip2-binh-duong.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-BD01',
            'dien_tich'         => '30.000 – 100.000 m² (3 - 10 ha)',
            'gia_thue'          => '$130/m²',
            'don_vi_tinh'       => 'Đất công nghiệp 50 năm chuẩn VSIP',
            'loai_hinh'         => 'Đất Công Nghiệp Bán / Chuyển Nhượng',
            'tinh_thanh'        => 'Bình Dương',
            'vi_tri'            => 'KCN VSIP 2 Mở Rộng, Huyện Bắc Tân Uyên, Tỉnh Bình Dương',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'KCN chuẩn VSIP quốc tế, Mặt tiền đường rộng 62m, Trạm biến áp 110/22kV, Nhà máy xử lý nước thải Cột A, Sổ hồng riêng từng lô, Hỗ trợ cấp phép IRC/ERC',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2024/12/ban-dat-100.000m2-khu-cong-nghiep-vsip2-binh-duong.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=11.10,106.72&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Bán đất công nghiệp giá rẻ KCN Hựu Thạnh 1-3-5ha Lô Góc 2 Mặt Tiền',
        'slug'  => 'ban-dat-cong-nghiep-1-3-5-hecta-kcn-huu-thanh',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2024/10/ban-dat-cong-nghiep-3-5ha-goc-2-mat-tien-kcn-huu-thanh-1067x800.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-LA02',
            'dien_tich'         => '35.000 m² (3.5 ha)',
            'gia_thue'          => '$140/m²',
            'don_vi_tinh'       => 'Đất công nghiệp bàn giao ngay',
            'loai_hinh'         => 'Đất Công Nghiệp Bán / Chuyển Nhượng',
            'tinh_thanh'        => 'Long An',
            'vi_tri'            => 'KCN Hựu Thạnh IDICO, Huyện Đức Hòa, Tỉnh Long An',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'Lô góc 2 mặt tiền đường rộng 28m, Mặt tiền đường Vành Đai 4 (ĐT 830), Đã san lấp mặt bằng cốt chuẩn, Đấu nối điện nước tại chân công trình, Giáp ranh TP.HCM',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2024/10/ban-dat-cong-nghiep-3-5ha-goc-2-mat-tien-kcn-huu-thanh-1067x800.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.79,106.45&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Bán đất 0,85-1,7ha KCN Trần Anh Tân Phú, Long An giá rẻ',
        'slug'  => 'ban-dat-085-17-hecta-kcn-tran-anh-tan-phu-la',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/06/ban-dat-17000m2-kcn-tran-anh-tan-phu-1.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-LA03',
            'dien_tich'         => '17.000 m² (1.7 ha)',
            'gia_thue'          => '$115/m²',
            'don_vi_tinh'       => 'Giá thuê 50 năm ưu đãi',
            'loai_hinh'         => 'Đất Công Nghiệp Bán / Chuyển Nhượng',
            'tinh_thanh'        => 'Long An',
            'vi_tri'            => 'KCN Trần Anh Tân Phú, Huyện Đức Hòa, Tỉnh Long An',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'KCN sinh thái có bến cảng nội khu trên sông Vàm Cỏ Đông, Pháp lý hoàn thiện 100%, Tiếp cận trung tâm TP.HCM 45 phút, Đa dạng ngành nghề sản xuất',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/06/ban-dat-17000m2-kcn-tran-anh-tan-phu-1.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.85,106.38&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Bán đất dệt nhuộm 10-50,000m2 tại KCN Thủ Thừa Long An',
        'slug'  => 'ban-dat-det-nhuom-10-50000m2-kcn-long-an',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/06/ban-dat-30000m2-kcn-thu-thua-long-an.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-LA04',
            'dien_tich'         => '30.000 m² (3 ha)',
            'gia_thue'          => '$150/m²',
            'don_vi_tinh'       => 'Đất có chỉ tiêu ngành Dệt Nhuộm',
            'loai_hinh'         => 'Đất Công Nghiệp Chuyên Ngành',
            'tinh_thanh'        => 'Long An',
            'vi_tri'            => 'KCN Thủ Thừa, Huyện Thủ Thừa, Tỉnh Long An',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'Tiếp nhận ngành dệt may, nhuộm, giặt tẩy, Nhà máy xử lý nước thải công suất khủng, Giấy phép ĐTM đã được phê duyệt, Kết nối cao tốc TP.HCM - Trung Lương',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/06/ban-dat-30000m2-kcn-thu-thua-long-an.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.60,106.33&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Bán Đất Sản Xuất Phân Bón KCN Phước Đông, Long An: 10.000m²',
        'slug'  => 'ban-dat-san-xuat-phan-bon-kcn-phuoc-dong-5000m2',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/04/dat-ban-10000m2-khu-cong-nghiep-phuoc-dong-cau-cang-long-an-min.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-LA05',
            'dien_tich'         => '10.000 m² (1 ha)',
            'gia_thue'          => '$145/m²',
            'don_vi_tinh'       => 'Tiếp nhận ngành Hóa chất & Phân bón',
            'loai_hinh'         => 'Đất Công Nghiệp Bán / Chuyển Nhượng',
            'tinh_thanh'        => 'Long An',
            'vi_tri'            => 'KCN Cầu Cảng Phước Đông, Huyện Cần Giuộc, Long An',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'Được cấp phép sản xuất phân bón và hóa chất, Liền kề cầu cảng nội khu đón tàu 20.000 DWT, Hệ thống xử lý nước thải chuyên dụng Cột A, Hạ tầng hoàn thiện 100%',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/04/dat-ban-10000m2-khu-cong-nghiep-phuoc-dong-cau-cang-long-an-min.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.51,106.65&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Bán đất sản xuất phân bón, cơ khí KCN Tân Kim Cần Giuộc: 15.000m²',
        'slug'  => 'ban-dat-san-xuat-phan-bon-kcn-tan-kim-can-giuoc',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/03/ban-dat-san-xuat-phan-bon-hoa-chat-khu-cong-nghiep-tan-kim-can-giuoc-long-an-1400x787.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-LA06',
            'dien_tich'         => '15.000 m² (1.5 ha)',
            'gia_thue'          => '$165/m²',
            'don_vi_tinh'       => 'Đất KCN kề sát ranh giới TP.HCM',
            'loai_hinh'         => 'Đất Công Nghiệp Bán / Chuyển Nhượng',
            'tinh_thanh'        => 'Long An',
            'vi_tri'            => 'KCN Tân Kim, Huyện Cần Giuộc, Tỉnh Long An',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'Cách trung tâm Quận 7 và Bình Chánh chỉ 15km, Nguồn lao động dồi dào, Đường Quốc lộ 50 xe container lưu thông 24/24, Đầy đủ tiện ích ngân hàng & dịch vụ',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2025/03/ban-dat-san-xuat-phan-bon-hoa-chat-khu-cong-nghiep-tan-kim-can-giuoc-long-an-1400x787.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=10.62,106.66&z=14&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Đất Công Nghiệp 10.000m² (1 ha) KCN Nam Đông Hà – Quảng Trị',
        'slug'  => 'ban-dat-cong-nghiep-10000m2-kcn-nam-dong-ha-quang-tri',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-dat-cong-nghiep-10000m2-kcn-nam-dong-ha-quang-tri.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-QT07',
            'dien_tich'         => '10.000 m² (1 ha)',
            'gia_thue'          => '$45/m²',
            'don_vi_tinh'       => 'Đất công nghiệp 50 năm',
            'loai_hinh'         => 'Đất Công Nghiệp Bán / Cho Thuê',
            'tinh_thanh'        => 'Quảng Trị',
            'vi_tri'            => 'KCN Nam Đông Hà, Phường Đông Lương, TP. Đông Hà, Quảng Trị',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'Đất sạch 100% bàn giao ngay, Thuế TNDN ưu đãi 10% trong 15 năm, Miễn thuế 4 năm đầu, Cách Cảng Cửa Việt 15km, Đường nội bộ rộng 24m',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-dat-cong-nghiep-10000m2-kcn-nam-dong-ha-quang-tri.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=16.78,107.10&z=13&output=embed"></iframe>'
        )
    ),
    array(
        'title' => 'Đất Công Nghiệp 30.000m² (3 ha) Chuẩn VSIP KCN QTIP – Quảng Trị',
        'slug'  => 'ban-dat-30000m2-3ha-kcn-qtip-quang-tri',
        'image' => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-dat-30000m2-3ha-kcn-qtip-quang-tri.jpg',
        'fields' => array(
            'ma_tin'            => 'KXD-DCN-QT08',
            'dien_tich'         => '30.000 m² (3 ha)',
            'gia_thue'          => '$65/m²',
            'don_vi_tinh'       => 'Đất công nghiệp sinh thái ESG',
            'loai_hinh'         => 'Đất Công Nghiệp Bán / Cho Thuê',
            'tinh_thanh'        => 'Quảng Trị',
            'vi_tri'            => 'KCN Quốc Tế Quảng Trị (QTIP), Huyện Triệu Phong, Tỉnh Quảng Trị',
            'trang_thai'        => 'CHO THUÊ 50 NĂM',
            'tien_ich_list'     => 'Liên doanh VSIP - Amata - Sumitomo, Tiêu chuẩn KCN sinh thái xanh ESG, Cách Cảng nước sâu Mỹ Thủy 8km, Trạm điện 126MVA chuyên dụng',
            'anh_thuc_te'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/ban-dat-30000m2-3ha-kcn-qtip-quang-tri.jpg',
            'google_map_embed'  => '<iframe src="https://maps.google.com/maps?q=16.71,107.21&z=13&output=embed"></iframe>'
        )
    )
);

// =========================================================================
// 3. TẠO CATEGORIES VÀ IMPORT BÀI VIẾT KÈM TEMPLATE SINGLE-PRODUCT.PHP
// =========================================================================

function get_or_create_cat_term($name, $slug) {
    $term = term_exists($name, 'category');
    if (!$term) {
        $term = wp_insert_term($name, 'category', array('slug' => $slug));
    }
    if (is_array($term)) {
        return $term['term_id'];
    } elseif (is_object($term)) {
        return $term->term_id;
    }
    return 1;
}

$cat_kho_xuong_id = get_or_create_cat_term('Kho Xưởng', 'kho-xuong');
$cat_dat_cn_id    = get_or_create_cat_term('Đất Công Nghiệp', 'dat-cong-nghiep');

$created_count = 0;
$updated_count = 0;

echo '<div style="font-family:Arial, sans-serif; max-width:900px; margin:40px auto; padding:30px; background:#ffffff; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.1); color:#000000; line-height:1.8;">';
echo '<h2 style="color:#0f7f2f; border-bottom:2px solid #0f7f2f; padding-bottom:12px; margin-top:0;">🚀 TỰ ĐỘNG KHỞI TẠO 16 SẢN PHẨM KHO XƯỞNG & ĐẤT CÔNG NGHIỆP (ẢNH THẬT 100%):</h2>';

function import_single_product_batch($items, $cat_id, $category_label, &$created_count, &$updated_count) {
    echo "<h3 style='color:#000000; margin-top:20px; border-left:4px solid #0f7f2f; padding-left:10px;'>📂 Danh mục: {$category_label}</h3><ul style='padding-left:20px;'>";

    foreach ($items as $item) {
        $post_type = post_type_exists('khu-cong-nghiep') ? 'khu-cong-nghiep' : 'post';

        $existing_query = new WP_Query(array(
            'name'        => $item['slug'],
            'post_type'   => array('post', 'khu-cong-nghiep'),
            'post_status' => 'any',
            'posts_per_page' => 1
        ));

        $post_id = 0;

        if ($existing_query->have_posts()) {
            $existing_query->the_post();
            $post_id = get_the_ID();
            wp_reset_postdata();

            wp_update_post(array(
                'ID'            => $post_id,
                'post_title'    => $item['title'],
                'post_category' => array($cat_id)
            ));

            $updated_count++;
            echo "<li style='color:#27ae60;'>🔄 Đã cập nhật sản phẩm: <strong>{$item['title']}</strong> (ID: {$post_id})</li>";
        } else {
            $post_data = array(
                'post_title'    => $item['title'],
                'post_name'     => $item['slug'],
                'post_status'   => 'publish',
                'post_type'     => $post_type,
                'post_category' => array($cat_id)
            );

            $post_id = wp_insert_post($post_data);
            $created_count++;
            echo "<li style='color:#0f7f2f;'>✅ Đã tạo mới thành công: <strong>{$item['title']}</strong> (ID: {$post_id})</li>";
        }

        if ($post_id && !is_wp_error($post_id)) {
            // Gán Template Chi Tiết Sản Phẩm single-product.php
            update_post_meta($post_id, '_wp_page_template', 'single-product.php');

            // Cập nhật các trường Custom Fields / ACF
            foreach ($item['fields'] as $key => $val) {
                update_post_meta($post_id, $key, $val);
                if (function_exists('update_field')) {
                    update_field($key, $val, $post_id);
                }
            }
        }
    }
    echo '</ul>';
}

// Chạy import Kho Xưởng
import_single_product_batch($kho_xuong_list, $cat_kho_xuong_id, 'Kho Xưởng Cho Thuê', $created_count, $updated_count);

// Chạy import Đất Công Nghiệp
import_single_product_batch($dat_cong_nghiep_list, $cat_dat_cn_id, 'Đất Công Nghiệp Cho Thuê & Bán', $created_count, $updated_count);

echo "<div style='background:#f0fdf4; border:1px solid #dcfce7; padding:15px 20px; border-radius:8px; margin-top:20px;'>";
echo "<h3 style='color:#0f7f2f; margin:0 0 8px;'>🎉 HOÀN THÀNH XUẤT SẮC!</h3>";
echo "<p style='margin:0;'>Đã tạo mới <strong>{$created_count}</strong> sản phẩm và cập nhật <strong>{$updated_count}</strong> sản phẩm với 100% Ảnh Thật HD và gán Template <code>single-product.php</code>!</p>";
echo "</div>";
echo "<p style='margin-top:20px;'>👉 Bạn có thể vào <strong>Admin WordPress -> Bài viết</strong> hoặc click vào bất kỳ sản phẩm nào từ trang listing để thấy giao diện chi tiết hoàn chỉnh!</p>";
echo "<p style='color:#c0392b; font-weight:bold;'>⚠️ ĐỪNG QUÊN: Hãy xóa file <code>import-kho-xuong-dat-cn.php</code> này khỏi theme sau khi hoàn tất để bảo mật website.</p>";
echo '</div>';
