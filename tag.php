<?php
get_header();

// Lấy thông tin tag hiện tại
$tag = get_queried_object();
$tag_name = $tag->name;
$tag_description = $tag->description;
?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1616046229478-9901c5536a45?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <h1 class="page-header__title">Thẻ: <?php echo esc_html($tag_name); ?></h1>
        <?php if (!empty($tag_description)) : ?>
            <p class="page-header__subtitle"><?php echo esc_html($tag_description); ?></p>
        <?php else : ?>
            <p class="page-header__subtitle">Những bài viết được gắn thẻ "<?php echo esc_html($tag_name); ?>"</p>
        <?php endif; ?>
    </div>
</section>

<!-- Bài viết -->
<section class="section">
    <div class="container">
        <div class="articles-filter">
            <a style="padding: 2px 16px;" href="<?php echo esc_url(get_permalink(get_page_by_path('bai-viet'))); ?>" class="articles-filter__btn">Tất cả bài viết</a>
            <button style="padding: 2px 16px;" class="articles-filter__btn articles-filter__btn--active"><?php echo esc_html($tag_name); ?></button>
            
            <?php
            // Lấy một số thẻ tag phổ biến khác để hiển thị
            $tags = get_tags(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 5,
                'exclude' => $tag->term_id // Loại trừ tag hiện tại
            ));
            
            if (!empty($tags)) {
                foreach ($tags as $other_tag) {
                    echo '<a href="' . esc_url(get_tag_link($other_tag->term_id)) . '" class="articles-filter__btn">' . esc_html($other_tag->name) . '</a>';
                }
            }
            ?>
        </div>

        <div class="articles articles--grid">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    // Lấy danh mục của bài viết hiện tại
                    $categories = get_the_category();
                    $category_name = '';
                    
                    // Lấy danh mục đầu tiên nếu có
                    if (!empty($categories)) {
                        $category_name = $categories[0]->name;
                    }
                    
                    // Lấy hình ảnh đại diện
                    $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    if (!$thumbnail) {
                        $thumbnail = 'https://images.unsplash.com/photo-1616137422495-1e9e46e2aa77?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                    }
                    
                    // Lấy ngày đăng bài
                    $post_date = get_the_date('j \T\h\á\n\g n, Y');
            ?>
                    <div class="article-card">
                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>" class="article-card__image">
                        <div class="article-card__content">
                            <div class="article-card__meta">
                                <div class="article-card__date"><?php echo esc_html($post_date); ?></div>
                                <?php if (!empty($category_name)) : ?>
                                    <div class="article-card__category"><?php echo esc_html($category_name); ?></div>
                                <?php endif; ?>
                            </div>
                            <h3 class="article-card__title"><?php the_title(); ?></h3>
                            <p class="article-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn--dark">Đọc thêm</a>
                        </div>
                    </div>
            <?php
                endwhile;
            else :
                echo '<div class="articles-empty">Không có bài viết nào với thẻ này.</div>';
            endif;
            ?>
        </div>

        <?php
        // Hiển thị phân trang
        $total_pages = $wp_query->max_num_pages;
        if ($total_pages > 1) :
        ?>
        <div class="pagination">
            <?php
            $current_page = max(1, get_query_var('paged'));
            
            // Previous page arrow
            if ($current_page > 1) {
                echo '<a href="' . esc_url(get_pagenum_link($current_page - 1)) . '" class="pagination__arrow pagination__arrow--prev"><i class="fas fa-chevron-left"></i></a>';
            } else {
                echo '<span class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled"><i class="fas fa-chevron-left"></i></span>';
            }
            
            // Page numbers
            $start_page = max(1, $current_page - 2);
            $end_page = min($total_pages, $current_page + 2);
            
            for ($i = $start_page; $i <= $end_page; $i++) {
                $active_class = ($i === $current_page) ? 'pagination__number--active' : '';
                echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="pagination__number ' . $active_class . '">' . $i . '</a>';
            }
            
            // Next page arrow
            if ($current_page < $total_pages) {
                echo '<a href="' . esc_url(get_pagenum_link($current_page + 1)) . '" class="pagination__arrow pagination__arrow--next"><i class="fas fa-chevron-right"></i></a>';
            } else {
                echo '<span class="pagination__arrow pagination__arrow--next pagination__arrow--disabled"><i class="fas fa-chevron-right"></i></span>';
            }
            ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Related Tags -->
<section class="section section--light">
    <div class="container">
        <h2 class="section__title">Các Thẻ Liên Quan</h2>
        <div class="tags-cloud">
            <?php
            $tags = get_tags(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 20,
            ));
            
            if ($tags) {
                foreach ($tags as $tag) {
                    $tag_link = get_tag_link($tag->term_id);
                    $active_class = ($tag->term_id === get_queried_object_id()) ? 'tags-cloud__tag--active' : '';
                    echo '<a href="' . esc_url($tag_link) . '" class="tags-cloud__tag ' . $active_class . '">' . esc_html($tag->name) . ' (' . $tag->count . ')</a>';
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="section section--newsletter" style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <div class="newsletter">
            <h2 class="newsletter__title">Đăng Ký Nhận Bản Tin</h2>
            <p class="newsletter__subtitle">Cập nhật những bài viết mới nhất và mẹo thiết kế của chúng tôi.</p>
            <form class="newsletter__form" id="newsletter-form">
                <?php wp_nonce_field('newsletter_nonce_action', 'newsletter_nonce'); ?>
                <input type="email" name="subscriber_email" placeholder="Địa Chỉ Email Của Bạn" class="newsletter__input" required>
                <button type="submit" class="btn btn--primary newsletter__submit">Đăng Ký</button>
            </form>
            <div class="newsletter__message"></div>
        </div>
    </div>
</section>

<?php
get_footer();
?>