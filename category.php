<?php
/**
 * Template cho trang danh mục (Category)
 */
get_header();
?>

<main class="main-content">
    <section class="articles-hero">
        <div class="container">
            <h1 class="articles-hero__title"><?php single_cat_title(); ?></h1>
            <div class="articles-hero__description">
                <?php echo category_description(); ?>
            </div>
        </div>
    </section>

    <section class="articles-content">
        <div class="container">
            <div class="filter">
                <div class="filter__categories">
                    <div class="filter__label">Danh mục:</div>
                    <div class="filter__options">
                        <button class="filter__option filter__option--active" data-category="all">Tất cả</button>
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) {
                            printf(
                                '<button class="filter__option" data-category="%1$s">%2$s</button>',
                                esc_attr($category->term_id),
                                esc_html($category->name)
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="articles-grid">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
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
                            $thumbnail = get_theme_file_uri('/images/articles/placeholder.jpg');
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
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="articles-empty">Không tìm thấy bài viết nào.</div>
                <?php endif; ?>
            </div>

            <div class="pagination">
                <?php
                $total_pages = $wp_query->max_num_pages;
                if ($total_pages > 1) :
                    $current_page = max(1, get_query_var('paged'));
                    
                    // Previous page arrow
                    if ($current_page > 1) :
                        echo '<a href="' . esc_url(get_pagenum_link($current_page - 1)) . '" class="pagination__arrow pagination__arrow--prev"><i class="fas fa-chevron-left"></i></a>';
                    else :
                        echo '<span class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled"><i class="fas fa-chevron-left"></i></span>';
                    endif;
                    
                    // Page numbers
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);
                    
                    for ($i = $start_page; $i <= $end_page; $i++) :
                        if ($i == $current_page) :
                            echo '<span class="pagination__number pagination__number--active">' . $i . '</span>';
                        else :
                            echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="pagination__number">' . $i . '</a>';
                        endif;
                    endfor;
                    
                    // Next page arrow
                    if ($current_page < $total_pages) :
                        echo '<a href="' . esc_url(get_pagenum_link($current_page + 1)) . '" class="pagination__arrow pagination__arrow--next"><i class="fas fa-chevron-right"></i></a>';
                    else :
                        echo '<span class="pagination__arrow pagination__arrow--next pagination__arrow--disabled"><i class="fas fa-chevron-right"></i></span>';
                    endif;
                endif;
                ?>
            </div>
        </div>
    </section>

    <?php get_template_part('section', 'newsletter'); ?>
</main>

<?php get_footer(); ?>