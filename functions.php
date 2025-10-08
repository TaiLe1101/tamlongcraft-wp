<?php

function load_assets()
{
    // Đăng ký tài font Google
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap', array(), null);

    // Đăng ký và tải Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), null);

    // Đăng ký và tải file CSS chính
    wp_enqueue_style('main-css', get_theme_file_uri() . '/css/main.css', array(), '1.0.4', 'all');

    // Đăng ký và tải jQuery (nếu cần thiết)
    wp_enqueue_script('jquery');

    // Đăng ký và tải file CSS cho Dashicons (nếu cần thiết)
    wp_enqueue_style('dashicons');

    // Đăng ký và tải file JavaScript chính
    wp_enqueue_script('main-js', get_theme_file_uri() . '/js/main.js', array('jquery'), '1.0.1', true);

    // Thêm inline script để đảm bảo $ hoạt động
    wp_add_inline_script('main-js', 'var $ = jQuery;', 'before');

    // Truyền các biến cần thiết cho JavaScript
    wp_localize_script('main-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('product_filter_nonce'),
        'comment_nonce' => wp_create_nonce('comment_nonce'),
    ));

    // Đăng ký font chữ (nếu cần thiết)
    wp_enqueue_style('playfair-font', get_theme_file_uri() . '/assets/fonts/PlayfairDisplay-Regular.woff2', array(), '1.0.0', 'all');
}

function sync_acf_fields_on_update($post_id)
{
    // Tránh việc gọi hàm khi đang tự động cập nhật hoặc lưu dữ liệu.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Kiểm tra xem đây có phải là một bài viết hoặc trang bạn muốn không
    // if ('page' !== get_post_type($post_id)) return;

    // Lấy giá trị trường ACF từ trang hiện tại
    $footer_about = get_field('about', $post_id);
    $footer_address = get_field('address', $post_id);
    $footer_phone_number = get_field('phone_number', $post_id);
    $footer_email = get_field('email', $post_id);
    $footer_link_facebook = get_field('link_facebook', $post_id);
    $footer_link_instagram = get_field('link_instagram', $post_id);
    $footer_link_youtube = get_field('link_youtube', $post_id);
    $footer_link_zalo = get_field('link_zalo', $post_id);

    // Nếu không có giá trị ACF nào cần cập nhật, dừng hàm
    if (
        empty($footer_about) && empty($footer_address) && empty($footer_phone_number) && empty($footer_email) &&
        empty($footer_link_facebook) && empty($footer_link_instagram) && empty($footer_link_youtube) && empty($footer_link_zalo)
    ) {
        return;
    }

    // Lấy tất cả các trang bạn muốn cập nhật
    $pages_to_update = get_pages(array(
        'post_type' => 'page',
        'post_status' => 'publish', // Chỉ lấy các trang đã được xuất bản
    ));

    foreach ($pages_to_update as $page) {
        // Cập nhật giá trị cho các trang
        update_field('about', $footer_about, $page->ID);
        update_field('address', $footer_address, $page->ID);
        update_field('phone_number', $footer_phone_number, $page->ID);
        update_field('email', $footer_email, $page->ID);
        update_field('link_facebook', $footer_link_facebook, $page->ID);
        update_field('link_instagram', $footer_link_instagram, $page->ID);
        update_field('link_youtube', $footer_link_youtube, $page->ID);
        update_field('link_zalo', $footer_link_zalo, $page->ID);
    }
}


// Add custom class to menu li elements
function add_menu_li_class($classes, $item, $args)
{
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}

// Add custom class to menu links (a tags)
function add_menu_link_class($atts, $item, $args)
{
    $atts['class'] = 'nav__link';

    // Add active class if current menu item
    if ($item->current) {
        $atts['class'] .= ' nav__link--active';
    }

    return $atts;
}


// Add custom class to footer menu li elements
function add_footer_menu_li_class($classes, $item, $args)
{
    if (isset($args->add_li_class) && $args->theme_location === 'footer') {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}

// Add custom class to footer menu links (a tags)
function add_footer_menu_link_class($atts, $item, $args)
{
    if ($args->theme_location === 'footer') {
        if (isset($args->add_a_class)) {
            $atts['class'] = $args->add_a_class;
        } else {
            // Mặc định nếu không thiết lập add_a_class
            $atts['class'] = 'footer__link';
        }
    }
    return $atts;
}

// Thay thế cả hai hàm mytheme_register_menus và register_footer_menu
function register_theme_menus()
{
    register_nav_menus([
        'primary' => 'Primary Menu',
        'footer' => 'Footer Menu'
    ]);
}

// Đăng ký AJAX actions
function register_ajax_actions() {
    // AJAX cho người dùng đã đăng nhập
    add_action('wp_ajax_filter_products', 'filter_products_ajax');
    add_action('wp_ajax_sort_products', 'sort_products_ajax');
    add_action('wp_ajax_filter_articles', 'filter_articles_ajax');
    add_action('wp_ajax_submit_comment', 'submit_comment_ajax');
    
    // AJAX cho người dùng chưa đăng nhập
    add_action('wp_ajax_nopriv_filter_products', 'filter_products_ajax');
    add_action('wp_ajax_nopriv_sort_products', 'sort_products_ajax');
    add_action('wp_ajax_nopriv_filter_articles', 'filter_articles_ajax');
    add_action('wp_ajax_nopriv_submit_comment', 'submit_comment_ajax');
}
add_action('init', 'register_ajax_actions');

// Đăng ký AJAX actions cho newsletter
function register_newsletter_ajax() {
    // Đăng ký AJAX action cho người dùng đã đăng nhập và chưa đăng nhập
    add_action('wp_ajax_subscribe_newsletter', 'handle_newsletter_subscription');
    add_action('wp_ajax_nopriv_subscribe_newsletter', 'handle_newsletter_subscription');
}
add_action('init', 'register_newsletter_ajax');

// Đăng ký AJAX actions cho form liên hệ
function register_contact_form_ajax() {
    // Đăng ký AJAX action cho người dùng đã đăng nhập và chưa đăng nhập
    add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
    add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');
}
add_action('init', 'register_contact_form_ajax');

// Tạo bảng newsletter nếu chưa tồn tại
function check_and_create_newsletter_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();
    
    // Kiểm tra nếu bảng chưa tồn tại
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        // Tạo bảng newsletter_subscribers
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(100) NOT NULL,
            date_subscribed datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            status varchar(20) DEFAULT 'active' NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Đã tạo bảng ' . $table_name);
        return true;
    }
    
    return false;
}

// Chạy hàm kiểm tra và tạo bảng khi plugin được kích hoạt
check_and_create_newsletter_table();

// Hàm xử lý đăng ký newsletter
function handle_newsletter_subscription() {
    // Kiểm tra và tạo bảng newsletter nếu chưa tồn tại
    check_and_create_newsletter_table();
    
    // Kiểm tra nonce bảo mật
    if (!isset($_POST['newsletter_nonce']) || !wp_verify_nonce($_POST['newsletter_nonce'], 'newsletter_nonce_action')) {
        wp_send_json_error(['message' => 'Lỗi bảo mật. Vui lòng thử lại.']);
        die();
    }
    
    // Lấy email từ form và làm sạch dữ liệu
    $email = isset($_POST['subscriber_email']) ? sanitize_email($_POST['subscriber_email']) : '';
    
    // Kiểm tra định dạng email
    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => 'Địa chỉ email không hợp lệ. Vui lòng thử lại.']);
        die();
    }
    
    // Lưu email vào database (sử dụng custom table hoặc option)
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    
    // Ghi log để debug
    error_log('Đang kiểm tra email đã tồn tại: ' . $email);
    
    $subscriber_exists = $wpdb->get_var($wpdb->prepare(
        "SELECT email FROM $table_name WHERE email = %s",
        $email
    ));
    
    // Nếu email đã tồn tại
    if ($subscriber_exists) {
        error_log('Email đã tồn tại: ' . $email);
        wp_send_json_success(['message' => 'Email của bạn đã đăng ký trước đó. Cảm ơn bạn đã theo dõi!']);
        die();
    }
    
    // Thêm email mới
    $result = $wpdb->insert(
        $table_name,
        [
            'email' => $email,
            'date_subscribed' => current_time('mysql'),
            'status' => 'active',
        ],
        ['%s', '%s', '%s']
    );
    
    if ($result) {
        error_log('Đăng ký thành công: ' . $email);
        wp_send_json_success(['message' => 'Đăng ký thành công! Cảm ơn bạn đã quan tâm.']);
    } else {
        error_log('Lỗi khi đăng ký: ' . $wpdb->last_error);
        wp_send_json_error(['message' => 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại sau.']);
    }
    
    die();
}

// Hàm xử lý gửi form liên hệ
function handle_contact_form_submission() {
    // Kiểm tra nonce bảo mật
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_form_nonce')) {
        wp_send_json_error(['message' => 'Lỗi bảo mật. Vui lòng thử lại.']);
        die();
    }
    
    // Lấy và làm sạch dữ liệu từ form
    $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $newsletter = isset($_POST['newsletter']) && $_POST['newsletter'] === '1' ? true : false;
    $privacy = isset($_POST['privacy']) && $_POST['privacy'] === '1' ? true : false;
    
    // Kiểm tra dữ liệu bắt buộc
    if (empty($first_name) || empty($last_name) || empty($email) || empty($message) || !$privacy) {
        wp_send_json_error(['message' => 'Vui lòng điền đầy đủ thông tin bắt buộc.']);
        die();
    }
    
    // Kiểm tra định dạng email
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Địa chỉ email không hợp lệ. Vui lòng thử lại.']);
        die();
    }
    
    // Tạo bảng lưu thông tin liên hệ nếu chưa tồn tại
    create_contact_form_table();
    
    // Lưu thông tin liên hệ vào database
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    
    $result = $wpdb->insert(
        $table_name,
        [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'newsletter' => $newsletter ? 1 : 0,
            'date_submitted' => current_time('mysql'),
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ],
        ['%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s']
    );
    
    if (!$result) {
        wp_send_json_error(['message' => 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.']);
        die();
    }
    
    // Nếu đăng ký newsletter, thêm vào danh sách subscriber
    if ($newsletter) {
        $newsletter_table = $wpdb->prefix . 'newsletter_subscribers';
        
        // Kiểm tra email đã tồn tại trong danh sách newsletter chưa
        $subscriber_exists = $wpdb->get_var($wpdb->prepare(
            "SELECT email FROM $newsletter_table WHERE email = %s",
            $email
        ));
        
        // Nếu email chưa tồn tại, thêm mới
        if (!$subscriber_exists) {
            $wpdb->insert(
                $newsletter_table,
                [
                    'email' => $email,
                    'date_subscribed' => current_time('mysql'),
                    'status' => 'active',
                ],
                ['%s', '%s', '%s']
            );
        }
    }
    
    wp_send_json_success(['message' => 'Tin nhắn của bạn đã được gửi thành công. Chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể.']);
    die();
}

// Tạo bảng lưu thông tin liên hệ
function create_contact_form_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $charset_collate = $wpdb->get_charset_collate();
    
    // Chỉ tạo bảng nếu nó chưa tồn tại
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            first_name varchar(50) NOT NULL,
            last_name varchar(50) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(20) NOT NULL,
            message text NOT NULL,
            newsletter tinyint(1) DEFAULT 0,
            date_submitted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            status varchar(20) DEFAULT 'unread' NOT NULL,
            ip_address varchar(100) NOT NULL,
            user_agent varchar(255) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// Tạo bảng lưu subscriber khi kích hoạt theme
function create_newsletter_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();
    
    // Chỉ tạo bảng nếu nó chưa tồn tại
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(100) NOT NULL,
            date_subscribed datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            status varchar(20) DEFAULT 'active' NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
// Gọi hàm tạo bảng khi theme được kích hoạt
add_action('after_switch_theme', 'create_newsletter_table');
add_action('after_switch_theme', 'create_contact_form_table');

// Thêm trang quản lý newsletter trong admin
function add_newsletter_menu_page() {
    add_menu_page(
        'Quản lý Newsletter',
        'Newsletter',
        'manage_options',
        'newsletter-subscribers',
        'display_newsletter_page',
        'dashicons-email',
        30
    );
}
add_action('admin_menu', 'add_newsletter_menu_page');

// Thêm trang quản lý tin nhắn liên hệ trong admin
function add_contact_form_menu_page() {
    add_menu_page(
        'Quản lý Tin Nhắn Liên Hệ',
        'Tin Nhắn Liên Hệ',
        'manage_options',
        'contact-submissions',
        'display_contact_submissions_page',
        'dashicons-email-alt',
        31
    );
}
add_action('admin_menu', 'add_contact_form_menu_page');

// Hiển thị trang quản lý newsletter
function display_newsletter_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    
    // Xử lý xóa người đăng ký
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $wpdb->delete($table_name, ['id' => $id], ['%d']);
        echo '<div class="notice notice-success is-dismissible"><p>Đã xóa người đăng ký thành công.</p></div>';
    }
    
    // Lấy danh sách người đăng ký
    $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_subscribed DESC");
    ?>
    <div class="wrap">
        <h1>Quản lý Người đăng ký Newsletter</h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <p>Tổng số người đăng ký: <strong><?php echo count($subscribers); ?></strong></p>
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($subscribers)) {
                    foreach ($subscribers as $subscriber) {
                        ?>
                        <tr>
                            <td><?php echo $subscriber->id; ?></td>
                            <td><?php echo esc_html($subscriber->email); ?></td>
                            <td><?php echo date_i18n('d/m/Y H:i:s', strtotime($subscriber->date_subscribed)); ?></td>
                            <td><?php echo ucfirst($subscriber->status); ?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=newsletter-subscribers&action=delete&id=' . $subscriber->id); ?>" class="button button-small" onclick="return confirm('Bạn có chắc chắn muốn xóa người đăng ký này?');">Xóa</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5">Chưa có người đăng ký newsletter nào.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        
        <div class="tablenav bottom">
            <div class="alignleft actions">
                <p>Bạn có thể xuất danh sách email người đăng ký để sử dụng trong dịch vụ email marketing.</p>
            </div>
        </div>
    </div>
    <?php
}

// Hiển thị trang quản lý tin nhắn liên hệ
function display_contact_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    
    // Xử lý thay đổi trạng thái hoặc xóa tin nhắn
    if (isset($_GET['action'])) {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($_GET['action'] == 'mark-read' && $id > 0) {
            $wpdb->update(
                $table_name,
                ['status' => 'read'],
                ['id' => $id],
                ['%s'],
                ['%d']
            );
            echo '<div class="notice notice-success is-dismissible"><p>Đã đánh dấu tin nhắn là đã đọc.</p></div>';
        } elseif ($_GET['action'] == 'mark-unread' && $id > 0) {
            $wpdb->update(
                $table_name,
                ['status' => 'unread'],
                ['id' => $id],
                ['%s'],
                ['%d']
            );
            echo '<div class="notice notice-success is-dismissible"><p>Đã đánh dấu tin nhắn là chưa đọc.</p></div>';
        } elseif ($_GET['action'] == 'delete' && $id > 0) {
            $wpdb->delete(
                $table_name,
                ['id' => $id],
                ['%d']
            );
            echo '<div class="notice notice-success is-dismissible"><p>Đã xóa tin nhắn.</p></div>';
        }
    }
    
    // Lấy danh sách tin nhắn từ mới nhất đến cũ nhất
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_submitted DESC");
    $unread_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'unread'");
    ?>
    <div class="wrap">
        <h1>Quản lý Tin Nhắn Liên Hệ</h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <p>Tổng số tin nhắn: <strong><?php echo count($submissions); ?></strong> (Chưa đọc: <strong><?php echo $unread_count; ?></strong>)</p>
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped submissions-table">
            <thead>
                <tr>
                    <th style="width: 50px;" class="fixed-th">ID</th>
                    <th style="width: 15%;" class="fixed-th">Tên</th>
                    <th style="width: 15%;" class="fixed-th">Email</th>
                    <th style="width: 10%;" class="fixed-th">Số điện thoại</th>
                    <th style="width: 20%;" class="fixed-th">Nội dung</th>
                    <th style="width: 15%;" class="fixed-th">Ngày gửi</th>
                    <th style="width: 10%;" class="fixed-th">Trạng thái</th>
                    <th style="width: 15%;" class="fixed-th">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($submissions)) {
                    foreach ($submissions as $submission) {
                        $row_class = $submission->status === 'unread' ? 'unread-submission' : '';
                        $full_name = $submission->first_name . ' ' . $submission->last_name;
                        $date = date_i18n('d/m/Y H:i:s', strtotime($submission->date_submitted));
                        $message_preview = wp_trim_words($submission->message, 10, '...');
                        
                        // Tạo các nút hành động
                        $actions = [];
                        if ($submission->status === 'unread') {
                            $actions[] = '<a href="' . admin_url('admin.php?page=contact-submissions&action=mark-read&id=' . $submission->id) . '" class="button button-small">Đánh dấu đã đọc</a>';
                        } else {
                            $actions[] = '<a href="' . admin_url('admin.php?page=contact-submissions&action=mark-unread&id=' . $submission->id) . '" class="button button-small">Đánh dấu chưa đọc</a>';
                        }
                        $actions[] = '<a href="mailto:' . esc_attr($submission->email) . '" class="button button-small">Trả lời</a>';
                        $actions[] = '<a href="' . admin_url('admin.php?page=contact-submissions&action=delete&id=' . $submission->id) . '" class="button button-small" onclick="return confirm(\'Bạn có chắc chắn muốn xóa tin nhắn này?\');">Xóa</a>';
                        
                        ?>
                        <tr class="<?php echo $row_class; ?>">
                            <td><?php echo $submission->id; ?></td>
                            <td><?php echo esc_html($full_name); ?></td>
                            <td><a href="mailto:<?php echo esc_attr($submission->email); ?>"><?php echo esc_html($submission->email); ?></a></td>
                            <td><?php echo esc_html($submission->phone); ?></td>
                            <td class="message-col">
                                <div class="message-preview"><?php echo esc_html($message_preview); ?></div>
                                <div class="message-full" style="display: none;"><?php echo nl2br(esc_html($submission->message)); ?></div>
                                <a href="#" class="toggle-message">Xem thêm</a>
                            </td>
                            <td><?php echo $date; ?></td>
                            <td>
                                <?php 
                                if ($submission->status === 'unread') {
                                    echo '<span class="status-unread">Chưa đọc</span>';
                                } else {
                                    echo '<span class="status-read">Đã đọc</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo implode(' ', $actions); ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="8">Chưa có tin nhắn liên hệ nào.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <style>
        .unread-submission {
            background-color: #f7f7f7;
            font-weight: 500;
        }
        .status-unread {
            color: #e53935;
            font-weight: 600;
        }
        .status-read {
            color: #43a047;
        }
        .submissions-table td {
            vertical-align: middle;
        }
        .message-col {
            position: relative;
        }
        .toggle-message {
            display: inline-block;
            margin-top: 5px;
            text-decoration: none;
            font-size: 12px;
        }
        .message-full {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 10px;
            border-radius: 4px;
            margin-top: 5px;
        }
        
        /* Reset bố cục bảng và tiêu đề */
        .submissions-table {
            table-layout: fixed;
            border-collapse: collapse;
        }
        
        /* Fix cho tiêu đề */
        .fixed-th {
            writing-mode: horizontal-tb !important;
            text-orientation: mixed !important;
            transform: none !important;
            letter-spacing: normal !important;
            display: table-cell !important;
            vertical-align: middle !important;
            direction: ltr !important;
            text-align: left !important;
            word-break: normal !important;
        }
        
        /* Sửa lỗi hiển thị nằm dọc */
        th, td {
            font-size: 13px;
            line-height: normal;
            overflow: visible;
            transform: none !important;
        }
    </style>
    
    <script>
        jQuery(document).ready(function($) {
            // Sửa lỗi hiển thị dọc bằng JavaScript
            $(".wp-list-table th").css({
                "writing-mode": "horizontal-tb",
                "text-orientation": "mixed",
                "transform": "none",
                "letter-spacing": "normal",
                "direction": "ltr",
                "text-align": "left",
                "vertical-align": "middle"
            });
            
            // Toggle tin nhắn đầy đủ/thu gọn
            $('.toggle-message').on('click', function(e) {
                e.preventDefault();
                var $row = $(this).closest('td');
                var $preview = $row.find('.message-preview');
                var $full = $row.find('.message-full');
                
                $preview.toggle();
                $full.toggle();
                
                if ($preview.is(':visible')) {
                    $(this).text('Xem thêm');
                } else {
                    $(this).text('Thu gọn');
                }
            });
        });
    </script>
    <?php
}

// AJAX handler cho việc lọc sản phẩm
function filter_products_ajax() {
    // Kiểm tra nonce bảo mật
    check_ajax_referer('product_filter_nonce', 'security');
    
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'newest';
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = 6; // Số sản phẩm mỗi trang
    
    // Tham số truy vấn
    $args = array(
        'post_type' => 'san-pham',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged
    );
    
    // Lọc theo danh mục
    if ($category != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product-category',
                'field' => 'term_id',
                'terms' => $category
            )
        );
    }
    
    // Sắp xếp sản phẩm
    switch ($sort) {
        case 'price-low':
            $args['meta_key'] = 'price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'price-high':
            $args['meta_key'] = 'price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'name':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            break;
        case 'newest':
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }
    
    $query = new WP_Query($args);
    $response = array(
        'html' => '',
        'max_pages' => $query->max_num_pages,
        'found_posts' => $query->found_posts
    );
    
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product_id = get_the_ID();
            $product_title = get_the_title();
            $product_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $price = get_field('price', get_the_ID());
            $short_desc = get_field('short_desc', get_the_ID());
            $product_cats = get_the_terms(get_the_ID(), 'product-category');
            $category_name = isset($product_cats[0]) ? $product_cats[0]->name : '';
            $category_id = isset($product_cats[0]) ? $product_cats[0]->term_id : '';
            ?>
            <div class="product-card" data-category="<?= esc_attr($category_id); ?>">
                <img src="<?= esc_url($product_image); ?>" alt="<?= esc_attr($product_title); ?>" class="product-card__image">
                <div class="product-card__content">
                    <div class="product-card__category"><?= esc_html($category_name); ?></div>
                    <h3 class="product-card__title"><?= esc_html($product_title); ?></h3>
                    <div class="product-card__price"><?= esc_html($price); ?> VNĐ</div>
                    <p class="product-card__description"><?= esc_html($short_desc); ?></p>
                    <a href="<?= esc_url(get_permalink($product_id)); ?>" class="btn btn--dark">Xem chi tiết</a>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<div class="products-empty">Không tìm thấy sản phẩm nào.</div>';
    }
    
    $response['html'] = ob_get_clean();
    
    // Tạo phân trang
    ob_start();
    
    $total_pages = $query->max_num_pages;
    
    if ($total_pages > 1) {
        $current_page = $paged;
        
        // Previous page arrow
        if ($current_page > 1) {
            echo '<a href="#" class="pagination__arrow pagination__arrow--prev" data-page="' . ($current_page - 1) . '"><i class="fas fa-chevron-left"></i></a>';
        } else {
            echo '<span class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled"><i class="fas fa-chevron-left"></i></span>';
        }
        
        // Page numbers
        $start_page = max(1, $current_page - 2);
        $end_page = min($total_pages, $current_page + 2);
        
        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $current_page) {
                echo '<span class="pagination__number pagination__number--active">' . $i . '</span>';
            } else {
                echo '<a href="#" class="pagination__number" data-page="' . $i . '">' . $i . '</a>';
            }
        }
        
        // Next page arrow
        if ($current_page < $total_pages) {
            echo '<a href="#" class="pagination__arrow pagination__arrow--next" data-page="' . ($current_page + 1) . '"><i class="fas fa-chevron-right"></i></a>';
        } else {
            echo '<span class="pagination__arrow pagination__arrow--next pagination__arrow--disabled"><i class="fas fa-chevron-right"></i></span>';
        }
    }
    
    $response['pagination'] = ob_get_clean();
    
    wp_send_json_success($response);
    die();
}

// AJAX handler cho việc lọc bài viết
function filter_articles_ajax() {
    // Kiểm tra nonce bảo mật
    check_ajax_referer('product_filter_nonce', 'security');
    
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = 9; // Số bài viết mỗi trang
    
    // Tham số truy vấn
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'post_status' => 'publish'
    );
    
    // Lọc theo danh mục
    if ($category != 'all') {
        $args['cat'] = intval($category); // Sử dụng ID danh mục
    }
    
    // Sắp xếp bài viết mới nhất trước
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    
    $query = new WP_Query($args);
    $response = array(
        'html' => '',
        'max_pages' => $query->max_num_pages,
        'found_posts' => $query->found_posts
    );
    
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Lấy danh mục của bài viết hiện tại
            $categories = get_the_category();
            $category_name = '';
            $category_id = 'all';
            
            // Lấy danh mục đầu tiên nếu có
            if (!empty($categories)) {
                $category_name = $categories[0]->name;
                $category_id = $categories[0]->term_id;
            }
            
            // Lấy hình ảnh đại diện
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
            if (!$thumbnail) {
                $thumbnail = 'https://images.unsplash.com/photo-1616137422495-1e9e46e2aa77?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
            }
            
            // Lấy ngày đăng bài
            $post_date = get_the_date('j \T\h\á\n\g n, Y');
            ?>
            <div class="article-card" data-category="<?php echo esc_attr($category_id); ?>">
                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>" class="article-card__image">
                <div class="article-card__content">
                    <div class="article-card__meta">
                        <div class="article-card__date"><?php echo esc_html($post_date); ?></div>
                        <div class="article-card__category"><?php echo esc_html($category_name); ?></div>
                    </div>
                    <h3 class="article-card__title"><?php the_title(); ?></h3>
                    <p class="article-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn--dark">Đọc thêm</a>
                </div>
            </div>
            <?php
        }
        
        wp_reset_postdata();
    } else {
        echo '<div class="articles-empty">Không tìm thấy bài viết nào.</div>';
    }
    
    $response['html'] = ob_get_clean();
    
    // Tạo phân trang
    ob_start();
    
    $total_pages = $query->max_num_pages;
    
    if ($total_pages > 1) {
        $current_page = $paged;
        
        // Previous page arrow
        if ($current_page > 1) {
            echo '<a href="#" class="pagination__arrow pagination__arrow--prev" data-page="' . ($current_page - 1) . '"><i class="fas fa-chevron-left"></i></a>';
        } else {
            echo '<span class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled"><i class="fas fa-chevron-left"></i></span>';
        }
        
        // Page numbers
        $start_page = max(1, $current_page - 2);
        $end_page = min($total_pages, $current_page + 2);
        
        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $current_page) {
                echo '<span class="pagination__number pagination__number--active">' . $i . '</span>';
            } else {
                echo '<a href="#" class="pagination__number" data-page="' . $i . '">' . $i . '</a>';
            }
        }
        
        // Next page arrow
        if ($current_page < $total_pages) {
            echo '<a href="#" class="pagination__arrow pagination__arrow--next" data-page="' . ($current_page + 1) . '"><i class="fas fa-chevron-right"></i></a>';
        } else {
            echo '<span class="pagination__arrow pagination__arrow--next pagination__arrow--disabled"><i class="fas fa-chevron-right"></i></span>';
        }
    }
    
    $response['pagination'] = ob_get_clean();
    
    wp_send_json_success($response);
    die();
}

// AJAX handler cho việc gửi comment
function submit_comment_ajax() {
    // Kiểm tra nonce bảo mật
    check_ajax_referer('comment_nonce', 'security');
    
    $comment_post_ID = isset($_POST['comment_post_ID']) ? intval($_POST['comment_post_ID']) : 0;
    $comment_author = isset($_POST['comment_author']) ? sanitize_text_field($_POST['comment_author']) : '';
    $comment_author_email = isset($_POST['comment_author_email']) ? sanitize_email($_POST['comment_author_email']) : '';
    $comment_content = isset($_POST['comment_content']) ? sanitize_textarea_field($_POST['comment_content']) : '';
    $comment_parent = isset($_POST['comment_parent']) ? intval($_POST['comment_parent']) : 0;
    
    // Kiểm tra dữ liệu đầu vào
    if (empty($comment_post_ID) || empty($comment_author) || empty($comment_author_email) || empty($comment_content)) {
        wp_send_json_error(array('message' => 'Vui lòng điền đầy đủ thông tin.'));
        die();
    }
    
    // Tạo dữ liệu comment
    $commentdata = array(
        'comment_post_ID' => $comment_post_ID,
        'comment_author' => $comment_author,
        'comment_author_email' => $comment_author_email,
        'comment_content' => $comment_content,
        'comment_parent' => $comment_parent,
        'comment_type' => 'comment',
        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
        'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
        'comment_approved' => 0, // Chờ phê duyệt
    );
    
    // Lưu cookie cho commenter nếu được yêu cầu
    if (isset($_POST['save_info']) && $_POST['save_info'] == '1') {
        $comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
        setcookie('comment_author_' . COOKIEHASH, $comment_author, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
        setcookie('comment_author_email_' . COOKIEHASH, $comment_author_email, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
    }
    
    // Lưu comment vào database
    $comment_id = wp_insert_comment($commentdata);
    
    if ($comment_id) {
        // Tạo HTML cho comment mới để hiển thị
        $avatar = get_avatar_url($comment_author_email, array('size' => 64));
        $comment_date = date_i18n('j \T\h\á\n\g n, Y');
        
        ob_start();
        ?>
        <div class="comment comment--new">
            <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($comment_author); ?>" class="comment__avatar">
            <div class="comment__content">
                <div class="comment__header">
                    <h4 class="comment__author"><?php echo esc_html($comment_author); ?></h4>
                    <div class="comment__date"><?php echo esc_html($comment_date); ?></div>
                </div>
                <div class="comment__text">
                    <p><?php echo esc_html($comment_content); ?></p>
                </div>
                <div class="comment__moderation">
                    <p><em>Bình luận của bạn đang chờ phê duyệt.</em></p>
                </div>
            </div>
        </div>
        <?php
        $comment_html = ob_get_clean();
        
        wp_send_json_success(array(
            'message' => 'Bình luận của bạn đã được gửi và đang chờ phê duyệt.',
            'comment_html' => $comment_html
        ));
    } else {
        wp_send_json_error(array('message' => 'Có lỗi xảy ra khi gửi bình luận. Vui lòng thử lại sau.'));
    }
    
    die();
}

// Thêm meta box cho sản phẩm nổi bật
function tamlongcraft_add_featured_product_meta_box() {
    add_meta_box(
        'featured_product_meta_box',
        'Sản Phẩm Nổi Bật',
        'tamlongcraft_featured_product_meta_box_callback',
        'san-pham',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'tamlongcraft_add_featured_product_meta_box');

// Callback function để hiển thị nội dung meta box
function tamlongcraft_featured_product_meta_box_callback($post) {
    // Thêm nonce field để kiểm tra khi lưu
    wp_nonce_field('tamlongcraft_featured_product_meta_box', 'tamlongcraft_featured_product_meta_box_nonce');

    // Lấy giá trị hiện tại của trường meta
    $value = get_post_meta($post->ID, 'featured_product', true);

    // Hiển thị field
    echo '<label for="featured_product">';
    echo '<input type="checkbox" id="featured_product" name="featured_product" value="1" ' . checked($value, '1', false) . ' />';
    echo ' Đánh dấu là sản phẩm nổi bật';
    echo '</label>';
}

// Lưu dữ liệu meta box
function tamlongcraft_save_featured_product_meta_box_data($post_id) {
    // Kiểm tra nonce để bảo mật
    if (!isset($_POST['tamlongcraft_featured_product_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['tamlongcraft_featured_product_meta_box_nonce'], 'tamlongcraft_featured_product_meta_box')) {
        return;
    }

    // Kiểm tra autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Kiểm tra quyền hạn
    if (isset($_POST['post_type']) && 'san-pham' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Lưu dữ liệu
    if (isset($_POST['featured_product'])) {
        update_post_meta($post_id, 'featured_product', '1');
    } else {
        delete_post_meta($post_id, 'featured_product');
    }
}
add_action('save_post', 'tamlongcraft_save_featured_product_meta_box_data');

// Cấu hình SMTP để gửi mail
function configure_smtp($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.gmail.com'; // Thay đổi thành SMTP server bạn muốn sử dụng
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->Username = 'taic21a.th1@gmail.com'; // Thay đổi thành email của bạn
    $phpmailer->Password = 'your-app-password'; // Thay đổi thành mật khẩu ứng dụng (app password) của bạn
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->From = 'taic21a.th1@gmail.com'; // Thay đổi thành email của bạn
    $phpmailer->FromName = get_bloginfo('name');
}
add_action('phpmailer_init', 'configure_smtp');

// Hàm kiểm tra lỗi khi gửi email
function log_mailer_errors($wp_error) {
    $file = fopen(ABSPATH . '/mail-error-log.txt', 'a');
    fputs($file, "Lỗi gửi mail WordPress: " . date('Y-m-d H:i:s') . "\n");
    fputs($file, print_r($wp_error, true) . "\n\n");
    fclose($file);
}
add_action('wp_mail_failed', 'log_mailer_errors', 10, 1);

// Actions
add_action('after_setup_theme', 'register_theme_menus');
add_action('wp_enqueue_scripts', 'load_assets');
add_filter('show_admin_bar', '__return_false');

// Filters
add_filter('nav_menu_css_class', 'add_menu_li_class', 10, 3);
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 10, 3);

add_filter('nav_menu_css_class', 'add_footer_menu_li_class', 10, 3);
add_filter('nav_menu_link_attributes', 'add_footer_menu_link_class', 10, 3);

// Chạy hàm mỗi khi thay đổi trang Home
add_action('save_post', 'sync_acf_fields_on_update');
