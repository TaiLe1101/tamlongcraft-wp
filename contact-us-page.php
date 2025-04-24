<?php
/* Template Name: Liên hệ */
get_header();
?>

<?php

// Lấy ID trang hiện tại
$current_page_id = get_the_ID();

// Lấy title_1 ACF
$title_1 = get_field('title_1', $current_page_id);

// Lấy sub_title_1 ACF
$sub_title_1 = get_field('sub_title_1', $current_page_id);

// Lấy title_2 ACF
$title_2 = get_field('title_2', $current_page_id);
// Lấy sub_title_2 ACF
$sub_title_2 = get_field('sub_title_2', $current_page_id);
// Lấy title_3 ACF
$title_3 = get_field('title_3', $current_page_id);
// Lấy sub_title_3 ACF
$sub_title_3 = get_field('sub_title_3', $current_page_id);
// Lấy title_4 ACF
$title_4 = get_field('title_4', $current_page_id);
// Lấy sub_title_4 ACF
$sub_title_4 = get_field('sub_title_4', $current_page_id);

// Lấy card_contact ACF có dạng relationship
$card_contact = get_field('card_contact', $current_page_id);

//Lấy trường maps ACF có dạng relationship
$maps = get_field('maps', $current_page_id);

//Lấy trường image_form 
$image_form = get_field('image_form', $current_page_id);

// Lấy trường qa ACF có dạng relationship
$qa = get_field('qa', $current_page_id);

?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80');">
    <div class="container">
        <h1 class="page-header__title">Liên Hệ</h1>
        <div class="breadcrumbs">
            <a href="/" class="breadcrumbs__link">Trang chủ</a>
            <span class="breadcrumbs__separator">/</span>
            <span class="breadcrumbs__current">Liên hệ</span>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="section">
    <div class="container">
        <div class="contact-intro">
            <h2 class="section__title"><?php echo $title_1; ?></h2>
            <p class="section__subtitle"><?php echo $sub_title_1; ?></p>
        </div>

        <div class="contact-info">
            <?php
            foreach ($card_contact as $contact) {
                $title = get_the_title($contact->ID);
                $icon = get_field('icon', $contact->ID);
                $info = get_field('info', $contact->ID);
            ?>
                <div class="contact-info__item">
                    <div class="contact-info__icon">
                        <i class="dashicons <?php echo esc_attr($icon); ?>"></i>
                    </div>
                    <h3 class="contact-info__title"><?php echo esc_html($title); ?></h3>
                    <p class="contact-info__details"><?php echo esc_html($info); ?></p>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="section section--alt">
    <div class="container">
        <div class="contact-form-container">
            <div class="contact-form__content">
                <h2><?php echo $title_2; ?></h2>
                <p><?php echo $sub_title_2; ?></p>

                <form id="contact-form" class="contact-form" novalidate>
                    <?php wp_nonce_field('contact_form_nonce', 'contact_nonce'); ?>
                    <div class="form__row">
                        <div class="form__group">
                            <label for="first-name" class="form__label">Tên*</label>
                            <input type="text" id="first-name" name="first_name" class="form__input" required>
                        </div>
                        <div class="form__group">
                            <label for="last-name" class="form__label">Họ*</label>
                            <input type="text" id="last-name" name="last_name" class="form__input" required>
                        </div>
                    </div>

                    <div class="form__row">
                        <div class="form__group">
                            <label for="email" class="form__label">Địa Chỉ Email*</label>
                            <input type="email" id="email" name="email" class="form__input" required>
                        </div>
                        <div class="form__group">
                            <label for="phone" class="form__label">Số Điện Thoại</label>
                            <input type="tel" id="phone" name="phone" class="form__input">
                        </div>
                    </div>

                    <div class="form__group">
                        <label for="message" class="form__label">Tin Nhắn Của Bạn*</label>
                        <textarea id="message" name="message" class="form__textarea" rows="6" required></textarea>
                    </div>

                    <div class="form__group form__group--checkbox">
                        <input type="checkbox" id="newsletter" name="newsletter" class="form__checkbox">
                        <label for="newsletter" class="form__checkbox-label">Đăng ký nhận bản tin của chúng tôi để nhận ưu đãi độc quyền và cảm hứng thiết kế</label>
                    </div>

                    <div class="form__group form__group--checkbox">
                        <input type="checkbox" id="privacy" name="privacy" class="form__checkbox" required>
                        <label for="privacy" class="form__checkbox-label">Tôi đồng ý với <a href="#">Chính Sách Bảo Mật</a> và đồng ý cho việc xử lý dữ liệu cá nhân của tôi*</label>
                    </div>

                    <div class="form__message"></div>
                    <button type="submit" class="btn btn--primary btn--lg">Gửi Tin Nhắn</button>
                </form>
            </div>

            <div class="contact-form__image">
                <img src="<?php echo esc_url($image_form); ?>" alt="Showroom TamLongCraft">
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="section">
    <div class="container">
        <h2 class="section__title"><?php echo esc_html($title_3); ?></h2>
        <p class="section__subtitle"><?php echo esc_html($sub_title_3); ?></p>

        <div class="tabs">
            <div class="tabs__header">
                <?php
                $first_tab = true; // Biến để kiểm tra tab đầu tiên
                foreach ($maps as $map) {
                    $map_id = $map->ID;
                    $map_title = get_the_title($map_id);
                    $active_class = $first_tab ? 'tabs__btn--active' : ''; // Thêm class active cho tab đầu tiên
                ?>
                    <button class="tabs__btn <?php echo $active_class; ?>" data-tab="<?php echo esc_attr($map_id); ?>"><?php echo esc_html($map_title); ?></button>
                <?php
                    $first_tab = false; // Sau tab đầu tiên sẽ đặt biến này thành false
                }
                ?>
            </div>

            <div class="tabs__content">
                <?php
                $first_panel = true; // Biến để kiểm tra panel đầu tiên
                foreach ($maps as $map) {
                    $map_id = $map->ID;
                    $map_title = get_the_title($map_id);
                    $map_link = get_field('link_google_map', $map_id);
                    $map_address = get_field('address', $map_id);
                    $phone_number = get_field('phone_number', $map_id);
                    $open_time = get_field('open_time', $map_id);
                    $email = get_field('email', $map_id);
                    $active_class = $first_panel ? 'tabs__panel--active' : ''; // Thêm class active cho panel đầu tiên
                    $display_style = !$first_panel ? 'style="display: none;"' : ''; // Ẩn các panel không phải đầu tiên
                ?>
                    <div class="tabs__panel <?php echo $active_class; ?>" id="<?php echo esc_attr($map_id); ?>" <?php echo $display_style; ?>>
                        <div class="location">
                            <div class="location__map">
                                <iframe src="<?php echo esc_url($map_link); ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <div class="location__details">
                                <h3><?php echo esc_html($map_title); ?></h3>
                                <address>
                                    <?php echo esc_html($map_address); ?>
                                </address>
                                <p><strong>Điện thoại:</strong> <?php echo esc_html($phone_number); ?></p>
                                <p><strong>Email:</strong> <?php echo esc_html($email); ?></p>
                                <p><strong>Giờ mở cửa:</strong> <?php echo esc_html($open_time); ?></p>
                                <a href="#" class="btn btn--dark">Chỉ Đường</a>
                                <a href="#" class="btn btn--outline">Đặt Lịch Hẹn</a>
                            </div>
                        </div>
                    </div>
                <?php
                    $first_panel = false; // Sau panel đầu tiên sẽ đặt biến này thành false
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section section--alt">
    <div class="container">
        <h2 class="section__title"><?php echo esc_html($title_4); ?></h2>
        <p class="section__subtitle"><?php echo esc_html($sub_title_4); ?></p>

        <div class="faqs">
            <?php
            foreach ($qa as $question) {
                $question_id = $question->ID;
                $question_title = get_the_title($question_id);

                // Lấy content đúng cách
                $post = get_post($question_id);
                $question_content = $post->post_content;

            ?>
                <div class="faq">
                    <div class="faq__question">
                        <h3><?php echo esc_html($question_title); ?></h3>
                        <button class="faq__toggle"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="faq__answer">
                        <div><?php echo wpautop($question_content); ?></div>
                    </div>
                </div>
            <?php };
            wp_reset_postdata(); ?>
        </div>

        <div class="faq-cta">
            <p>Không tìm thấy câu trả lời bạn đang tìm kiếm?</p>
            <a href="#" class="btn btn--primary">Liên Hệ Dịch Vụ Khách Hàng</a>
        </div>
    </div>
</section>
<?php get_template_part('section', 'newsletter'); ?>

<?php
get_footer();
?>