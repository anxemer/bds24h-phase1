<?php
/**
 * TEN FILE: import-tin-tuc.php
 * MUC DICH: TU DONG TAO 6 BAI VIET TIN TUC tu news-detail.html
 * CACH DUNG: Upload vao thu muc theme, dang nhap Admin WP, truy cap file qua URL, roi xoa file sau khi chay xong
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    die('<h2 style="color:red;">Khong tim thay wp-load.php. Hay dat file import-tin-tuc.php vao thu muc theme hoac thu muc goc WordPress.</h2>');
}

if (defined('ABSPATH')) {
    require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');
    require_once(ABSPATH . 'wp-admin/includes/post.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
}

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('<h3 style="color:red; font-family:Arial; padding:20px;">Ban can DANG NHAP Admin WordPress truoc khi truy cap trang nay.</h3>');
}

// 6 BAI VIET TIN TUC tu news-detail.html
$tin_tuc_list = array(
    array(
        'title' => 'Môi giới kho xưởng Quảng Trị: Công ty nào chuyên và uy tín?',
        'slug'  => 'moi-gioi-kho-xuong-quang-tri',
        'fields' => array(
            'loai_bai'         => 'Phân tích thị trường - Quảng Trị',
            'ten_tac_gia'      => 'Ban Biên Tập BDS24H',
            'chuyen_san'       => 'Chuyên san Tin tức & Phân tích BĐS Công nghiệp',
            'thoi_gian_doc'    => '4 phút',
            'luot_xem'         => '1.420',
            'hero_image'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/moi-gioi-kho-xuong-quang-tri-cong-ty-chuyen-768x432.png',
            'hero_image_caption' => 'Thị trường bất động sản công nghiệp Quảng Trị đang thu hút dòng vốn FDI mạnh mẽ nhờ cảng Mỹ Thủy và hành lang EWEC.',
            'lead_paragraph'   => 'Sự phát triển đột phá của hạ tầng giao thông phía Bắc miền Trung, đặc biệt là dự án cảng biển nước sâu Mỹ Thủy và Hành lang Kinh tế Đông - Tây (EWEC), đang biến Quảng Trị trở thành điểm đến hấp dẫn mới cho các nhà đầu tư kho xưởng và nhà máy sản xuất.',
            'muc_luc'          => "1. Tiềm năng thị trường kho xưởng Quảng Trị năm 2026|#sec1-1\n2. Tiêu chí lựa chọn đơn vị môi giới kho xưởng uy tín|#sec1-2\n3. Vì sao nên hợp tác cùng dịch vụ môi giới chuyên nghiệp?|#sec1-3\n4. Tổng kết & Đầu mối hỗ trợ tư vấn trực tiếp|#sec1-4",
            'noi_dung_chinh'   => '<h2 id="sec1-1">1. Tiềm năng thị trường kho xưởng Quảng Trị năm 2026</h2><p>Quảng Trị có vị trí địa lý chiến lược khi là điểm đầu phía Việt Nam của Hành lang Kinh tế Đông - Tây kết nối trực tiếp sang Lào, Thái Lan và Myanmar. Việc triển khai các dự án quy mô lớn như KCN Quảng Trị (QTIP), KCN Nam Đông Hà và Cảng nước sâu Mỹ Thủy đã tạo ra làn sóng nhu cầu thuê đất KCN và kho xưởng xây sẵn tăng đột biến.</p><h2 id="sec1-2">2. Tiêu chí lựa chọn đơn vị môi giới kho xưởng uy tín</h2><p>Khi tìm kiếm đơn vị môi giới và tư vấn mặt bằng sản xuất tại Quảng Trị, doanh nghiệp cần lưu ý 4 tiêu chí cốt lõi:</p><ul><li><b>Nắm rõ pháp lý quy hoạch:</b> Đơn vị môi giới phải nắm chính xác quy hoạch 1/500, giấy phép PCCC, báo cáo ĐTM và điều kiện cấp phép ngành nghề của từng KCN.</li><li><b>Quỹ đất và xưởng phong phú:</b> Có dữ liệu cập nhật liên tục về nguồn hàng đất công nghiệp, xưởng xây sẵn và xưởng ký gửi.</li><li><b>Kết nối trực tiếp chủ đầu tư:</b> Hỗ trợ đàm phán trực tiếp với các đơn vị như QTIP, Becamex hay ban quản lý khu kinh tế.</li><li><b>Đồng hành pháp lý sau ký kết:</b> Hỗ trợ doanh nghiệp xin cấp Giấy chứng nhận đầu tư (IRC) và Đăng ký doanh nghiệp (ERC).</li></ul><h2 id="sec1-3">3. Vì sao nên hợp tác cùng dịch vụ môi giới chuyên nghiệp?</h2><p>Khoxuongdep.com.vn và BDS24H là hai đơn vị uy tín hàng đầu trong lĩnh vực tư vấn bất động sản công nghiệp. Chúng tôi sở hữu mạng lưới dữ liệu chuyên sâu tại khu vực miền Trung, giúp doanh nghiệp tiết kiệm 70% thời gian khảo sát thực địa và tối ưu chi phí đàm phán giá thuê.</p><h2 id="sec1-4">4. Tổng kết & Đầu mối hỗ trợ tư vấn trực tiếp</h2><p>Doanh nghiệp có nhu cầu thuê kho xưởng, khảo sát mặt bằng hoặc ký gửi bất động sản công nghiệp tại Quảng Trị có thể liên hệ ngay bộ phận chuyên trách BDS24H để nhận hồ sơ pháp lý và bảng giá chi tiết.</p>',
            'quote_box'        => 'Quảng Trị không chỉ là cầu nối vận tải bộ xuyên quốc gia mà còn cung cấp mức giá thuê đất KCN cạnh tranh chỉ từ $50/m² - thấp hơn 40% so với khu vực Đông Nam Bộ.',
            'highlight_title'  => 'Lưu ý quan trọng cho nhà đầu tư:',
            'highlight_box'    => 'Nhiều khu vực kho xưởng tự do ngoài KCN có thể gặp vướng mắc về thủ tục PCCC hoặc quy hoạch sử dụng đất. Nên ưu tiên chọn các nhà xưởng nằm trong KCN đã được phê duyệt hạ tầng hoàn chỉnh.',
            'the_tags'         => 'môi giới kho xưởng Quảng Trị, KCN QTIP, bất động sản công nghiệp, kho xưởng miền Trung',
            'cta_sidebar_title' => 'CẦN TƯ VẤN MẶT BẰNG BĐS?',
            'cta_sidebar_desc' => 'Nhận báo giá, hồ sơ pháp lý và khảo sát thực địa miễn phí 24/7.',
            'hotline'          => '0909161824',
            'link_zalo'        => 'https://zalo.me/0909161824',
            'nguon_url'        => 'https://khoxuongdep.com.vn/moi-gioi-kho-xuong-quang-tri-cong-ty-chuyen/',
            'nguon_ten'        => 'Khoxuongdep.com.vn',
        )
    ),
    array(
        'title' => 'KCN QTIP Quảng Trị: Cho thuê đất KCN, kho xưởng',
        'slug'  => 'kcn-qtip-quang-tri-cho-thue-dat',
        'fields' => array(
            'loai_bai'         => 'Khu công nghiệp - Quảng Trị',
            'ten_tac_gia'      => 'Ban Biên Tập BDS24H',
            'chuyen_san'       => 'Thông tin dự án BĐS Công nghiệp',
            'thoi_gian_doc'    => '5 phút',
            'luot_xem'         => '2.180',
            'hero_image'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-qtip-quang-tri-cho-thue-dat-kcn-kho-xuong-1400x788.jpg',
            'hero_image_caption' => 'Khu công nghiệp Quảng Trị (QTIP) được phát triển bởi liên doanh Singapore & BRG.',
            'lead_paragraph'   => 'Dự án KCN QTIP Quảng Trị có quy mô 827 ha, hạ tầng hiện đại tiêu chuẩn Singapore, cung cấp đất công nghiệp thuê lâu dài và xưởng xây sẵn hoàn thiện pháp lý.',
            'muc_luc'          => "1. Tổng quan dự án KCN Quảng Trị (QTIP)|#sec2-1\n2. Quy hoạch & hạ tầng tiêu chuẩn Singapore|#sec2-2\n3. Chính sách ưu đãi thuế vượt trội|#sec2-3\n4. Ngành nghề ưu tiên thu hút đầu tư|#sec2-4\n5. Cách tiếp cận và đăng ký thuê đất KCN|#sec2-5",
            'noi_dung_chinh'   => '<h2 id="sec2-1">1. Tổng quan dự án KCN Quảng Trị (QTIP)</h2><p>KCN Quảng Trị (QTIP) có quy mô 827 ha, tọa lạc tại thị xã Quảng Trị và huyện Hải Lăng - nằm ở trung tâm giao điểm của Hành lang Kinh tế Đông - Tây (EWEC). Đây là dự án KCN xanh được phát triển bởi liên doanh giữa BRG Group (Việt Nam) và tập đoàn Sembcorp (Singapore), áp dụng tiêu chuẩn vận hành sinh thái hàng đầu khu vực.</p><h2 id="sec2-2">2. Quy hoạch & hạ tầng tiêu chuẩn Singapore</h2><p>QTIP được thiết kế theo mô hình khu công nghiệp sinh thái với hệ thống hạ tầng khép kín:</p><ul><li><b>Điện:</b> Trạm biến áp 110kV riêng biệt, nguồn điện ổn định 24/7, dự phòng máy phát.</li><li><b>Nước sạch:</b> Nhà máy xử lý nước đạt chuẩn QCVN 01:2009/BYT, cung cấp 10.000 m³/ngày.</li><li><b>Xử lý nước thải:</b> Hệ thống xử lý tập trung đạt chuẩn QCVN 40:2011/BTNMT.</li><li><b>Internet & viễn thông:</b> Cáp quang FTTH tốc độ cao, kết nối đa nhà mạng Viettel, VNPT, FPT.</li><li><b>Đường nội bộ:</b> Mặt đường 22-40m, phân làn rõ ràng, không tải trọng giới hạn cho xe container.</li></ul><h2 id="sec2-3">3. Chính sách ưu đãi thuế vượt trội</h2><p>Vì nằm trong Khu Kinh tế Đông Nam Quảng Trị, QTIP được hưởng chính sách ưu đãi đặc biệt theo Nghị định 35/2022/NĐ-CP:</p><ul><li>Miễn thuế Thu nhập doanh nghiệp (TNDN) <b>4 năm đầu tiên</b>.</li><li>Giảm <b>50% thuế TNDN</b> trong 9 năm tiếp theo.</li><li>Áp dụng <b>thuế suất ưu đãi 10%</b> trong suốt 15 năm đầu hoạt động.</li><li>Miễn tiền thuê đất <b>15 năm</b> đối với dự án công nghệ cao.</li></ul><h2 id="sec2-4">4. Ngành nghề ưu tiên thu hút đầu tư</h2><ul><li>Chế biến, chế tạo linh kiện điện tử, bán dẫn và điện tử tiêu dùng.</li><li>Công nghiệp hỗ trợ ngành dệt may, giày dép xuất khẩu.</li><li>Logistics, kho lạnh, kho bãi phục vụ hành lang EWEC.</li><li>Chế biến nông - thủy sản xuất khẩu.</li><li>Năng lượng tái tạo, công nghệ xanh và vật liệu xây dựng cao cấp.</li></ul><h2 id="sec2-5">5. Cách tiếp cận và đăng ký thuê đất KCN</h2><ol><li><b>Khảo sát & lựa chọn lô đất:</b> Nhà đầu tư làm việc trực tiếp với ban quản lý.</li><li><b>Ký Biên bản ghi nhớ (MOU):</b> Khóa giữ lô đất trong khi doanh nghiệp hoàn thiện hồ sơ pháp lý.</li><li><b>Xin cấp Giấy chứng nhận đăng ký đầu tư (IRC):</b> Xử lý trong 15-20 ngày làm việc.</li><li><b>Ký Hợp đồng thuê đất và hạ tầng:</b> Thời hạn thuê tối đa 50 năm, gia hạn tối đa 50 năm.</li><li><b>Xây dựng & vận hành:</b> Hỗ trợ xin phép xây dựng, PCCC và kết nối hạ tầng trong vòng 60 ngày.</li></ol>',
            'quote_box'        => 'KCN QTIP là đại diện tiêu biểu nhất cho mô hình khu công nghiệp thế hệ mới tại miền Trung Việt Nam - quy hoạch đồng bộ, hạ tầng hiện đại và chính sách ưu đãi vượt trội.',
            'highlight_title'  => 'Kết nối logistics chiến lược:',
            'highlight_box'    => 'Cách cảng Mỹ Thủy 15 km, cách Quốc lộ 1A 3 km, kết nối thẳng sang cửa khẩu Lao Bảo (Lào) qua Quốc lộ 9 - thuận tiện xuất hàng bộ xuyên EWEC.',
            'the_tags'         => 'KCN QTIP Quảng Trị, thuê đất KCN, khu công nghiệp Quảng Trị, BRG Sembcorp',
            'cta_sidebar_title' => 'TƯ VẤN KCN QTIP QUẢNG TRỊ',
            'cta_sidebar_desc' => 'Nhận sơ đồ quy hoạch 1/500 và bảng giá thuê mới nhất - miễn phí.',
            'hotline'          => '0909161824',
            'link_zalo'        => 'https://zalo.me/0909161824',
            'nguon_url'        => 'https://khoxuongdep.com.vn/kcn-qtip-quang-tri-cho-thue-dat-kcn-kho-xuong/',
            'nguon_ten'        => 'Khoxuongdep.com.vn',
        )
    ),
    array(
        'title' => 'Điều khoản cho thuê đất và hạ tầng KCN Thủ Thừa Long An',
        'slug'  => 'dieu-khoan-cho-thue-dat-ha-tang-kcn-thu-thua',
        'fields' => array(
            'loai_bai'         => 'Pháp lý & Đầu tư - Long An',
            'ten_tac_gia'      => 'Ban Biên Tập BDS24H',
            'chuyen_san'       => 'Pháp lý BĐS Công nghiệp',
            'thoi_gian_doc'    => '4 phút',
            'luot_xem'         => '1.850',
            'hero_image'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/04/kcn-thu-thua-long-an-1-768x432.jpg',
            'hero_image_caption' => 'KCN Thủ Thừa có vị trí đắc địa cạnh đường cao tốc N2 kết nối TP.HCM và miền Tây.',
            'lead_paragraph'   => 'Phân tích chi tiết hợp đồng thuê đất, chi phí vận hành hàng năm và các điều khoản pháp lý quan trọng khi đầu tư nhà máy tại KCN Thủ Thừa Long An.',
            'muc_luc'          => "1. Tổng quan KCN Thủ Thừa và vị trí chiến lược|#sec3-1\n2. Chi phí thuê đất và vận hành hàng năm|#sec3-2\n3. Điều khoản hợp đồng quan trọng cần lưu ý|#sec3-3\n4. Ưu đãi đầu tư tại Long An|#sec3-4\n5. Thủ tục pháp lý & quy trình ký kết|#sec3-5",
            'noi_dung_chinh'   => '<h2 id="sec3-1">1. Tổng quan KCN Thủ Thừa và vị trí chiến lược</h2><p>KCN Thủ Thừa nằm tại huyện Thủ Thừa, tỉnh Long An - cách TP.HCM chỉ 35 km theo đường cao tốc N2 (Đức Hòa - Mỹ An). Với diện tích quy hoạch hơn 653 ha, KCN Thủ Thừa do Công ty IDICO và UDIC phát triển, là một trong những KCN lớn nhất Long An với tỷ lệ lấp đầy trên 75%.</p><h2 id="sec3-2">2. Chi phí thuê đất và vận hành hàng năm</h2><p>Bảng chi phí tham khảo tại KCN Thủ Thừa (cập nhật Q3/2026):</p><ul><li><b>Giá thuê đất:</b> $130 - $155/m² cho toàn bộ chu kỳ thuê (50 năm).</li><li><b>Phí quản lý hạ tầng:</b> 0,04 USD/m²/tháng (khoảng 480 USD/m²/năm).</li><li><b>Giá điện (EVN):</b> Giờ bình thường 1.728 đ/kWh - Cao điểm 3.015 đ/kWh - Thấp điểm 975 đ/kWh.</li><li><b>Giá nước sạch:</b> 7.500 - 8.500 đ/m³ tùy lưu lượng sử dụng.</li><li><b>Xử lý nước thải:</b> 5.000 - 6.500 đ/m³ (tùy nồng độ ô nhiễm).</li></ul><h2 id="sec3-3">3. Điều khoản hợp đồng quan trọng cần lưu ý</h2><ul><li><b>Điều khoản điều chỉnh giá:</b> Phí quản lý hạ tầng có thể điều chỉnh mỗi 3 năm, tối đa không quá 5% mỗi lần điều chỉnh.</li><li><b>Điều khoản ngành nghề:</b> Một số ngành gây ô nhiễm cao bị hạn chế hoặc yêu cầu bổ sung hệ thống xử lý riêng.</li><li><b>Thời hạn khởi công:</b> Nhà đầu tư phải khởi công xây dựng trong vòng 12 tháng kể từ khi ký hợp đồng.</li><li><b>Ký quỹ:</b> Thường yêu cầu đặt cọc tương đương 3 tháng phí hạ tầng trước khi bàn giao mặt bằng.</li></ul><h2 id="sec3-4">4. Ưu đãi đầu tư tại Long An</h2><ul><li>Ưu đãi thuế TNDN: miễn 2 năm, giảm 50% trong 4 năm tiếp theo.</li><li>Hỗ trợ đào tạo lao động địa phương: tối đa 3 triệu đồng/lao động từ ngân sách tỉnh.</li><li>Miễn tiền thuê đất 3 năm đầu với dự án ưu tiên.</li><li>Rút ngắn thời gian cấp phép xây dựng xuống còn 10-15 ngày làm việc.</li></ul><h2 id="sec3-5">5. Thủ tục pháp lý & quy trình ký kết</h2><ol><li><b>Nộp hồ sơ đăng ký đầu tư:</b> Tại Ban Quản lý KCN Long An - cần đủ hồ sơ pháp lý doanh nghiệp, dự án đầu tư và cam kết môi trường.</li><li><b>Thẩm định & cấp IRC:</b> Thời hạn 15-20 ngày làm việc.</li><li><b>Ký Hợp đồng thuê đất:</b> Giữa nhà đầu tư và Công ty phát triển hạ tầng KCN.</li><li><b>Bàn giao mặt bằng & xây dựng:</b> Có thể bắt đầu xây dựng sau khi hoàn thành nghĩa vụ tài chính theo hợp đồng.</li></ol>',
            'quote_box'        => 'Thủ Thừa là lựa chọn hàng đầu cho các doanh nghiệp muốn tiếp cận thị trường TP.HCM mà không chịu chi phí mặt bằng cao như trong nội thành hay các KCN vùng ven.',
            'highlight_title'  => 'Lưu ý:',
            'highlight_box'    => 'Giá thuê đất tại Thủ Thừa thấp hơn 25-35% so với các KCN tại Bình Dương, Đồng Nai và vùng ven TP.HCM, nhưng vẫn đảm bảo kết nối logistics đến cảng Cát Lái trong vòng 60 phút.',
            'the_tags'         => 'KCN Thủ Thừa Long An, thuê đất KCN Long An, điều khoản hợp đồng KCN, IDICO Long An',
            'cta_sidebar_title' => 'TƯ VẤN KCN THỦ THỪA',
            'cta_sidebar_desc' => 'Hỗ trợ đàm phán hợp đồng & thủ tục cấp phép IRC/ERC miễn phí.',
            'hotline'          => '0909161824',
            'link_zalo'        => 'https://zalo.me/0909161824',
            'nguon_url'        => 'https://khoxuongdep.com.vn/dieu-khoan-cho-thue-dat-ha-tang-kcn-thu-thua/',
            'nguon_ten'        => 'Khoxuongdep.com.vn',
        )
    ),
    array(
        'title' => 'KCN Cầu Cảng Phước Đông mở rộng giai đoạn 2 - Cơ hội lớn cho doanh nghiệp logistics',
        'slug'  => 'kcn-phuoc-dong-mo-rong-giai-doan-2',
        'fields' => array(
            'loai_bai'         => 'Tin thị trường - Long An',
            'ten_tac_gia'      => 'Ban Biên Tập BDS24H',
            'chuyen_san'       => 'Tin tức & Phân tích thị trường KCN',
            'thoi_gian_doc'    => '5 phút',
            'luot_xem'         => '3.210',
            'hero_image'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/khu-cong-nghiep-cau-cang-phuoc-dong-long-an.jpg',
            'hero_image_caption' => 'KCN Cầu Cảng Phước Đông - khu công nghiệp gần cảng nội địa tại Cần Giuộc, Long An.',
            'lead_paragraph'   => 'KCN Cầu Cảng Phước Đông (IPD) tại Cần Giuộc, Long An vừa công bố kế hoạch mở rộng giai đoạn 2 với diện tích bổ sung lên đến 150 ha, cùng việc nâng cấp hạ tầng cảng nội khu và xử lý nước thải lên 6.000 m³/ngày.',
            'muc_luc'          => "1. Tổng quan giai đoạn mở rộng|#sec4-1\n2. Nâng cấp hạ tầng cảng và logistics|#sec4-2\n3. Cơ hội cho doanh nghiệp cần cảng nội khu|#sec4-3\n4. Giá thuê và điều kiện đầu tư mới nhất|#sec4-4",
            'noi_dung_chinh'   => '<h2 id="sec4-1">1. Tổng quan giai đoạn mở rộng</h2><p>KCN Cầu Cảng Phước Đông do Công ty Cổ phần IMG Phước Đông (IPD) đầu tư và vận hành, hiện đã hoạt động với giai đoạn 1 diện tích 208 ha. Tỷ lệ lấp đầy đạt trên 82% tính đến Q2/2026, chủ yếu từ nhóm doanh nghiệp cơ khí, điện tử và logistics hưởng lợi từ vị trí cảng nội khu độc đáo trên sông Vàm Cỏ.</p><h2 id="sec4-2">2. Nâng cấp hạ tầng cảng và logistics</h2><p>Giai đoạn 2 dự kiến hoàn thành vào cuối năm 2027, bao gồm:</p><ul><li><b>Mở rộng bến cảng:</b> Bổ sung 2 cầu tàu mới, sức chứa lên đến 5.000 DWT, phục vụ sà lan container 40ft.</li><li><b>Xử lý nước thải:</b> Nâng công suất từ 3.000 lên 6.000 m³/ngày đạt cột A theo QCVN 40.</li><li><b>Điện:</b> Bổ sung trạm biến áp 63 MVA, đảm bảo điện ổn định cho toàn khu mở rộng.</li><li><b>Đường nội bộ:</b> Mở rộng trục chính 18m và hệ thống đường hậu cần 10m bao quanh khu cảng.</li></ul><h2 id="sec4-3">3. Cơ hội cho doanh nghiệp cần cảng nội khu</h2><p>Đây là cơ hội hiếm cho doanh nghiệp xuất khẩu trực tiếp qua đường thủy: hàng hóa có thể đưa từ nhà máy xuống sà lan ngay trong KCN mà không cần vận chuyển bộ đến cảng. Điều này tiết kiệm đáng kể chi phí logistics và thời gian so với các KCN thông thường.</p><h2 id="sec4-4">4. Giá thuê và điều kiện đầu tư mới nhất</h2><p>Giá thuê đất giai đoạn 2 dự kiến dao động <b>$150-175/m²</b> cho toàn chu kỳ 50 năm, cao hơn giai đoạn 1 khoảng 8-12% do vị trí sát cảng và hạ tầng nâng cấp. Các hình thức thuê bao gồm đất trống, nhà xưởng xây sẵn và xưởng thiết kế theo yêu cầu (BTS).</p>',
            'quote_box'        => 'Phước Đông là một trong số ít KCN miền Nam có cảng sông riêng ngay trong khu, cho phép vận chuyển container đường thủy trực tiếp mà không cần qua cảng trung gian.',
            'highlight_title'  => 'Lợi thế logistics độc đáo:',
            'highlight_box'    => 'Cách cảng quốc tế Long An 19 km, cảng Hiệp Phước 30 km và sân bay Tân Sơn Nhất 42 km - kết hợp đường thủy nội địa qua sông Vàm Cỏ tạo ra hành lang vận tải đa phương thức hoàn chỉnh.',
            'the_tags'         => 'KCN Phước Đông Long An, cảng nội khu, mở rộng KCN, logistics miền Nam',
            'cta_sidebar_title' => 'TƯ VẤN KCN PHƯỚC ĐÔNG',
            'cta_sidebar_desc' => 'Nhận sơ đồ giai đoạn 2 và bảng giá mới nhất - miễn phí.',
            'hotline'          => '0909161824',
            'link_zalo'        => 'https://zalo.me/0909161824',
            'nguon_url'        => 'https://khoxuongdep.com.vn/khu-cong-nghiep/khu-cong-nghiep-cau-cang-phuoc-dong-2/',
            'nguon_ten'        => 'Khoxuongdep.com.vn',
        )
    ),
    array(
        'title' => 'KCN Hựu Thạnh (IDICO): Cập nhật hạ tầng & ngành nghề ưu tiên 2026',
        'slug'  => 'kcn-huu-thanh-idico-cap-nhat-2026',
        'fields' => array(
            'loai_bai'         => 'Dự án mới - Long An',
            'ten_tac_gia'      => 'Ban Biên Tập BDS24H',
            'chuyen_san'       => 'Thông tin dự án BĐS Công nghiệp',
            'thoi_gian_doc'    => '4 phút',
            'luot_xem'         => '1.640',
            'hero_image'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/08/kcn-huu-thanh-long-an.jpg',
            'hero_image_caption' => 'KCN Hựu Thạnh do IDICO Corporation phát triển tại Đức Hòa, Long An - điểm đến logistics phía Tây TP.HCM.',
            'lead_paragraph'   => 'KCN Hựu Thạnh tại Đức Hòa, Long An - một trong những KCN lớn nhất phía Tây TP.HCM do IDICO Corporation vận hành - vừa hoàn thành nâng cấp toàn diện hệ thống điện, nước và xử lý nước thải trong năm 2026, đồng thời mở thêm quỹ đất sạch cho các nhà đầu tư mới.',
            'muc_luc'          => "1. Vị trí và tổng quan KCN Hựu Thạnh|#sec5-1\n2. Cập nhật hạ tầng kỹ thuật 2026|#sec5-2\n3. Ngành nghề ưu tiên và quỹ đất còn lại|#sec5-3\n4. Giá thuê và ưu đãi đầu tư|#sec5-4",
            'noi_dung_chinh'   => '<h2 id="sec5-1">1. Vị trí và tổng quan KCN Hựu Thạnh</h2><p>KCN Hựu Thạnh nằm tại thị trấn Hậu Nghĩa, huyện Đức Hòa, tỉnh Long An - cách Vành đai 3 TP.HCM khoảng 8 km và cách trung tâm TP.HCM 35 km theo đường tỉnh 825. Dự án do IDICO Corporation làm chủ đầu tư với tổng diện tích 653 ha, trong đó phần diện tích đất công nghiệp cho thuê khoảng 380 ha.</p><h2 id="sec5-2">2. Cập nhật hạ tầng kỹ thuật 2026</h2><p>Sau đợt đầu tư nâng cấp hạ tầng hoàn thành tháng 6/2026, KCN Hựu Thạnh hiện cung cấp:</p><ul><li><b>Điện:</b> Trạm biến áp 22KV riêng biệt, công suất nâng lên 80 MVA.</li><li><b>Nước sạch:</b> Nhà máy nước 20.000 m³/ngày đạt QCVN 01-1:2018/BYT - kết nối ống 300mm đến hàng rào từng lô.</li><li><b>Xử lý nước thải:</b> Nhà máy XLNT tập trung 14.400 m³/ngày vừa nâng cấp hệ thống bùn hoạt tính đạt cột A QCVN 40.</li><li><b>Viễn thông:</b> Cáp quang FTTH sẵn sàng đến từng lô đất, hỗ trợ kết nối đa nhà mạng.</li><li><b>Đường nội bộ:</b> Trục đường 22m hoàn thiện nhựa nóng, tải trọng không hạn chế.</li></ul><h2 id="sec5-3">3. Ngành nghề ưu tiên và quỹ đất còn lại</h2><p>KCN Hựu Thạnh đang tích cực thu hút đầu tư trong các lĩnh vực trọng điểm:</p><ul><li>Điện tử, bán dẫn và công nghệ cao (ưu tiên hàng đầu, tỷ lệ ưu đãi cao nhất).</li><li>Dược phẩm, thiết bị y tế và hóa chất công nghiệp tinh chế.</li><li>Thực phẩm chế biến đạt chứng nhận FSSC 22000, ISO 22000.</li><li>Bao bì công nghiệp, nhựa kỹ thuật và khuôn mẫu.</li><li>R&D, logistics và trung tâm phân phối khu vực.</li></ul><p>Quỹ đất sạch còn lại ước tính khoảng <b>45 ha</b> (tính đến tháng 8/2026), diện tích tối thiểu từ 1 ha.</p><h2 id="sec5-4">4. Giá thuê và ưu đãi đầu tư</h2><p>Mức giá thuê đất tại KCN Hựu Thạnh hiện dao động <b>$158 - $163/m²</b> cho toàn chu kỳ 50 năm. Doanh nghiệp đủ điều kiện được hưởng ưu đãi thuế TNDN: miễn 2 năm đầu, giảm 50% trong 4 năm tiếp theo. Nhóm công nghệ cao và R&D có thể được xem xét mức thuế ưu đãi 10% hoặc 17% trong thời gian dài hơn tùy quy mô dự án.</p>',
            'quote_box'        => 'Hựu Thạnh là lựa chọn hàng đầu của doanh nghiệp điện tử, R&D và ngành dược muốn gần TP.HCM nhưng tránh chi phí mặt bằng cao như Bình Dương hay Đồng Nai.',
            'highlight_title'  => 'Kết nối logistics:',
            'highlight_box'    => 'Cách cảng Long An 52 km, cảng Cát Lái 40 km, sân bay Tân Sơn Nhất 38 km. Kết nối thẳng Vành đai 3 khi dự án hoàn thành 2026-2027 sẽ rút ngắn đáng kể thời gian vận chuyển.',
            'the_tags'         => 'KCN Hựu Thạnh IDICO, Long An, cập nhật 2026, đất công nghiệp cho thuê',
            'cta_sidebar_title' => 'TƯ VẤN KCN HỰU THẠNH',
            'cta_sidebar_desc' => 'Nhận sơ đồ quy hoạch & bảng giá thuê đất mới nhất - miễn phí.',
            'hotline'          => '0909161824',
            'link_zalo'        => 'https://zalo.me/0909161824',
            'nguon_url'        => 'https://khoxuongdep.com.vn/khu-cong-nghiep/khu-cong-nghiep-huu-thanh-idico-huu-thanh/',
            'nguon_ten'        => 'Khoxuongdep.com.vn',
        )
    ),
    array(
        'title' => 'Xu hướng logistics miền Nam 2026: Kho tự động và chuỗi lạnh tăng mạnh',
        'slug'  => 'xu-huong-logistics-mien-nam-2026',
        'fields' => array(
            'loai_bai'         => 'Logistics - Phân tích thị trường',
            'ten_tac_gia'      => 'Ban Biên Tập BDS24H',
            'chuyen_san'       => 'Phân tích & Xu hướng thị trường',
            'thoi_gian_doc'    => '6 phút',
            'luot_xem'         => '4.850',
            'hero_image'       => 'https://khoxuongdep.com.vn/wp-content/uploads/2026/07/kcn-phu-my-ii.jpg',
            'hero_image_caption' => 'Các trung tâm logistics thông minh tại Long An, Bình Dương và Bà Rịa đang dẫn đầu làn sóng tự động hóa.',
            'lead_paragraph'   => 'Làn sóng bùng nổ thương mại điện tử, xuất khẩu nông sản tươi và dược phẩm đang thúc đẩy nhu cầu kho lạnh và kho bãi tự động hóa (ASRS) tại các tỉnh công nghiệp trọng điểm phía Nam tăng trưởng hơn 35% mỗi năm.',
            'muc_luc'          => "1. Sự trỗi dậy của kho lạnh và chuỗi cung ứng lạnh|#sec6-1\n2. Công nghệ tự động hóa ASRS trong kho xưởng mới|#sec6-2\n3. Các cụm logistics trọng điểm miền Nam|#sec6-3\n4. Dự báo giá thuê và lời khuyên cho nhà đầu tư|#sec6-4",
            'noi_dung_chinh'   => '<h2 id="sec6-1">1. Sự trỗi dậy của kho lạnh và chuỗi cung ứng lạnh</h2><p>Ngành chế biến thủy hải sản xuất khẩu, nông sản tươi và dược phẩm y tế đang đối mặt với yêu cầu bảo quản khắt khe theo chuẩn quốc tế (HACCP, ISO 22000, GDP). Điều này dẫn đến sự thiếu hụt nghiêm trọng diện tích kho lạnh đạt chuẩn tại khu vực Đông Nam Bộ và Đồng bằng sông Cửu Long. Các dự án kho lạnh mới tại Long An và TP.HCM ghi nhận tỷ lệ lấp đầy trên 90% chỉ sau 6 tháng đi vào vận hành.</p><h2 id="sec6-2">2. Công nghệ tự động hóa ASRS trong kho xưởng mới</h2><p>Hệ thống kho lưu trữ và truy xuất tự động (ASRS - Automated Storage and Retrieval System) đang được triển khai mạnh mẽ tại các trung tâm logistics thế hệ mới:</p><ul><li>Tăng <b>dung lượng lưu trữ lên 300-400%</b> trên cùng một diện tích sàn nhờ chiều cao trần nâng lên 24-32m.</li><li>Giảm <b>60% chi phí nhân công</b> vận hành kho hàng ngày.</li><li>Kiểm soát nhiệt độ đa vùng chính xác từ -25°C đến +15°C với hệ thống giám sát IoT theo thời gian thực.</li><li>Tốc độ bốc dỡ hàng container nhanh gấp 3 lần so với kho truyền thống.</li></ul><h2 id="sec6-3">3. Các cụm logistics trọng điểm miền Nam</h2><ul><li><b>Cụm Cát Lái - Phú Hữu (TP.HCM):</b> Trung tâm phân phối nội đô và xuất nhập khẩu hàng container đường biển.</li><li><b>Cụm Cần Giuộc - Bến Lức (Long An):</b> Đầu mối logistics kết nối TP.HCM với 13 tỉnh Đồng bằng sông Cửu Long.</li><li><b>Cụm Cái Mép - Thị Vải (Bà Rịa - Vũng Tàu):</b> Logistics cảng nước sâu đón tàu mẹ đi Mỹ và châu Âu trực tiếp.</li><li><b>Cụm Dĩ An - Sóng Thần (Bình Dương):</b> Hub phân phối hàng công nghiệp và linh kiện sản xuất.</li></ul><h2 id="sec6-4">4. Dự báo giá thuê và lời khuyên cho nhà đầu tư</h2><p>Giá thuê kho lạnh tiêu chuẩn hiện đạt mức <b>$16 - $24/tấn/tháng</b> hoặc <b>$1.2 - $1.8/pallet/ngày</b>. Đối với kho xưởng xây sẵn thông thường, giá thuê dao động <b>$4.2 - $6.5/m²/tháng</b> tùy vị trí.</p>',
            'quote_box'        => 'Logistics chuỗi lạnh và kho bãi tự động hóa không chỉ là xu hướng mà đã trở thành năng lực cạnh tranh sống còn của doanh nghiệp xuất khẩu Việt Nam trong giai đoạn 2026-2030.',
            'highlight_title'  => 'Cơ hội đầu tư:',
            'highlight_box'    => 'Các quỹ đầu tư ngoại (ESR, BW Industrial, Mapletree) đang tích cực tìm kiếm quỹ đất từ 5-20 ha tại Long An và Bà Rịa để phát triển các đại dự án Logistics Park tích hợp kho lạnh.',
            'the_tags'         => 'logistics miền Nam, kho tự động ASRS, kho lạnh, bất động sản công nghiệp 2026',
            'cta_sidebar_title' => 'TƯ VẤN KHO LOGISTICS',
            'cta_sidebar_desc' => 'Tìm quỹ đất & kho xưởng logistics phù hợp theo nhu cầu thực tế.',
            'hotline'          => '0909161824',
            'link_zalo'        => 'https://zalo.me/0909161824',
            'nguon_url'        => 'https://khoxuongdep.com.vn/danh-muc/tin-tuc/',
            'nguon_ten'        => 'Khoxuongdep.com.vn',
        )
    )
);

// Tao chuyen muc "Tin Tuc"
$cat_name = 'Tin Tuc BDS Cong Nghiep';
$cat_slug = 'tin-tuc-bds-cong-nghiep';
$cat_id   = 1;

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
echo '<h2 style="color:#0f7f2f; border-bottom:2px solid #0f7f2f; padding-bottom:12px; margin-top:0;">&#128640; TU DONG KHOI TAO 6 BAI VIET TIN TUC BDS CONG NGHIEP:</h2><ul style="padding-left:20px;">';

foreach ($tin_tuc_list as $tin) {
    $post_type = post_type_exists('tin-tuc') ? 'tin-tuc' : 'post';

    $existing_query = new WP_Query(array(
        'name'           => $tin['slug'],
        'post_type'      => array('post', 'tin-tuc'),
        'post_status'    => 'any',
        'posts_per_page' => 1
    ));

    $post_id = 0;

    if ($existing_query->have_posts()) {
        $existing_query->the_post();
        $post_id = get_the_ID();
        wp_reset_postdata();
        wp_update_post(array(
            'ID'           => $post_id,
            'post_content' => isset($tin['fields']['noi_dung_chinh']) ? $tin['fields']['noi_dung_chinh'] : '',
            'post_excerpt' => isset($tin['fields']['lead_paragraph']) ? $tin['fields']['lead_paragraph'] : ''
        ));
        $updated_count++;
        echo "<li style='color:#27ae60;'>🔄 Đã cập nhật dữ liệu: <strong>{$tin['title']}</strong> (ID: {$post_id})</li>";
    } else {
        $post_data = array(
            'post_title'    => $tin['title'],
            'post_name'     => $tin['slug'],
            'post_content'  => isset($tin['fields']['noi_dung_chinh']) ? $tin['fields']['noi_dung_chinh'] : '',
            'post_excerpt'  => isset($tin['fields']['lead_paragraph']) ? $tin['fields']['lead_paragraph'] : '',
            'post_status'   => 'publish',
            'post_type'     => $post_type,
            'post_category' => array($cat_id)
        );
        $post_id = wp_insert_post($post_data);
        $created_count++;
        echo "<li style='color:#0f7f2f;'>✅ Đã tạo mới thành công: <strong>{$tin['title']}</strong> (ID: {$post_id})</li>";
    }

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, '_wp_page_template', 'single-tin-tuc.php');

        foreach ($tin['fields'] as $key => $val) {
            update_post_meta($post_id, $key, $val);
            if (function_exists('update_field')) {
                update_field($key, $val, $post_id);
            }
        }
    }
}

echo '</ul>';
echo "<div style='background:#f0fdf4; border:1px solid #dcfce7; padding:15px 20px; border-radius:8px; margin-top:20px;'>";
echo "<h3 style='color:#0f7f2f; margin:0 0 8px;'>&#127881; HOAN THANH!</h3>";
echo "<p style='margin:0;'>Da tao moi <strong>{$created_count}</strong> bai viet va cap nhat <strong>{$updated_count}</strong> bai viet tin tuc kem toan bo thong tin ACF!</p>";
echo "</div>";
echo "<p style='margin-top:20px;'>&#128073; Bay gio ban co the mo <strong>Admin WordPress -> Posts (Bai viet)</strong> de thay tron bo 6 bai viet tin tuc da san sang!</p>";
echo "<p style='color:#c0392b; font-weight:bold;'>&#9888;&#65039; DUNG QUEN: Hay xoa file <code>import-tin-tuc.php</code> nay khoi theme sau khi hoan tat de bao mat website.</p>";
echo '</div>';
