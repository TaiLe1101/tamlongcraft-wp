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



<!-- Categories Section -->
<?php
$product_categories = get_terms(array(
    'taxonomy' => 'product-category',
    'hide_empty' => false,
));

if (!empty($product_categories) && !is_wp_error($product_categories)) :
?>
    <section class="section section--alt">
        <div class="container">
            <h2 class="section__title"><?php the_field('title_3'); ?></h2>
            <p class="section__subtitle"><?php the_field('sub_title_3'); ?></p>
        </div>

        <div class="categories-slider">
            <div class="swiper categoriesSwiper">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($product_categories as $category) {
                        $category_link = get_term_link($category);
                        $category_name = $category->name;
                        $category_image = get_field('thumbnail', 'product-category_' . $category->term_id);

                        // Sử dụng ảnh từ ACF hoặc ảnh mặc định
                        $image_url = $category_image ? $category_image : 'https://images.unsplash.com/photo-1594026112284-02bb6f3352fe?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                    ?>
                        <div class="swiper-slide">
                            <a href="<?= esc_url($category_link); ?>" class="category-slide">
                                <div class="category-slide__image" style="background-image: url('<?= esc_url($image_url); ?>');">
                                    <div class="category-slide__overlay"></div>
                                    <div class="category-slide__content">
                                        <h3 class="category-slide__title"><?= esc_html($category_name); ?></h3>
                                        <span class="category-slide__arrow"><i class="fas fa-arrow-right"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <style>
        .categories-slider {
            position: relative;
            max-width: 100%;
            padding: 40px 80px;
            margin: 0;
        }

        .categoriesSwiper {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding-bottom: 60px;
        }

        .swiper-slide {
            height: auto;
        }

        .category-slide {
            display: block;
            text-decoration: none;
            height: 400px;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-slide:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }

        .category-slide__image {
            width: 100%;
            height: 100%;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-slide:hover .category-slide__image {
            transform: scale(1.05);
        }

        .category-slide__overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.7) 100%);
            transition: background 0.4s ease;
        }

        .category-slide:hover .category-slide__overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.8) 100%);
        }

        .category-slide__content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 35px;
            color: white;
            z-index: 2;
            transform: translateY(0);
            transition: transform 0.4s ease;
        }

        .category-slide__title {
            font-family: var(--font-primary);
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: white;
            letter-spacing: 0.5px;
            line-height: 1.3;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .category-slide__arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--color-gold);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        .category-slide:hover .category-slide__arrow {
            transform: translateX(8px) scale(1.1);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.6);
        }

        .category-slide__arrow i {
            font-size: 1.2rem;
        }

        /* Navigation Buttons */
        .swiper-button-next,
        .swiper-button-prev {
            width: 55px;
            height: 55px;
            background: white;
            border-radius: 50%;
            color: var(--color-dark);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.3rem;
            font-weight: bold;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: var(--color-gold);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        }

        .swiper-button-next.swiper-button-disabled,
        .swiper-button-prev.swiper-button-disabled {
            opacity: 0.4;
        }

        /* Pagination */
        .swiper-pagination {
            bottom: 10px !important;
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: var(--color-gold);
            width: 30px;
            border-radius: 6px;
        }

        /* Responsive */
        30px 60px;
        }

        .category-slide {
            height: 350px;
        }

        .category-slide__title {
            font-size: 1.5rem;
        }
        }

        @media (max-width: 768px) {
            .categories-slider {
                padding: 20px 30 @media (max-width: 768px) {
                    .categories-slider {
                        padding: 0 15px;
                    }

                    .category-slide {
                        height: 320px;
                        border-radius: 15px;
                    }

                    .category-slide__content {
                        padding: 25px;
                    }

                    .category-slide__title {
                        font-size: 1.4rem;
                    }

                    .category-slide__arrow {
                        width: 45px;
                        height: 45px;
                    }

                    .swiper-button-next,
                    .swiper-button-prev {
                        width: 45px;
                        height: 45px;
                    }

                    .swiper-button-next:after,
                    .swiper-button-prev:after {
                        font-size: 1.1rem;
                    }
                }

                @media (max-width: 480px) {
                    .category-slide {
                        height: 280px;
                    }

                    .category-slide__title {
                        font-size: 1.25rem;
                    }

                    .swiper-button-next,
                    .swiper-button-prev {
                        display: none;
                    }
                }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swiper !== 'undefined') {
                new Swiper('.categoriesSwiper', {
                    slidesPerView: 1,
                    spaceBetween: 25,
                    loop: true,
                    speed: 800,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    effect: 'slide',
                    grabCursor: true,
                    breakpoints: {
                        480: {
                            slidesPerView: 1.5,
                            spaceBetween: 20,
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 25,
                        },
                        768: {
                            slidesPerView: 2.5,
                            spaceBetween: 30,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        1280: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                    }
                });
            }
        });
    </script>
<?php
endif;
?>



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