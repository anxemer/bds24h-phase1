<?php
$pearl_include_path = get_template_directory() . '/includes/';
$pearl_admin_includes_path = $pearl_include_path . 'admin/';
$pearl_theme_include_path = $pearl_include_path . 'theme/';
$pearl_widgets_path = $pearl_include_path . '/widgets/';

/*Helpers*/
if (file_exists($pearl_theme_include_path . 'lib/array_helper.php')) {
    require_once($pearl_theme_include_path . 'lib/array_helper.php');
}

/*Theme setups (image sizes, content width, post supports, sidebars, menus);*/
if (file_exists($pearl_theme_include_path . 'setups.php')) {
    require_once($pearl_theme_include_path . 'setups.php');
}

/*Register scripts/styles*/
if (file_exists($pearl_theme_include_path . 'enqueue.php')) {
    require_once($pearl_theme_include_path . 'enqueue.php');
}

/*Custom theme functions*/
if (file_exists($pearl_theme_include_path . 'theme.php')) {
    require_once($pearl_theme_include_path . 'theme.php');
}
if (file_exists($pearl_theme_include_path . 'theme-ajax.php')) {
    require_once($pearl_theme_include_path . 'theme-ajax.php');
}
if (file_exists($pearl_theme_include_path . 'print_styles.php')) {
    require_once($pearl_theme_include_path . 'print_styles.php');
}
if (file_exists($pearl_theme_include_path . 'layout_config.php')) {
    require_once($pearl_theme_include_path . 'layout_config.php');
}
if (file_exists($pearl_theme_include_path . 'template_hooks.php')) {
    require_once($pearl_theme_include_path . 'template_hooks.php');
}
if (file_exists($pearl_theme_include_path . 'comments.php')) {
    require_once($pearl_theme_include_path . 'comments.php');
}
if (file_exists($pearl_theme_include_path . 'post_stats.php')) {
    require_once($pearl_theme_include_path . 'post_stats.php');
}

/*Header helper functions*/
if (file_exists($pearl_theme_include_path . 'header_helpers.php')) {
    require_once($pearl_theme_include_path . 'header_helpers.php');
}

/*WooCommerce*/
if (class_exists('WooCommerce') && file_exists($pearl_theme_include_path . '/woocommerce/woocommerce.php')) {
	require_once($pearl_theme_include_path . '/woocommerce/woocommerce.php');
}

if (defined('WPB_VC_VERSION') && file_exists($pearl_theme_include_path . '/vc/helpers.php')) {
	require_once($pearl_theme_include_path . '/vc/helpers.php');
	require_once($pearl_theme_include_path . '/vc/visual_composer.php');
	require_once($pearl_theme_include_path . '/vc/grid_builder.php');
}

/*Admin includes*/
if (is_admin()) {
	/*Product registration*/
	if (file_exists($pearl_admin_includes_path . '/product_registration/admin.php')) {
		require_once($pearl_admin_includes_path . '/product_registration/admin.php');
	}
	/*Theme options*/
	if (file_exists($pearl_admin_includes_path . 'theme_options/main.php')) {
		require_once($pearl_admin_includes_path . 'theme_options/main.php');
		require_once($pearl_admin_includes_path . 'theme_options/includes/presets.php');
		require_once($pearl_admin_includes_path . 'theme_options/includes/helpers.php');
		require_once($pearl_admin_includes_path . 'theme_options/screen.php');
		require_once($pearl_admin_includes_path . 'theme_options/includes/enqueue.php');
	}
	/*TGM for plugins registration*/
	if (file_exists($pearl_admin_includes_path . 'tgm/registration.php')) {
		require_once($pearl_admin_includes_path . 'tgm/registration.php');
	}
	/*Admins styles*/
	if (file_exists($pearl_admin_includes_path . 'enqueue.php')) {
		require_once($pearl_admin_includes_path . 'enqueue.php');
	}
	/*Visual composer*/
	if (defined('WPB_VC_VERSION') && file_exists($pearl_theme_include_path . '/vc/main.php')) {
		require_once($pearl_theme_include_path . '/vc/main.php');
	}
	/*admin helpers*/
	if (file_exists($pearl_admin_includes_path . '/admin_helpers.php')) {
		require_once($pearl_admin_includes_path . '/admin_helpers.php');
	}
	/*Taxonomy fields*/
	if (file_exists($pearl_admin_includes_path . '/taxonomy_fields/main.php')) {
		require_once($pearl_admin_includes_path . '/taxonomy_fields/main.php');
	}
}

function pearl_glob_pagenow(){
    global $pagenow;
    return $pagenow;
}

function pearl_glob_wpdb(){
    global $wpdb;
    return $wpdb;
}

// =========================================================================
// HÀM AN TOÀN CHỐNG LỖI THEME PEARL
// =========================================================================
if (!function_exists('pearl_body_bg')) {
    function pearl_body_bg() { return ''; }
}
if (!function_exists('pearl_get_header')) {
    function pearl_get_header() { return ''; }
}
if (!function_exists('pearl_get_title')) {
    function pearl_get_title() { return get_the_title(); }
}

// =========================================================================
// HÀM KIỂM TRA TRANG CÓ ĐANG SỬ DỤNG ELEMENTOR CANVAS HAY KHÔNG
// =========================================================================
function bds24h_is_elementor_canvas() {
    if (is_singular()) {
        $template = get_page_template_slug(get_the_ID());
        if ($template === 'elementor_canvas') {
            return true;
        }
        $meta_template = get_post_meta(get_the_ID(), '_wp_page_template', true);
        if ($meta_template === 'elementor_canvas') {
            return true;
        }
    }
    return false;
}

// =========================================================================
// 1. TỰ ĐỘNG CHÈN HEADER CUSTOM (MEGA SUBMENU 2 CẤP) VÀO WEBSITE
// =========================================================================
add_action('elementor/page_templates/header-footer/before_content', 'bds24h_custom_header_render', 1);
add_action('wp_body_open', 'bds24h_custom_header_render', 1);

function bds24h_custom_header_render() {
    // Nếu là trang Elementor Canvas -> Không hiển thị Header
    if (bds24h_is_elementor_canvas()) return;

    static $header_printed = false;
    if ($header_printed) return;
    $header_printed = true;
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,600;0,700;0,800;0,900;1,600;1,700;1,800&family=Roboto:wght@400;500;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div id="kx-header" class="kx-sticky">
        <div class="kx-header-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="kx-logo">
                <div class="kx-logo-main">
                    <img src="https://batdongsancongnghiep24h.vn/wp-content/uploads/2026/08/2-1.png" alt="Bất Động Sản Khu Công Nghiệp" class="kx-logo-icon">
                    <div class="kx-logo-brand">
                        <span class="kx-brand-sub">Bất động sản</span>
                        <span class="kx-brand-main">KHU CÔNG NGHIỆP<span class="kx-brand-vn">.vn</span></span>
                    </div>
                </div>
                <div class="kx-logo-slogan">Trang tin chuyên bất động sản công nghiệp</div>
            </a>

            <!-- DESKTOP NAV -->
            <nav class="kx-navigation">
                <ul class="kx-nav-list">
                    <li class="kx-nav-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                    </li>

                    <!-- Giới thiệu & Đối tác (Dropdown) -->
                    <li class="kx-nav-item kx-has-dropdown">
                        <a href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>" class="kx-nav-link">
                            Giới thiệu
                            <svg class="kx-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="kx-dropdown-menu">
                            <a href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>" class="kx-dropdown-item">
                                <span class="kx-dd-icon">🏛️</span>
                                <div class="kx-dd-text">
                                    <strong>Về chúng tôi</strong>
                                    <span>Giới thiệu nền tảng BĐS24H</span>
                                </div>
                            </a>
                            <a href="<?php echo esc_url(home_url('/doi-tac/')); ?>" class="kx-dropdown-item">
                                <span class="kx-dd-icon">🤝</span>
                                <div class="kx-dd-text">
                                    <strong>Đối tác liên kết</strong>
                                    <span>Mạng lưới đối tác & khách hàng</span>
                                </div>
                            </a>
                        </div>
                    </li>

                    <!-- Kho xưởng (2-Step Dropdown) -->
                    <li class="kx-nav-item kx-has-mega">
                        <a href="<?php echo esc_url(home_url('/kho-xuong/')); ?>" class="kx-nav-link">
                            Kho xưởng
                            <svg class="kx-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>

                        <!-- 2-STEP MEGA MENU KHO XƯỞNG -->
                        <div class="kx-mega-menu kx-stepped-menu">
                            <div class="kx-stepped-wrapper">
                                
                                <!-- BƯỚC 1: CHỌN VỊ TRÍ -->
                                <div class="kx-step1-col">
                                    <div>
                                        <div class="kx-step1-list">
                                            <!-- Trong KCN -->
                                            <div class="kx-step1-item is-active in-kcn" data-target="kx-wp-kx-in">
                                                <div class="kx-s1-icon">🏢</div>
                                                <div class="kx-s1-info">
                                                    <span class="kx-s1-title">Trong Khu Công Nghiệp</span>
                                                    <span class="kx-s1-desc">Hạ tầng chuẩn, PCCC, pháp lý</span>
                                                </div>
                                                <svg class="kx-s1-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                            </div>

                                            <!-- Ngoài KCN -->
                                            <div class="kx-step1-item out-kcn" data-target="kx-wp-kx-out">
                                                <div class="kx-s1-icon">🏭</div>
                                                <div class="kx-s1-info">
                                                    <span class="kx-s1-title">Ngoài Khu Công Nghiệp</span>
                                                    <span class="kx-s1-desc">Kho bãi độc lập, cont 24/7</span>
                                                </div>
                                                <svg class="kx-s1-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="<?php echo esc_url(home_url('/kho-xuong/')); ?>" class="kx-step1-all-link">
                                        <span>🔍 Xem tất cả Kho xưởng</span>
                                    </a>
                                </div>

                                <!-- BƯỚC 2: CHỌN MỨC GIÁ -->
                                <div class="kx-step2-col">
                                    
                                    <!-- Bảng giá: Trong KCN -->
                                    <div class="kx-step2-panel is-active" id="kx-wp-kx-in">
                                        <div class="kx-step2-groups">
                                            
                                            <!-- Cho thuê -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">🔑</span>
                                                    <span class="kx-gh-text">KHO XƯỞNG CHO THUÊ</span>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=0-50')); ?>">Dưới 50 tr/th</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=50-100')); ?>">50 – 100 triệu</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=100-200')); ?>">100 – 200 triệu</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=200-500')); ?>">200 – 500 triệu</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=500-1000')); ?>">500tr – 1 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=1000-999999999')); ?>">Trên 1 tỷ/th</a>
                                                </div>
                                            </div>

                                            <!-- Bán / Mua -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">🏷️</span>
                                                    <span class="kx-gh-text">BÁN / MUA KHO XƯỞNG</span>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=0-10000')); ?>">Dưới 10 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=10000-30000')); ?>">10 – 30 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=30000-50000')); ?>">30 – 50 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=50000-100000')); ?>">50 – 100 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=100000-999999999')); ?>">Trên 100 tỷ</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Bảng giá: Ngoài KCN -->
                                    <div class="kx-step2-panel" id="kx-wp-kx-out">
                                        <div class="kx-step2-groups">
                                            
                                            <!-- Cho thuê -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">🔑</span>
                                                    <span class="kx-gh-text">KHO XƯỞNG CHO THUÊ</span>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=0-50')); ?>">Dưới 50 tr/th</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=50-100')); ?>">50 – 100 triệu</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=100-200')); ?>">100 – 200 triệu</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=200-500')); ?>">200 – 500 triệu</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=500-1000')); ?>">500tr – 1 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=1000-999999999')); ?>">Trên 1 tỷ/th</a>
                                                </div>
                                            </div>

                                            <!-- Bán / Mua -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">🏷️</span>
                                                    <span class="kx-gh-text">BÁN / MUA KHO XƯỞNG</span>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=0-10000')); ?>">Dưới 10 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=10000-30000')); ?>">10 – 30 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=30000-50000')); ?>">30 – 50 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=50000-100000')); ?>">50 – 100 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=100000-999999999')); ?>">Trên 100 tỷ</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </li>

                    <!-- Đất công nghiệp (2-Step Dropdown) -->
                    <li class="kx-nav-item kx-has-mega">
                        <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/')); ?>" class="kx-nav-link">
                            Đất công nghiệp
                            <svg class="kx-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>

                        <!-- 2-STEP MEGA MENU ĐẤT CÔNG NGHIỆP -->
                        <div class="kx-mega-menu kx-stepped-menu">
                            <div class="kx-stepped-wrapper">
                                
                                <!-- BƯỚC 1: CHỌN VỊ TRÍ -->
                                <div class="kx-step1-col">
                                    <div>
                                        <div class="kx-step1-list">
                                            <!-- Trong KCN -->
                                            <div class="kx-step1-item is-active in-kcn" data-target="kx-wp-dat-in">
                                                <div class="kx-s1-icon">🏗️</div>
                                                <div class="kx-s1-info">
                                                    <span class="kx-s1-title">Trong Khu Công Nghiệp</span>
                                                    <span class="kx-s1-desc">Thời hạn 50 năm, đất sạch</span>
                                                </div>
                                                <svg class="kx-s1-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                            </div>

                                            <!-- Ngoài KCN -->
                                            <div class="kx-step1-item out-kcn" data-target="kx-wp-dat-out">
                                                <div class="kx-s1-icon">🌍</div>
                                                <div class="kx-s1-info">
                                                    <span class="kx-s1-title">Ngoài Khu Công Nghiệp</span>
                                                    <span class="kx-s1-desc">Đất SKC, TM-DV độc lập</span>
                                                </div>
                                                <svg class="kx-s1-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/')); ?>" class="kx-step1-all-link">
                                        <span>🔍 Xem tất cả Đất công nghiệp</span>
                                    </a>
                                </div>

                                <!-- BƯỚC 2: CHỌN MỨC GIÁ -->
                                <div class="kx-step2-col">
                                    
                                    <!-- Bảng giá: Trong KCN -->
                                    <div class="kx-step2-panel is-active" id="kx-wp-dat-in">
                                        <div class="kx-step2-groups">
                                            
                                            <!-- Cho thuê -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">📄</span>
                                                    <span class="kx-gh-text">ĐẤT CHO THUÊ (50 NĂM)</span>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=0-1000')); ?>">Dưới 1 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=1000-3000')); ?>">1 – 3 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=3000-5000')); ?>">3 – 5 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=5000-10000')); ?>">5 – 10 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=10000-20000')); ?>">10 – 20 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=20000-999999999')); ?>">Trên 20 tỷ</a>
                                                </div>
                                            </div>

                                            <!-- Chuyển nhượng -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">💼</span>
                                                    <span class="kx-gh-text">CHUYỂN NHƯỢNG / MUA BÁN</span>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=0-20000')); ?>">Dưới 20 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=20000-50000')); ?>">20 – 50 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=50000-100000')); ?>">50 – 100 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=100000-200000')); ?>">100 – 200 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=200000-999999999')); ?>">Trên 200 tỷ</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Bảng giá: Ngoài KCN -->
                                    <div class="kx-step2-panel" id="kx-wp-dat-out">
                                        <div class="kx-step2-groups">
                                            
                                            <!-- Cho thuê -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">📄</span>
                                                    <span class="kx-gh-text">ĐẤT CHO THUÊ NGOÀI KCN</span>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=0-1000')); ?>">Dưới 1 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=1000-3000')); ?>">1 – 3 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=3000-5000')); ?>">3 – 5 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=5000-10000')); ?>">5 – 10 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=10000-20000')); ?>">10 – 20 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=20000-999999999')); ?>">Trên 20 tỷ</a>
                                                </div>
                                            </div>

                                            <!-- Chuyển nhượng -->
                                            <div class="kx-step2-group">
                                                <div class="kx-group-heading">
                                                    <span class="kx-gh-icon">💼</span>
                                                    <span class="kx-gh-text">CHUYỂN NHƯỢNG / BÁN ĐẤT SKC</span>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong')); ?>" class="kx-gh-all">Tất cả ›</a>
                                                </div>
                                                <div class="kx-price-chips">
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=0-20000')); ?>">Dưới 20 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=20000-50000')); ?>">20 – 50 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=50000-100000')); ?>">50 – 100 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=100000-200000')); ?>">100 – 200 tỷ</a>
                                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=200000-999999999')); ?>">Trên 200 tỷ</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </li>

                    <!-- Khu công nghiệp -->
                    <li class="kx-nav-item">
                        <a href="<?php echo esc_url(home_url('/kcn/')); ?>">Khu công nghiệp</a>
                    </li>

                    <!-- Tin tức & Pháp luật (Dropdown) -->
                    <li class="kx-nav-item kx-has-dropdown">
                        <a href="<?php echo esc_url(home_url('/news-listing/')); ?>" class="kx-nav-link">
                            Tin tức
                            <svg class="kx-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="kx-dropdown-menu">
                            <a href="<?php echo esc_url(home_url('/news-listing/')); ?>" class="kx-dropdown-item">
                                <span class="kx-dd-icon">📰</span>
                                <div class="kx-dd-text">
                                    <strong>Tin tức thị trường</strong>
                                    <span>Thông tin & xu hướng BĐS KCN</span>
                                </div>
                            </a>
                            <a href="<?php echo esc_url(home_url('/phap-luat-dau-tu/')); ?>" class="kx-dropdown-item">
                                <span class="kx-dd-icon">⚖️</span>
                                <div class="kx-dd-text">
                                    <strong>Pháp luật đầu tư</strong>
                                    <span>Quy định & chính sách KCN</span>
                                </div>
                            </a>
                        </div>
                    </li>

                    <!-- MORE MENU -->
                    <li class="kx-more">
                        <button type="button" class="kx-more-button" aria-expanded="false">
                            <span class="kx-dots"><i></i><i></i><i></i></span>
                            <span class="kx-more-text">Thêm</span>
                        </button>
                        <div class="kx-more-dropdown">
                            <div class="kx-more-items"></div>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- RIGHT ACTIONS -->
            <div class="kx-header-actions">
                <a href="tel:0909161824" class="kx-menu-hotline-link">
                    <span class="kx-menu-hotline-icon">☎</span>
                    <span class="kx-hotline-label">Hotline: </span>
                    <strong class="kx-hotline-num">0909 161 824</strong>
                </a>
                <button type="button" class="kx-mobile-button" aria-label="Mở menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>

        <!-- MOBILE MENU ACCORDION DRAWER -->
        <div class="kx-mobile-menu">
            <div class="kx-mobile-inner">
                <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>

                <!-- Accordion Giới thiệu -->
                <div class="kx-mob-acc">
                    <div class="kx-mob-acc-head">
                        <a href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>">Giới thiệu</a>
                        <button type="button" class="kx-mob-toggle" aria-label="Toggle">▼</button>
                    </div>
                    <div class="kx-mob-acc-body">
                        <div class="kx-mob-links">
                            <a href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>" class="full">🏛️ Về chúng tôi (Giới thiệu BĐS24H)</a>
                            <a href="<?php echo esc_url(home_url('/doi-tac/')); ?>">🤝 Đối tác liên kết</a>
                        </div>
                    </div>
                </div>

                <!-- Accordion Kho Xưởng (2-Level) -->
                <div class="kx-mob-acc">
                    <div class="kx-mob-acc-head">
                        <a href="<?php echo esc_url(home_url('/kho-xuong/')); ?>">Kho xưởng</a>
                        <button type="button" class="kx-mob-toggle" aria-label="Toggle">▼</button>
                    </div>
                    <div class="kx-mob-acc-body">
                        
                        <!-- Sub-acc: Trong KCN -->
                        <div class="kx-mob-sub-acc">
                            <div class="kx-mob-sub-head">
                                <span class="kx-msh-title">🏢 Trong Khu Công Nghiệp</span>
                                <button type="button" class="kx-mob-sub-toggle" aria-label="Toggle">▼</button>
                            </div>
                            <div class="kx-mob-sub-body">
                                <div class="kx-mob-group-title">🔑 Kho xưởng cho thuê</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue')); ?>" class="full">Tất cả cho thuê trong KCN</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=0-50')); ?>">↳ Dưới 50 triệu/tháng</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=50-100')); ?>">↳ 50 – 100 triệu</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=100-200')); ?>">↳ 100 – 200 triệu</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=200-500')); ?>">↳ 200 – 500 triệu</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=500-1000')); ?>">↳ 500tr – 1 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=cho-thue&price=1000-999999999')); ?>">↳ Trên 1 tỷ/tháng</a>
                                </div>
                                <div class="kx-mob-group-title" style="margin-top:8px;">🏷️ Bán / Chuyển nhượng</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong')); ?>" class="full">Tất cả kho xưởng bán</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=0-10000')); ?>">↳ Dưới 10 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=10000-30000')); ?>">↳ 10 – 30 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=30000-50000')); ?>">↳ 30 – 50 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=50000-100000')); ?>">↳ 50 – 100 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=trong&type=chuyen-nhuong&price=100000-999999999')); ?>">↳ Trên 100 tỷ</a>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-acc: Ngoài KCN -->
                        <div class="kx-mob-sub-acc">
                            <div class="kx-mob-sub-head">
                                <span class="kx-msh-title">🏭 Ngoài Khu Công Nghiệp</span>
                                <button type="button" class="kx-mob-sub-toggle" aria-label="Toggle">▼</button>
                            </div>
                            <div class="kx-mob-sub-body">
                                <div class="kx-mob-group-title">🔑 Kho xưởng cho thuê</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue')); ?>" class="full">Tất cả cho thuê ngoài KCN</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=0-50')); ?>">↳ Dưới 50 triệu/tháng</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=50-100')); ?>">↳ 50 – 100 triệu</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=100-200')); ?>">↳ 100 – 200 triệu</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=200-500')); ?>">↳ 200 – 500 triệu</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=500-1000')); ?>">↳ 500tr – 1 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=cho-thue&price=1000-999999999')); ?>">↳ Trên 1 tỷ/tháng</a>
                                </div>
                                <div class="kx-mob-group-title" style="margin-top:8px;">🏷️ Bán / Chuyển nhượng</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong')); ?>" class="full">Tất cả kho xưởng bán</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=0-10000')); ?>">↳ Dưới 10 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=10000-30000')); ?>">↳ 10 – 30 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=30000-50000')); ?>">↳ 30 – 50 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=50000-100000')); ?>">↳ 50 – 100 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/kho-xuong/?kcn=ngoai&type=chuyen-nhuong&price=100000-999999999')); ?>">↳ Trên 100 tỷ</a>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo esc_url(home_url('/kho-xuong/')); ?>" style="display:block; padding:8px 10px; font-size:12.5px; font-weight:700; color:#15803d; text-decoration:none;">🔍 Xem tất cả Kho xưởng ›</a>

                    </div>
                </div>

                <!-- Accordion Đất Công Nghiệp (2-Level) -->
                <div class="kx-mob-acc">
                    <div class="kx-mob-acc-head">
                        <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/')); ?>">Đất công nghiệp</a>
                        <button type="button" class="kx-mob-toggle" aria-label="Toggle">▼</button>
                    </div>
                    <div class="kx-mob-acc-body">
                        
                        <!-- Sub-acc: Trong KCN -->
                        <div class="kx-mob-sub-acc">
                            <div class="kx-mob-sub-head">
                                <span class="kx-msh-title">🏗️ Trong Khu Công Nghiệp</span>
                                <button type="button" class="kx-mob-sub-toggle" aria-label="Toggle">▼</button>
                            </div>
                            <div class="kx-mob-sub-body">
                                <div class="kx-mob-group-title">📄 Đất cho thuê (50 năm)</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue')); ?>" class="full">Tất cả đất cho thuê KCN</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=0-1000')); ?>">↳ Dưới 1 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=1000-3000')); ?>">↳ 1 – 3 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=3000-5000')); ?>">↳ 3 – 5 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=5000-10000')); ?>">↳ 5 – 10 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=10000-20000')); ?>">↳ 10 – 20 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=cho-thue&price=20000-999999999')); ?>">↳ Trên 20 tỷ</a>
                                </div>
                                <div class="kx-mob-group-title" style="margin-top:8px;">💼 Chuyển nhượng / Bán</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong')); ?>" class="full">Tất cả đất chuyển nhượng</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=0-20000')); ?>">↳ Dưới 20 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=20000-50000')); ?>">↳ 20 – 50 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=50000-100000')); ?>">↳ 50 – 100 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=100000-200000')); ?>">↳ 100 – 200 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=trong&type=chuyen-nhuong&price=200000-999999999')); ?>">↳ Trên 200 tỷ</a>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-acc: Ngoài KCN -->
                        <div class="kx-mob-sub-acc">
                            <div class="kx-mob-sub-head">
                                <span class="kx-msh-title">🌍 Ngoài Khu Công Nghiệp</span>
                                <button type="button" class="kx-mob-sub-toggle" aria-label="Toggle">▼</button>
                            </div>
                            <div class="kx-mob-sub-body">
                                <div class="kx-mob-group-title">📄 Đất cho thuê ngoài KCN</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue')); ?>" class="full">Tất cả đất thuê ngoài KCN</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=0-1000')); ?>">↳ Dưới 1 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=1000-3000')); ?>">↳ 1 – 3 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=3000-5000')); ?>">↳ 3 – 5 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=5000-10000')); ?>">↳ 5 – 10 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=10000-20000')); ?>">↳ 10 – 20 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=cho-thue&price=20000-999999999')); ?>">↳ Trên 20 tỷ</a>
                                </div>
                                <div class="kx-mob-group-title" style="margin-top:8px;">💼 Bán / Chuyển nhượng đất SKC</div>
                                <div class="kx-mob-links">
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong')); ?>" class="full">Tất cả đất chuyển nhượng</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=0-20000')); ?>">↳ Dưới 20 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=20000-50000')); ?>">↳ 20 – 50 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=50000-100000')); ?>">↳ 50 – 100 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=100000-200000')); ?>">↳ 100 – 200 tỷ</a>
                                    <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/?kcn=ngoai&type=chuyen-nhuong&price=200000-999999999')); ?>">↳ Trên 200 tỷ</a>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo esc_url(home_url('/dat-cong-nghiep/')); ?>" style="display:block; padding:8px 10px; font-size:12.5px; font-weight:700; color:#15803d; text-decoration:none;">🔍 Xem tất cả Đất công nghiệp ›</a>

                    </div>
                </div>

                <a href="<?php echo esc_url(home_url('/kcn/')); ?>">Khu công nghiệp</a>

                <!-- Accordion Tin tức -->
                <div class="kx-mob-acc">
                    <div class="kx-mob-acc-head">
                        <a href="<?php echo esc_url(home_url('/news-listing/')); ?>">Tin tức</a>
                        <button type="button" class="kx-mob-toggle" aria-label="Toggle">▼</button>
                    </div>
                    <div class="kx-mob-acc-body">
                        <div class="kx-mob-links">
                            <a href="<?php echo esc_url(home_url('/news-listing/')); ?>" class="full">📰 Tin tức thị trường</a>
                            <a href="<?php echo esc_url(home_url('/phap-luat-dau-tu/')); ?>">⚖️ Pháp luật đầu tư</a>
                        </div>
                    </div>
                </div>

                <div class="kx-mobile-contact">
                    <a href="tel:0909161824">☎ Hotline: 0909 161 824</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// =========================================================================
// 2. TỰ ĐỘNG CHÈN FOOTER CĂN GIỮA
// =========================================================================
add_action('elementor/page_templates/header-footer/after_content', 'bds24h_custom_footer_render', 99);
add_action('wp_footer', 'bds24h_custom_footer_render', 1);

function bds24h_custom_footer_render() {
    // Nếu là trang Elementor Canvas -> Không hiển thị Footer
    if (bds24h_is_elementor_canvas()) return;

    static $footer_printed = false;
    if ($footer_printed) return;
    $footer_printed = true;
    ?>
    <footer class="bds-footer" id="kx-footer">
        <div class="bds-footer-bottom-wrap">
            <div class="bds-copyright-text">
                &copy; <?php echo date('Y'); ?> BDS24H. Tất cả quyền được bảo lưu.
            </div>
        </div>
    </footer>
    <?php
}

// =========================================================================
// 3. CSS ĐỊNH HÌNH RESPONSIVE, MEGA MENU & ẨN THEME CŨ
// =========================================================================
add_action('wp_head', 'bds24h_global_custom_styles', 999);
function bds24h_global_custom_styles() {
    ?>
    <style id="bds24h-global-styles">
        /* 1. MỞ RỘNG 100% CHO ELEMENTOR KHÔNG BỊ CO 2 BÊN */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        /* ẨN HEADER VÀ FOOTER TRÊN ELEMENTOR CANVAS */
        body.elementor-template-canvas #kx-header,
        body.elementor-template-canvas #kx-footer {
            display: none !important;
            height: 0 !important;
            visibility: hidden !important;
        }

        #main, #content, .site-content, .entry-content, .site, #page,
        .container, .row, .site-main, .pearl-main,
        .elementor-template-full-width, .elementor-page {
            max-width: 100% !important;
            width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            border: none !important;
            float: none !important;
        }

        /* 2. ẨN TRIỆT ĐỂ HEADER VÀ FOOTER GỐC CỦA PEARL THEME */
        body > header,
        #header,
        .pearl-header-wrap,
        .stm-header,
        .stm_mobile_header,
        .stm_mobile__switcher,
        .stm_mobile__menu,
        .stm_mobile__menu_active,
        .stm_mobile__menu_overlay,
        .stm-mobile-header,
        .stm-header-mobile,
        #stm_mobile_header,
        .stm_header_mobile,
        .pearl-mobile-header,
        div[class*="stm_mobile"],
        div[class*="mobile_header"],
        .top_bar,
        .top_nav,
        .stm-header-builder,
        header.pearl-header,
        header:not(#kx-header),
        div[class*="stm-header"],
        div[class*="pearl-header"],
        div[class*="header_default"],
        footer:not(#kx-footer),
        .stm-footer,
        .stm_footer,
        .pearl-footer,
        .pearl-footer-wrap,
        .stm_bottom_copyright,
        .stm_bottom_footer,
        .stm_copyrights,
        .stm_footer_bottom,
        .stm-footer__bottom,
        #footer,
        .site-footer,
        div[class*="stm_bottom"],
        div[class*="stm_copyright"],
        div[class*="stm_footer"],
        div[class*="pearl-footer"],
        div[class*="pearl_footer"],
        div[class*="footer_bottom"] {
            display: none !important;
            height: 0 !important;
            min-height: 0 !important;
            max-height: 0 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            position: absolute !important;
            top: -99999px !important;
            overflow: hidden !important;
        }

        /* 3. CSS HEADER CUSTOM CHUẨN */
        #kx-header, #kx-header * { box-sizing: border-box !important; }
        #kx-header {
            --kx-primary: #16c04a;
            --kx-primary-dark: #0f7f2f;
            --kx-red: #c4161c;
            --kx-text: #0f172a;
            --kx-muted: #64748b;
            --kx-border: #e2e8f0;
            --kx-bg: #ffffff;
            position: relative !important;
            width: 100% !important;
            z-index: 99990 !important;
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif !important;
            color: var(--kx-text);
            background: #ffffff !important;
            border-bottom: 1px solid var(--kx-border);
            display: block !important;
        }
        #kx-header.kx-sticky { position: sticky !important; top: 0 !important; }

        /* TƯƠNG THÍCH VỚI THANH WORDPRESS ADMIN BAR */
        body.admin-bar #kx-header.kx-sticky {
            top: 32px !important;
        }
        @media screen and (max-width: 782px) {
            body.admin-bar #kx-header.kx-sticky {
                top: 46px !important;
            }
        }

        #kx-header .kx-header-inner {
            width: 100% !important;
            max-width: 1440px !important;
            min-height: 76px !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 16px !important;
            background: #fff !important;
        }

        /* LOGO */
        #kx-header .kx-logo {
            flex: 0 0 auto !important;
            position: static !important;
            display: inline-flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            text-decoration: none !important;
            padding: 4px 0 !important;
            cursor: pointer;
            width: auto !important;
        }
        #kx-header .kx-logo-main {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        #kx-header .kx-logo-icon {
            display: block !important;
            height: 48px !important;
            width: auto !important;
            max-height: 52px !important;
            object-fit: contain !important;
            flex-shrink: 0 !important;
        }
        #kx-header .kx-logo-brand {
            display: flex !important;
            flex-direction: column !important;
            line-height: 1.05 !important;
        }
        #kx-header .kx-brand-sub {
            font-family: 'Montserrat', sans-serif !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            color: #0f5999 !important;
            letter-spacing: -0.2px !important;
            line-height: 1.15 !important;
        }
        #kx-header .kx-brand-main {
            font-family: 'Montserrat', sans-serif !important;
            font-size: 13px !important;
            font-weight: 900 !important;
            color: #c4161c !important;
            text-transform: uppercase !important;
            letter-spacing: 0.2px !important;
            line-height: 1.1 !important;
            white-space: nowrap !important;
        }
        #kx-header .kx-brand-vn {
            font-family: 'Montserrat', sans-serif !important;
            color: #0f5999 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            text-transform: lowercase !important;
        }
        #kx-header .kx-logo-slogan {
            font-family: 'Montserrat', sans-serif !important;
            font-size: 8.5px !important;
            font-style: italic !important;
            font-weight: 700 !important;
            color: #0f5999 !important;
            letter-spacing: 0.2px !important;
            margin-top: 2px !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
        }

        /* NAVIGATION DESKTOP */
        #kx-header .kx-navigation {
            flex: 1 1 auto !important;
            position: static !important;
            min-width: 0 !important;
            height: 76px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            margin: 0 0 0 10px !important;
        }
        #kx-header .kx-nav-list {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 4px !important;
            min-width: 0 !important;
        }
        #kx-header .kx-nav-item {
            position: relative !important;
            flex: 0 0 auto !important;
            white-space: nowrap !important;
            list-style: none !important;
        }
        #kx-header .kx-nav-item > a {
            height: 76px !important;
            padding: 0 12px !important;
            display: flex !important;
            align-items: center !important;
            gap: 5px !important;
            color: #0f172a !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            transition: color .2s ease !important;
        }
        #kx-header .kx-nav-item > a:hover {
            color: #15803d !important;
        }
        #kx-header .kx-arrow {
            width: 12px; height: 12px;
            transition: transform .2s ease;
        }
        #kx-header .kx-nav-item.kx-has-mega:hover .kx-arrow,
        #kx-header .kx-nav-item.kx-has-dropdown:hover .kx-arrow {
            transform: rotate(180deg);
            color: #15803d;
        }

        /* =====================================================
           STANDARD DROPDOWN MENU (GIỚI THIỆU, ĐỐI TÁC, THÀNH VIÊN)
        ===================================================== */
        #kx-header .kx-has-dropdown {
            position: relative !important;
        }
        #kx-header .kx-dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            left: -30px !important;
            width: 270px !important;
            background: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12), 0 4px 12px rgba(0,0,0,0.04) !important;
            padding: 8px !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(10px) !important;
            transition: opacity .2s ease, transform .2s ease, visibility .2s !important;
            z-index: 999999 !important;
            pointer-events: none !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 3px !important;
        }
        #kx-header .kx-has-dropdown:hover .kx-dropdown-menu,
        #kx-header .kx-dropdown-menu:hover {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            pointer-events: auto !important;
        }
        #kx-header .kx-nav-item:nth-last-child(-n+3) .kx-dropdown-menu {
            left: auto !important;
            right: -10px !important;
        }
        #kx-header .kx-dropdown-item {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 9px 10px !important;
            border-radius: 9px !important;
            text-decoration: none !important;
            transition: all .16s ease !important;
        }
        #kx-header .kx-dropdown-item:hover {
            background: #f0fdf4 !important;
            transform: translateX(2px) !important;
        }
        #kx-header .kx-dd-icon {
            font-size: 18px !important;
            line-height: 1 !important;
            flex-shrink: 0 !important;
        }
        #kx-header .kx-dd-text {
            display: flex !important;
            flex-direction: column !important;
            min-width: 0 !important;
        }
        #kx-header .kx-dd-text strong {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            line-height: 1.25 !important;
        }
        #kx-header .kx-dropdown-item:hover .kx-dd-text strong {
            color: #15803d !important;
        }
        #kx-header .kx-dd-text span {
            font-size: 10.5px !important;
            color: #64748b !important;
            margin-top: 2px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        /* =====================================================
           2-STEP MEGA SUBMENU (BƯỚC 1: VỊ TRÍ -> BƯỚC 2: GIÁ)
        ===================================================== */
        #kx-header .kx-has-mega {
            position: relative !important;
        }
        #kx-header .kx-stepped-menu {
            position: absolute !important;
            top: 100% !important;
            left: -80px !important;
            width: 530px !important;
            background: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.14), 0 4px 12px rgba(0,0,0,0.05) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(10px) !important;
            transition: opacity .2s ease, transform .2s ease, visibility .2s !important;
            z-index: 999999 !important;
            pointer-events: none !important;
            overflow: hidden !important;
        }
        #kx-header .kx-has-mega:hover .kx-stepped-menu,
        #kx-header .kx-stepped-menu:hover {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            pointer-events: auto !important;
        }
        #kx-header .kx-stepped-wrapper {
            display: flex !important;
            min-height: 290px !important;
            background: #ffffff !important;
        }

        /* BƯỚC 1: CỘT CHỌN VỊ TRÍ (BÊN TRÁI) */
        #kx-header .kx-step1-col {
            width: 215px !important;
            background: #f8fafc !important;
            border-right: 1px solid #e2e8f0 !important;
            padding: 14px 12px 12px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            flex-shrink: 0 !important;
        }
        #kx-header .kx-step-label {
            font-size: 10.5px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: .06em !important;
            color: #64748b !important;
            margin-bottom: 8px !important;
            padding-left: 2px !important;
        }
        #kx-header .kx-step-label.in-label { color: #166534 !important; }
        #kx-header .kx-step-label.out-label { color: #1e40af !important; }

        #kx-header .kx-step1-list {
            display: flex !important;
            flex-direction: column !important;
            gap: 6px !important;
        }
        #kx-header .kx-step1-item {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 10px 10px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            cursor: pointer !important;
            transition: all .16s ease !important;
            text-decoration: none !important;
            user-select: none !important;
        }
        #kx-header .kx-s1-icon {
            font-size: 18px !important;
            line-height: 1 !important;
            flex-shrink: 0 !important;
        }
        #kx-header .kx-s1-info {
            display: flex !important;
            flex-direction: column !important;
            flex: 1 !important;
            min-width: 0 !important;
        }
        #kx-header .kx-s1-title {
            font-size: 12.5px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            line-height: 1.25 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        #kx-header .kx-s1-desc {
            font-size: 10px !important;
            color: #64748b !important;
            margin-top: 2px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        #kx-header .kx-s1-arrow {
            width: 14px !important;
            height: 14px !important;
            color: #94a3b8 !important;
            flex-shrink: 0 !important;
            transition: transform .15s ease, color .15s ease !important;
        }

        #kx-header .kx-step1-item:hover,
        #kx-header .kx-step1-item.is-active {
            transform: translateX(2px) !important;
        }
        #kx-header .kx-step1-item.in-kcn:hover,
        #kx-header .kx-step1-item.in-kcn.is-active {
            background: #f0fdf4 !important;
            border-color: #86efac !important;
            box-shadow: 0 2px 8px rgba(22, 101, 52, 0.08) !important;
        }
        #kx-header .kx-step1-item.in-kcn:hover .kx-s1-title,
        #kx-header .kx-step1-item.in-kcn.is-active .kx-s1-title {
            color: #166534 !important;
        }
        #kx-header .kx-step1-item.in-kcn:hover .kx-s1-arrow,
        #kx-header .kx-step1-item.in-kcn.is-active .kx-s1-arrow {
            color: #166534 !important;
            transform: translateX(2px) !important;
        }

        #kx-header .kx-step1-item.out-kcn:hover,
        #kx-header .kx-step1-item.out-kcn.is-active {
            background: #eff6ff !important;
            border-color: #93c5fd !important;
            box-shadow: 0 2px 8px rgba(30, 64, 175, 0.08) !important;
        }
        #kx-header .kx-step1-item.out-kcn:hover .kx-s1-title,
        #kx-header .kx-step1-item.out-kcn.is-active .kx-s1-title {
            color: #1e40af !important;
        }
        #kx-header .kx-step1-item.out-kcn:hover .kx-s1-arrow,
        #kx-header .kx-step1-item.out-kcn.is-active .kx-s1-arrow {
            color: #1e40af !important;
            transform: translateX(2px) !important;
        }

        #kx-header .kx-step1-all-link {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 7px 8px !important;
            background: #f1f5f9 !important;
            border-radius: 8px !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            color: #475569 !important;
            text-decoration: none !important;
            transition: all .15s ease !important;
            margin-top: 10px !important;
        }
        #kx-header .kx-step1-all-link:hover {
            background: #e2e8f0 !important;
            color: #0f172a !important;
        }

        /* BƯỚC 2: CỘT CHỌN MỨC GIÁ (BÊN PHẢI) */
        #kx-header .kx-step2-col {
            flex: 1 !important;
            padding: 14px 16px 12px !important;
            background: #ffffff !important;
            min-width: 0 !important;
        }
        #kx-header .kx-step2-panel {
            display: none !important;
        }
        #kx-header .kx-step2-panel.is-active {
            display: block !important;
            animation: kxWpPanelFade .16s ease forwards !important;
        }
        @keyframes kxWpPanelFade {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #kx-header .kx-step2-groups {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }
        #kx-header .kx-step2-group {
            display: flex !important;
            flex-direction: column !important;
            gap: 6px !important;
        }
        #kx-header .kx-group-heading {
            display: flex !important;
            align-items: center !important;
            gap: 5px !important;
            font-size: 10.5px !important;
            font-weight: 800 !important;
            letter-spacing: .04em !important;
            color: #334155 !important;
        }
        #kx-header .kx-gh-icon { font-size: 13px !important; line-height: 1 !important; }
        #kx-header .kx-gh-text { flex: 1 !important; }
        #kx-header .kx-gh-all {
            font-size: 11px !important;
            font-weight: 700 !important;
            color: #15803d !important;
            text-decoration: none !important;
            transition: color .15s !important;
        }
        #kx-header .kx-gh-all:hover {
            color: #166534 !important;
            text-decoration: underline !important;
        }

        #kx-header .kx-price-chips {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 4px 6px !important;
        }
        #kx-header .kx-price-chips a {
            font-size: 11.5px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            text-decoration: none !important;
            padding: 5px 8px !important;
            background: #f8fafc !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 6px !important;
            transition: all .15s ease !important;
            text-align: center !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: block !important;
        }
        #kx-header .kx-price-chips a:hover {
            background: #15803d !important;
            color: #ffffff !important;
            border-color: #15803d !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 2px 6px rgba(21, 128, 61, 0.2) !important;
        }

        /* MORE MENU */
        #kx-header .kx-more { position: relative !important; display: none; flex: 0 0 auto !important; }
        #kx-header .kx-more-button {
            height: 76px !important;
            padding: 0 12px !important;
            border: 0 !important;
            background: transparent !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            color: #000000 !important;
            font-family: inherit !important;
            font-size: 14px !important;
            font-weight: 700 !important;
        }
        #kx-header .kx-dots { display: flex !important; align-items: center !important; gap: 3px !important; }
        #kx-header .kx-dots i { width: 4px; height: 4px; display: block; border-radius: 50%; background: #555; }
        #kx-header .kx-more-dropdown {
            position: absolute !important;
            top: calc(100% - 1px) !important;
            right: 0 !important;
            width: 260px !important;
            padding: 8px !important;
            background: #fff !important;
            border: 1px solid var(--kx-border) !important;
            border-radius: 10px !important;
            box-shadow: 0 14px 35px rgba(0, 0, 0, .14) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(8px) !important;
            transition: .18s ease !important;
        }
        #kx-header .kx-more.is-open .kx-more-dropdown {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }
        #kx-header .kx-more-items { display: flex !important; flex-direction: column !important; }
        #kx-header .kx-more-items .kx-nav-item { display: block !important; width: 100% !important; }
        #kx-header .kx-more-items .kx-nav-item > a { height: auto !important; min-height: 40px !important; padding: 8px 12px !important; border-radius: 7px !important; font-size: 13.5px !important; }

        /* RIGHT ACTIONS */
        #kx-header .kx-header-actions {
            flex: 0 0 auto !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin-left: auto !important;
        }
        #kx-header .kx-menu-hotline-link {
            color: #c4161c !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            background: #fff5f5 !important;
            border: 1px solid #fed7d7 !important;
            padding: 6px 12px !important;
            border-radius: 14px !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            transition: background .15s, transform .15s !important;
        }
        #kx-header .kx-menu-hotline-link:hover {
            background: #fee2e2 !important;
            transform: translateY(-1px);
        }
        #kx-header .kx-menu-hotline-link strong { font-size: 12px !important; font-weight: 800 !important; }
        #kx-header .kx-menu-hotline-icon { font-size: 11px; color: #c4161c; }

        /* HAMBURGER BUTTON */
        #kx-header .kx-mobile-button {
            display: none;
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            padding: 7px !important;
            border: 1px solid #d1d5db !important;
            background: #ffffff !important;
            border-radius: 6px !important;
            cursor: pointer !important;
            flex-shrink: 0 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
        }
        #kx-header .kx-mobile-button span {
            display: block !important;
            height: 2px !important;
            width: 20px !important;
            margin: 3.5px auto !important;
            background: #1f2937 !important;
            border-radius: 2px !important;
        }

        /* MOBILE MENU DRAWER */
        #kx-header .kx-mobile-menu {
            display: none;
            position: absolute !important;
            left: 0 !important;
            right: 0 !important;
            top: 100% !important;
            background: #fff !important;
            border-top: 1px solid var(--kx-border) !important;
            box-shadow: 0 15px 30px rgba(0,0,0,.15) !important;
            z-index: 999999 !important;
        }
        #kx-header .kx-mobile-menu.is-open { display: block !important; }
        #kx-header .kx-mobile-inner { padding: 12px 20px 24px !important; max-height: calc(100vh - 76px) !important; overflow-y: auto !important; }
        #kx-header .kx-mobile-inner > a {
            min-height: 46px !important;
            display: flex !important;
            align-items: center !important;
            border-bottom: 1px solid #f0f0f0 !important;
            color: #111 !important;
            font-size: 14.5px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }

        /* Mobile Accordion Main */
        #kx-header .kx-mob-acc { border-bottom: 1px solid #f0f0f0 !important; }
        #kx-header .kx-mob-acc-head {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            min-height: 46px !important;
        }
        #kx-header .kx-mob-acc-head a {
            font-size: 14.5px !important;
            font-weight: 600 !important;
            color: #111 !important;
            text-decoration: none !important;
            flex: 1 !important;
        }
        #kx-header .kx-mob-toggle {
            background: #f1f5f9 !important;
            border: none !important;
            width: 30px !important;
            height: 30px !important;
            border-radius: 6px !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: transform .2s ease !important;
        }
        #kx-header .kx-mob-acc.is-open > .kx-mob-acc-head .kx-mob-toggle {
            transform: rotate(180deg) !important;
            background: #dcfce7 !important;
            color: #166534 !important;
        }
        #kx-header .kx-mob-acc-body {
            display: none;
            padding: 4px 0 10px 6px !important;
            background: #fafbfc !important;
            border-radius: 8px !important;
            margin-bottom: 8px !important;
        }
        #kx-header .kx-mob-acc.is-open > .kx-mob-acc-body { display: block !important; }

        /* Mobile Sub-Accordion (Trong/Ngoài KCN) */
        #kx-header .kx-mob-sub-acc {
            border-bottom: 1px solid #f1f5f9 !important;
            margin-bottom: 4px !important;
        }
        #kx-header .kx-mob-sub-head {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 8px 6px !important;
            cursor: pointer !important;
        }
        #kx-header .kx-msh-title {
            font-size: 13.5px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
        }
        #kx-header .kx-mob-sub-toggle {
            background: #e2e8f0 !important;
            border: none !important;
            width: 26px !important;
            height: 26px !important;
            border-radius: 4px !important;
            font-size: 9px !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: transform .2s ease !important;
        }
        #kx-header .kx-mob-sub-acc.is-open .kx-mob-sub-toggle {
            transform: rotate(180deg) !important;
            background: #dcfce7 !important;
            color: #166534 !important;
        }
        #kx-header .kx-mob-sub-body {
            display: none;
            padding: 4px 6px 8px 10px !important;
        }
        #kx-header .kx-mob-sub-acc.is-open .kx-mob-sub-body {
            display: block !important;
        }

        #kx-header .kx-mob-group-title {
            font-size: 11.5px !important;
            font-weight: 800 !important;
            color: #0f5999 !important;
            margin: 6px 0 3px !important;
            padding-left: 2px !important;
        }
        #kx-header .kx-mob-links { display: flex !important; flex-direction: column !important; gap: 2px !important; }
        #kx-header .kx-mob-links a {
            font-size: 12.5px !important;
            font-weight: 500 !important;
            color: #334155 !important;
            text-decoration: none !important;
            padding: 4px 6px !important;
            border-radius: 5px !important;
            display: block !important;
        }
        #kx-header .kx-mob-links a.full {
            font-weight: 700 !important;
            color: #0f172a !important;
            background: #f1f5f9 !important;
            margin-bottom: 2px !important;
        }
        #kx-header .kx-mob-links a:hover { background: #e2e8f0 !important; color: #000 !important; }

        #kx-header .kx-mobile-contact { margin-top: 16px !important; }
        #kx-header .kx-mobile-contact a {
            min-height: 44px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 6px !important;
            background: #fff5f5 !important;
            border: 1px solid #fed7d7 !important;
            color: #c4161c !important;
            text-decoration: none !important;
            font-weight: 700 !important;
            font-size: 14px !important;
        }

        /* =========================================================
           BREAKPOINTS RESPONSIVE
        ========================================================= */
        @media (max-width: 1200px) {
            #kx-header .kx-logo-slogan { display: none !important; }
            #kx-header .kx-nav-item > a { padding: 0 8px !important; font-size: 13.5px !important; }
            #kx-header .kx-stepped-menu { width: 480px !important; left: -60px !important; }
        }

        @media (max-width: 1024px) {
            #kx-header .kx-navigation { display: none !important; }
            #kx-header .kx-logo-slogan { display: none !important; }
            #kx-header .kx-header-inner {
                padding: 0 16px !important;
                gap: 10px !important;
                min-height: 64px !important;
            }
            #kx-header .kx-logo-icon { height: 38px !important; }
            #kx-header .kx-brand-sub { font-size: 10px !important; }
            #kx-header .kx-brand-main { font-size: 13.5px !important; }
            #kx-header .kx-brand-vn { font-size: 11px !important; }
            #kx-header .kx-header-actions {
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
                flex-shrink: 0 !important;
                margin-left: auto !important;
            }
            #kx-header .kx-mobile-button {
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                flex-shrink: 0 !important;
                width: 36px !important;
                height: 36px !important;
                min-width: 36px !important;
                padding: 5px !important;
            }
            #kx-header .kx-mobile-button span {
                width: 18px !important;
                margin: 2.5px auto !important;
            }
        }

        @media (max-width: 768px) {
            #kx-header .kx-header-inner {
                padding: 0 10px !important;
                gap: 6px !important;
                min-height: 60px !important;
            }
            #kx-header .kx-logo-main { gap: 6px !important; }
            #kx-header .kx-logo-icon { height: 30px !important; }
            #kx-header .kx-brand-sub { font-size: 8px !important; }
            #kx-header .kx-brand-main { font-size: 11px !important; }
            #kx-header .kx-brand-vn { font-size: 9px !important; }
            #kx-header .kx-hotline-label { display: none !important; }
            #kx-header .kx-menu-hotline-link {
                padding: 4px 8px !important;
                font-size: 10.5px !important;
                gap: 4px !important;
            }
            #kx-header .kx-menu-hotline-link strong { font-size: 10.5px !important; }
            #kx-header .kx-mobile-button {
                width: 32px !important;
                height: 32px !important;
                min-width: 32px !important;
                padding: 4px !important;
            }
            #kx-header .kx-mobile-button span {
                width: 16px !important;
                margin: 2px auto !important;
            }
        }

        @media (max-width: 480px) {
            #kx-header .kx-header-inner {
                padding: 0 8px !important;
                gap: 4px !important;
                min-height: 54px !important;
            }
            #kx-header .kx-logo-icon { height: 26px !important; }
            #kx-header .kx-brand-sub { font-size: 7px !important; }
            #kx-header .kx-brand-main { font-size: 9.5px !important; }
            #kx-header .kx-brand-vn { font-size: 8px !important; }
            #kx-header .kx-header-actions { gap: 4px !important; }
            #kx-header .kx-menu-hotline-link {
                padding: 3px 6px !important;
                font-size: 9.5px !important;
            }
            #kx-header .kx-menu-hotline-link strong { font-size: 9.5px !important; }
        }

        @media (max-width: 360px) {
            #kx-header .kx-menu-hotline-link strong { display: none !important; }
            #kx-header .kx-menu-hotline-link {
                padding: 4px 6px !important;
                font-size: 12px !important;
            }
        }

        /* 4. FOOTER CĂN GIỮA (CENTER) */
        #kx-footer {
            background: #0b1928 !important;
            color: rgba(255, 255, 255, 0.75) !important;
            width: 100% !important;
            position: relative !important;
            z-index: 10 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            display: block !important;
        }
        .bds-footer-bottom-wrap {
            max-width: 1440px;
            margin: 0 auto;
            padding: 16px 20px;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            text-align: center !important;
        }
        .bds-copyright-text {
            font-family: 'Roboto', 'Inter', sans-serif !important;
            font-size: 13px !important;
            color: rgba(255, 255, 255, 0.75) !important;
            letter-spacing: 0.2px;
            text-align: center !important;
            width: 100% !important;
        }
    </style>
    <?php
}

// =========================================================================
// 4. JAVASCRIPT MEGA MENU, ACCORDION & MOBILE MENU
// =========================================================================
add_action('wp_footer', 'bds24h_global_menu_script', 999);
function bds24h_global_menu_script() {
    if (bds24h_is_elementor_canvas()) return;
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const header = document.querySelector("#kx-header");
        if (!header) return;

        // 2-Step Dropdown Hover & Click Switcher
        header.querySelectorAll('.kx-stepped-wrapper').forEach(function(wrapper) {
            var step1Items = wrapper.querySelectorAll('.kx-step1-item');
            var step2Panels = wrapper.querySelectorAll('.kx-step2-panel');

            step1Items.forEach(function(item) {
                function activate() {
                    var targetId = item.getAttribute('data-target');
                    step1Items.forEach(function(el) { el.classList.remove('is-active'); });
                    step2Panels.forEach(function(panel) { panel.classList.remove('is-active'); });
                    item.classList.add('is-active');
                    var targetPanel = wrapper.querySelector('#' + targetId);
                    if (targetPanel) {
                        targetPanel.classList.add('is-active');
                    }
                }
                item.addEventListener('mouseenter', activate);
                item.addEventListener('click', activate);
            });
        });

        // Mobile main accordion toggle
        header.querySelectorAll('.kx-mob-toggle').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var acc = this.closest('.kx-mob-acc');
                if (acc) acc.classList.toggle('is-open');
            });
        });

        // Mobile sub accordion toggle
        header.querySelectorAll('.kx-mob-sub-toggle, .kx-mob-sub-head').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var subAcc = this.closest('.kx-mob-sub-acc');
                if (subAcc) subAcc.classList.toggle('is-open');
            });
        });

        // Sticky shadow on scroll
        function checkScroll() {
            if (window.scrollY > 10) {
                header.classList.add("kx-scrolled");
            } else {
                header.classList.remove("kx-scrolled");
            }
        }
        window.addEventListener("scroll", checkScroll);
        checkScroll();

        // Mobile Menu Drawer Toggle
        const mobBtn = header.querySelector(".kx-mobile-button");
        const mobMenu = header.querySelector(".kx-mobile-menu");

        if (mobBtn && mobMenu) {
            mobBtn.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                mobMenu.classList.toggle("is-open");
            });

            document.addEventListener("click", function (e) {
                if (mobMenu.classList.contains("is-open") && !header.contains(e.target)) {
                    mobMenu.classList.remove("is-open");
                }
            });
        }

        // More Menu responsiveness
        const navList = header.querySelector(".kx-nav-list");
        const more = header.querySelector(".kx-more");
        const moreItems = header.querySelector(".kx-more-items");
        const moreButton = header.querySelector(".kx-more-button");

        if (navList && more && moreItems && moreButton) {
            const items = Array.from(navList.querySelectorAll(":scope > .kx-nav-item"));

            function calculateMenu() {
                items.forEach(function (item) {
                    navList.insertBefore(item, more);
                });
                moreItems.innerHTML = "";
                more.style.display = "none";

                if (window.innerWidth <= 1024) return;

                const navWidth = navList.clientWidth;
                let total = 0;
                const moreWidth = 80;

                items.forEach(function (item) {
                    total += item.offsetWidth;
                });

                if (total <= navWidth) return;

                more.style.display = "block";
                let currentWidth = 0;
                items.forEach(function (item) {
                    currentWidth += item.offsetWidth;
                });

                for (let i = items.length - 1; i >= 0; i--) {
                    if (currentWidth + moreWidth <= navWidth) break;
                    const item = items[i];
                    currentWidth -= item.offsetWidth;
                    moreItems.prepend(item);
                }
            }

            window.addEventListener("resize", calculateMenu);
            setTimeout(calculateMenu, 100);

            moreButton.addEventListener("click", function (event) {
                event.stopPropagation();
                const isOpen = more.classList.toggle("is-open");
                moreButton.setAttribute("aria-expanded", isOpen);
            });

            document.addEventListener("click", function (event) {
                if (!more.contains(event.target)) {
                    more.classList.remove("is-open");
                    moreButton.setAttribute("aria-expanded", "false");
                }
            });
        }
    });
    </script>
    <?php
}
