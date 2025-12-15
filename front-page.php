<?php
/* Template Name: Home Page */
get_header();
?>

<!-- Hero Section -->
<section class="hero" style="background-image: url('https://images.unsplash.com/photo-1560448204-603b3fc33ddc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title"><?php the_field('title_heading'); ?></h1>
            <p class="hero__subtitle"><?php the_field('desc_title'); ?></p>
            <a href="/san-pham" class="btn btn--primary"><?php the_field('home_btn_heading_left'); ?></a>
            <a href="/ve-chung-toi" class="btn btn--secondary"><?php the_field('home_btn_heading_right'); ?></a>
        </div>
    </div>
</section>

<!-- Sửa thành các sản phẩm -->
<!-- Featured Products -->
<section class="section">
    <div class="container">
        <h2 class="section__title"><?php the_field('title_2'); ?></h2>
        <p class="section__subtitle"><?php the_field('sub_title_2'); ?></p>

        <div class="products">
            <?php
            $args = array(
                'post_type' => 'san-pham',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $product_id = get_the_ID();
                    $product_image = get_the_post_thumbnail_url($product_id, 'full');
                    $product_title = get_the_title();
                    $product_content = get_the_content();
                    $price = get_field('price', $product_id);
                    // Lấy taxonomy của sản phẩm
                    $product_cats = get_the_terms($product_id, 'product-category');
                    // Kiểm tra nếu có danh mục và lấy tên danh mục đầu tiên
                    $category_name = !empty($product_cats) ? $product_cats[0]->name : '';
                    // Lấy permalink của sản phẩm
                    $product_link = get_permalink($product_id);
            ?>
                    <div class="product-card">
                        <img src="<?= esc_url($product_image); ?>" alt="<?= esc_attr($product_title); ?>" class="product-card__image">
                        <div class="product-card__content">
                            <?php if (!empty($category_name)) : ?>
                                <div class="product-card__category"><?= esc_html($category_name); ?></div>
                            <?php endif; ?>
                            <h3 class="product-card__title"><?= esc_html($product_title); ?></h3>
                            <p class="product-card__description"><?= esc_html($product_content); ?></p>
                            <a href="<?= esc_url($product_link); ?>" class="btn btn--dark">Chi tiết</a>
                        </div>
                    </div>
            <?php
                }
                wp_reset_postdata();
            }
            ?>

        </div>

        <div class="section__action">
            <a href="/san-pham" class="btn btn--primary">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section section--alt">
    <div class="container">
        <h2 class="section__title"><?php the_field('title_3'); ?></h2>
        <p class="section__subtitle"><?php the_field('sub_title_3'); ?></p>


        <div class="categories">

            <?php
            $product_categories = get_terms(array(
                'taxonomy' => 'product-category',
                'per_page' => 6,
            ));

            foreach ($product_categories as $category) {
                $category_link = get_term_link($category);
                $category_name = $category->name;
                $category_image = get_field('image', 'product-category_' . $category->term_id); // Lấy ảnh từ custom field

            ?>
                <a href="<?= $category_link ?>" class="category">
                    <div class="category__image" style="background-image: url('https://images.unsplash.com/photo-1594026112284-02bb6f3352fe?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                        <div class="category__content">
                            <h3 class="category__title"><?= $category_name ?></h3>
                        </div>
                    </div>
                </a>
            <?php }; ?>

        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section">
    <div class="container">
        <h2 class="section__title"><?php the_field('title_4'); ?></h2>
        <p class="section__subtitle"><?php the_field('sub_title_4'); ?></p>

        <div class="features">
            <?php
            $query = new WP_Query(array('post_type' => 'advantage'));
            while ($query->have_posts()) {
                $query->the_post();
                $advantage_id = get_the_ID();
                $advantage_title = $query->post->post_title;
                $advantage_description = get_field('desc', $advantage_id);
                $advantage_icon = get_field('icons', $advantage_id);
            ?>
                <div class="feature">
                    <div class="feature__icon">
                        <i class="dashicons <?= esc_attr($advantage_icon); ?>"></i>
                    </div>
                    <h3 class="feature__title"><?= esc_html($advantage_title); ?></h3>
                    <p class="feature__description"><?= esc_html($advantage_description); ?></p>
                </div>
            <?php
            }
            wp_reset_postdata();
            ?>
        </div>


    </div>
</section>

<!-- Latest Articles -->
<?php
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'category_name'  => 'goc-cam-hung', // thay bằng slug của category bạn muốn
    'orderby'        => 'date',
    'order'          => 'DESC'
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
    <section class="section section--alt">
        <div class="container">
            <h2 class="section__title"><?php the_field('title_5'); ?></h2>
            <p class="section__subtitle"><?php the_field('sub_title_5'); ?></p>

            <div class="articles">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    $article_id = get_the_ID();
                    $article_title = get_the_title($article_id);
                    $short_desc = get_field('short_desc', $article_id);
                    $article_image = get_field('thumbnail', $article_id);
                    $created_at = get_the_date('d/m/Y', $article_id);
                ?>
                    <div class="article-card">
                        <img src="<?= esc_url($article_image); ?>" alt="<?= esc_attr($article_title); ?>" class="article-card__image">
                        <div class="article-card__content">
                            <div class="article-card__date"><?= esc_html($created_at); ?></div>
                            <h3 class="article-card__title"><?php echo $article_title ?></h3>
                            <p class="article-card__excerpt"><?php echo esc_html($short_desc); ?></p>
                            <a href="<?php echo get_permalink($article_id); ?>" class="btn btn--dark">Xem thêm</a>
                        </div>
                    </div>
                <?php
                }
                wp_reset_postdata();
                ?>
            </div>

            <div class="section__action">
                <a href="/bai-viet" class="btn btn--primary">Xem tất cả bài viết</a>
            </div>
        </div>
    </section>
<?php
endif;
?>

<!-- Testimonials -->
<?php
$args = array(
    'post_type'      => 'customer-comments',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC'
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
    <section class="section">
        <div class="container">
            <h2 class="section__title"><?php the_field('title_6'); ?></h2>
            <p class="section__subtitle"><?php the_field('sub_title_6'); ?></p>

            <div class="testimonials">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    $customer_id = get_the_ID();
                    $name = get_field('name', $customer_id);
                    $job = get_field('work', $customer_id);
                    $avatar = get_field('avatar', $customer_id);
                    $content = get_field('content', $customer_id);
                ?>
                    <div class="testimonial">
                        <div class="testimonial__quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial__text"><?= esc_html($content); ?></p>
                        <div class="testimonial__author">
                            <img src="<?= esc_url($avatar); ?>" alt="<?= esc_attr($name); ?>" class="testimonial__author-image">
                            <div class="testimonial__author-info">
                                <h4 class="testimonial__author-name"><?= esc_html($name); ?></h4>
                                <p class="testimonial__author-title"><?= esc_html($job); ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
<?php
endif;
?>

<?php get_template_part('section', 'newsletter'); ?>


<!-- Footer -->
<?php get_footer(); ?>