<?php
/* Template Name: Bài viết */
get_header();
?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1616046229478-9901c5536a45?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <h1 class="page-header__title">Kiến Thức Thiết Kế Nội Thất</h1>
        <p class="page-header__subtitle">Lời khuyên chuyên gia, xu hướng và cảm hứng cho ngôi nhà của bạn.</p>
    </div>
</section>

<!-- Bài viết -->
<section class="section">
    <div class="container">
        <div class="articles-filter">
            <button class="articles-filter__btn articles-filter__btn--active" data-filter="all">Tất cả bài viết</button>
            <?php
            // Lấy tất cả các danh mục có bài viết
            $categories = get_categories(array(
                'orderby' => 'name',
                'order'   => 'ASC',
                'hide_empty' => true, // Chỉ lấy danh mục có bài viết
            ));
            
            // Hiển thị các nút lọc cho từng danh mục
            foreach ($categories as $category) {
                // Tạo một data-filter dựa trên ID danh mục
                $filter_value = $category->term_id;
                echo '<button class="articles-filter__btn" data-filter="' . esc_attr($filter_value) . '">' . esc_html($category->name) . '</button>';
            }
            ?>
        </div>

        <div class="articles articles--grid">
            <?php
            // Thiết lập tham số truy vấn để lấy tất cả bài viết cho lần hiển thị đầu tiên
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 9, // Giới hạn số bài viết mỗi trang
                'post_status'    => 'publish',
            );
            
            // Tạo đối tượng WP_Query
            $query = new WP_Query($args);
            
            // Kiểm tra xem có bài viết nào không
            if ($query->have_posts()) :
                // Bắt đầu vòng lặp
                while ($query->have_posts()) : $query->the_post();
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
                endwhile;
                
                // Khôi phục dữ liệu bài viết gốc
                wp_reset_postdata();
            else:
                // Hiển thị thông báo nếu không có bài viết nào
                echo '<p>Không có bài viết nào.</p>';
            endif;
            ?>
        </div>

        <?php
        // Kiểm tra xem có nhiều trang không để hiển thị phân trang
        if ($query->max_num_pages > 1) :
        ?>
        <div class="pagination">
            <?php
            $current_page = 1;
            $total_pages = $query->max_num_pages;
            
            // Previous page arrow (disabled for first page)
            echo '<span class="pagination__arrow pagination__arrow--prev pagination__arrow--disabled"><i class="fas fa-chevron-left"></i></span>';
            
            // Page numbers
            for ($i = 1; $i <= min(5, $total_pages); $i++) :
                $active_class = ($i === 1) ? 'pagination__number--active' : '';
            ?>
            <a href="#" class="pagination__number <?php echo $active_class; ?>" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if ($total_pages > 1) : ?>
            <a href="#" class="pagination__arrow pagination__arrow--next" data-page="2"><i class="fas fa-chevron-right"></i></a>
            <?php else : ?>
            <span class="pagination__arrow pagination__arrow--next pagination__arrow--disabled"><i class="fas fa-chevron-right"></i></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
                
<?php get_template_part('section', 'newsletter'); ?>

<?php
get_footer();
?>