<?php
/* Template Name: Về chúng tôi */
get_header();
?>

<?php
// Lấy ID trang hiện tại
$current_page_id = get_the_ID();

// Lấy tiêu đề trang
$page_title = get_the_title($current_page_id);

// Lấy nội dung trang
$page_content = get_the_content($current_page_id);

// Lấy link ảnh chính ACF
$thumbnail = get_field('main_image', $current_page_id);

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

// Lấy Trường core_values ACF có dạng relationship
$core_values = get_field('core_values', $current_page_id);

// Lấy trưởng flows ACF có dạng relationship
$flows = get_field('flows', $current_page_id);

// Lấy trường staffs ACF có dạng relationship
$staffs = get_field('staffs', $current_page_id);

// Lấy trường customers ACF có dạng relationship
$customers = get_field('customers', $current_page_id);
?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1618220179428-22790b461013?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <h1 class="page-header__title">Câu chuyện của chúng tôi</h1>
        <div class="breadcrumbs">
            <a href="index.html" class="breadcrumbs__link">Trang chủ</a>
            <span class="breadcrumbs__separator">/</span>
            <span class="breadcrumbs__current">Về chúng tôi</span>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section">
    <div class="container">
        <div class="about-us__grid">
            <div class="about-us__content">
                <?php
                echo $page_content; // Hiển thị nội dung trang
                ?>
            </div>
            <div class="about-us__image-container">
                <img src="<?php echo esc_html($thumbnail); ?>" alt="Xưởng của chúng tôi" class="about-us__image">
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="section section--alt">
    <div class="container">
        <h2 class="section__title"><?php echo $title_1; ?></h2>
        <p class="section__subtitle"><?php echo $sub_title_1; ?></p>

        <div class="values">
            <?php
            foreach ($core_values as $value) {
                $value_title = get_the_title($value->ID);
                $value_icon = get_field('icon', $value->ID); // Lấy icon từ ACF
                $value_description = get_field('desc', $value->ID);
            ?>
                <div class="value">
                    <div class="value__icon">
                        <i class="dashicons <?= esc_attr($value_icon); ?>"></i>
                    </div>
                    <h3 class="value__title"><?= esc_html($value_title); ?></h3>
                    <p class="value__description"><?= esc_html($value_description); ?></p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- Our Process -->
<section class="section">
    <div class="container">
        <h2 class="section__title"><?php echo $title_2; ?></h2>
        <p class="section__subtitle"><?php echo $sub_title_2; ?></p>

        <div class="process">
            <?php
            foreach ($flows as $flow) {
                $flow_title = get_the_title($flow->ID);
                $flow_order = get_field('order', $flow->ID); // Lấy icon từ ACF
                $flow_description = get_field('desc', $flow->ID);
            ?>
                <div class="process-step">
                    <div class="process-step__number"><?php echo esc_html($flow_order); ?></div>
                    <h3 class="process-step__title"><?php echo esc_html($flow_title); ?></h3>
                    <p class="process-step__description"><?php echo esc_html($flow_description); ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Our Team -->
<section class="section section--alt">
    <div class="container">
        <h2 class="section__title"><?php echo $title_3; ?></h2>
        <p class="section__subtitle"><?php echo $sub_title_3; ?></p>

        <div class="team">
            <?php
            foreach ($staffs as $staff) {
                $staff_name = get_field('name', $staff->ID);
                $staff_position = get_field('position', $staff->ID);
                $staff_avatar = get_field('avatar', $staff->ID);
                $staff_about = get_field('about', $staff->ID);
                $staff_link_social = get_field('link_social', $staff->ID);
            ?>
                <div class="team-member">
                    <img src="<?php echo $staff_avatar ?>" alt="<?php echo $staff_name ?>" class="team-member__image">
                    <h3 class="team-member__name"><?php echo $staff_name ?></h3>
                    <p class="team-member__position"><?php echo $staff_position ?></p>
                    <p class="team-member__bio"><?php echo $staff_about ?></p>
                    <div class="team-member__social">
                        <a href="<?php echo esc_url($staff_link_social); ?>" class="team-member__social-link"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="section section--alt">
    <div class="container">
        <h2 class="section__title"><?php echo $title_4; ?></h2>
        <p class="section__subtitle"><?php echo $sub_title_4; ?></p>

        <div class="testimonials">
            <?php
            foreach ($customers as $customer) {
                $customer_name = get_field('name', $customer->ID);
                $customer_work = get_field('work', $customer->ID);
                $customer_avatar = get_field('avatar', $customer->ID);
                $customer_content = get_field('content', $customer->ID);

            ?>
                <div class="testimonial">
                    <div class="testimonial__quote">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="testimonial__text"><?php echo esc_html($customer_content); ?></p>
                    <div class="testimonial__author">
                        <img src="<?php echo esc_url($customer_avatar); ?>" alt="<?php echo esc_attr($customer_name); ?>" class="testimonial__author-image">
                        <div class="testimonial__author-info">
                            <h4 class="testimonial__author-name"><?php echo esc_html($customer_name); ?></h4>
                            <p class="testimonial__author-title"><?php echo esc_html($customer_work); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section section--cta" style="background-image: url('images/cta-bg.jpg');">
    <div class="container">
        <div class="cta">
            <h2 class="cta__title">Sẵn sàng để thay đổi không gian của bạn?</h2>
            <p class="cta__text">Khám phá bộ sưu tập đồ nội thất thủ công của chúng tôi hoặc đặt lịch tư vấn với các chuyên gia thiết kế.</p>
            <div class="cta__buttons">
                <a href="/san-pham" class="btn btn--primary">Xem bộ sưu tập</a>
                <a href="/lien-he" class="btn btn--secondary">Liên hệ với chúng tôi</a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>