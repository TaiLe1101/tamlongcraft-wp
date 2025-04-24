<?php
get_header();
?>

<?php

$title = get_the_title(get_the_ID());

// Get name category
$category = get_the_category(get_the_ID());
$category_name = $category[0]->name;

// Lấy author avatar link và name
$author_id = get_the_author_meta('ID');
$author_avatar = get_avatar_url($author_id, ['size' => 64]);
$author_name = get_the_author_meta('display_name', $author_id);

// Lấy ngày tạo bài viết
$post_date = get_the_date('j \T\h\á\n\g n, Y', get_the_ID());

// Lấy nội dung bài viết
$content = get_the_content(get_the_ID());

// Lấy tất cả tags của bài viết
$tags = get_the_tags(get_the_ID());

// Lấy thời gian đọc ACF
$reading_time = get_field('read_time', get_the_ID());

?>

<!-- Article Header -->
<section class="article-header" style="background-image: url('https://images.unsplash.com/photo-1616046229478-9901c5536a45?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <div class="article-header__content">
            <div class="article-header__category"><?php echo $category_name; ?></div>
            <h1 class="article-header__title"><?php echo $title; ?></h1>
            <div class="article-header__meta">
                <div class="article-header__author">
                    <img src="<?php echo $author_avatar; ?>" alt="Sophia Reynolds" class="article-header__author-image">
                    <span>Bởi <?php echo $author_name; ?></span>
                </div>
                <div class="article-header__date"><i class="far fa-calendar-alt"></i> <?php echo $post_date; ?></div>
                <div class="article-header__reading-time"><i class="far fa-clock"></i> <?php echo esc_html($reading_time); ?> phút đọc</div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="section">
    <div class="container">
        <div class="article-layout">
            <div class="article-layout__main">
                <article class="article-content">

                    <div class="article-content__body">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>

                    <!-- Article Tags -->
                    <div class="article-tags">
                        <?php if ($tags) : ?>
                            <span class="article-tags__label">Thẻ:</span>
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="article-tags__tag"><?php echo esc_html($tag->name); ?></a>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <span class="article-tags__label">Thẻ:</span>
                            <span class="article-tags__tag">Không có thẻ nào</span>
                        <?php endif; ?>
                    </div>

                    <!-- Article Share -->
                    <div class="article-share">
                        <?php
                        // Lấy đường dẫn permalink và tiêu đề bài viết (đã mã hóa URL)
                        $share_url = urlencode(get_permalink());
                        $share_title = urlencode(get_the_title());

                        // Tạo URL chia sẻ cho các nền tảng xã hội
                        $facebook_url = "https://www.facebook.com/sharer/sharer.php?u={$share_url}";
                        $twitter_url = "https://twitter.com/intent/tweet?url={$share_url}&text={$share_title}";
                        $linkedin_url = "https://www.linkedin.com/sharing/share-offsite/?url={$share_url}";
                        $pinterest_url = "https://pinterest.com/pin/create/button/?url={$share_url}&description={$share_title}";
                        $email_url = "mailto:?subject={$share_title}&body=" . urlencode("Tôi nghĩ bạn sẽ thích bài viết này: ") . $share_url;
                        $whatsapp_url = "https://api.whatsapp.com/send?text={$share_title}%20-%20{$share_url}";
                        ?>

                        <span class="article-share__label">Chia sẻ bài viết này:</span>
                        <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" class="article-share__link article-share__link--facebook"><i class="fab fa-facebook-f"></i></a>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments">
                        <?php
                        // Lấy số lượng comment của bài viết
                        $comments_count = get_comments_number();
                        $comments_title = $comments_count > 0 ? sprintf('%d Bình Luận', $comments_count) : 'Chưa có bình luận';
                        ?>
                        <h3 class="comments__title"><?php echo $comments_title; ?></h3>

                        <?php
                        // Lấy danh sách comment
                        $comments = get_comments(array(
                            'post_id' => get_the_ID(),
                            'status' => 'approve', // Chỉ lấy comment đã được duyệt
                            'order' => 'ASC', // Sắp xếp từ cũ đến mới
                        ));

                        // Hiển thị danh sách comment
                        if ($comments) {
                            // Tạo mảng để theo dõi comment đã hiển thị
                            $displayed_comments = array();

                            // Hiển thị comment gốc trước
                            foreach ($comments as $comment) {
                                // Nếu là comment gốc (không phải reply)
                                if ($comment->comment_parent == 0) {
                                    // Lấy thông tin comment
                                    $comment_id = $comment->comment_ID;
                                    $comment_author = $comment->comment_author;
                                    $comment_date = date_i18n('j \T\h\á\n\g n, Y', strtotime($comment->comment_date));
                                    $comment_content = $comment->comment_content;
                                    $avatar = get_avatar_url($comment->comment_author_email, array('size' => 64));

                                    // Thêm vào danh sách đã hiển thị
                                    $displayed_comments[] = $comment_id;
                        ?>
                                    <div class="comment" data-comment-id="<?php echo $comment_id; ?>">
                                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($comment_author); ?>" class="comment__avatar">
                                        <div class="comment__content">
                                            <div class="comment__header">
                                                <h4 class="comment__author"><?php echo esc_html($comment_author); ?></h4>
                                                <div class="comment__date"><?php echo esc_html($comment_date); ?></div>
                                            </div>
                                            <div class="comment__text">
                                                <p><?php echo wp_kses_post($comment_content); ?></p>
                                            </div>
                                            <div class="comment__actions">
                                                <a href="#" class="comment__reply">Trả lời</a>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    // Tìm và hiển thị các reply của comment này
                                    foreach ($comments as $reply) {
                                        if ($reply->comment_parent == $comment_id) {
                                            // Lấy thông tin reply
                                            $reply_id = $reply->comment_ID;
                                            $reply_author = $reply->comment_author;
                                            $reply_date = date_i18n('j \T\h\á\n\g n, Y', strtotime($reply->comment_date));
                                            $reply_content = $reply->comment_content;
                                            $reply_avatar = get_avatar_url($reply->comment_author_email, array('size' => 64));

                                            // Thêm vào danh sách đã hiển thị
                                            $displayed_comments[] = $reply_id;
                                    ?>
                                            <div class="comment comment--reply" data-comment-id="<?php echo $reply_id; ?>">
                                                <img src="<?php echo esc_url($reply_avatar); ?>" alt="<?php echo esc_attr($reply_author); ?>" class="comment__avatar">
                                                <div class="comment__content">
                                                    <div class="comment__header">
                                                        <h4 class="comment__author"><?php echo esc_html($reply_author); ?></h4>
                                                        <div class="comment__date"><?php echo esc_html($reply_date); ?></div>
                                                    </div>
                                                    <div class="comment__text">
                                                        <p><?php echo wp_kses_post($reply_content); ?></p>
                                                    </div>
                                                    <div class="comment__actions">
                                                        <a href="#" class="comment__reply">Trả lời</a>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                }
                            }

                            // Kiểm tra nếu có comment chưa được hiển thị (các reply sâu hơn)
                            foreach ($comments as $comment) {
                                if (!in_array($comment->comment_ID, $displayed_comments)) {
                                    // Tìm comment gốc
                                    $parent_id = $comment->comment_parent;
                                    $parent_comment = get_comment($parent_id);

                                    // Lấy thông tin comment
                                    $comment_id = $comment->comment_ID;
                                    $comment_author = $comment->comment_author;
                                    $comment_date = date_i18n('j \T\h\á\n\g n, Y', strtotime($comment->comment_date));
                                    $comment_content = $comment->comment_content;
                                    $avatar = get_avatar_url($comment->comment_author_email, array('size' => 64));

                                    // Hiển thị như reply
                                    ?>
                                    <div class="comment comment--reply" data-comment-id="<?php echo $comment_id; ?>">
                                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($comment_author); ?>" class="comment__avatar">
                                        <div class="comment__content">
                                            <div class="comment__header">
                                                <h4 class="comment__author"><?php echo esc_html($comment_author); ?></h4>
                                                <div class="comment__date"><?php echo esc_html($comment_date); ?></div>
                                            </div>
                                            <div class="comment__text">
                                                <p><?php echo wp_kses_post($comment_content); ?></p>
                                            </div>
                                            <div class="comment__actions">
                                                <a href="#" class="comment__reply">Trả lời</a>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        } else {
                            // Hiển thị thông báo nếu không có comment
                            echo '<div class="comments-empty">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</div>';
                        }
                        ?>

                        <!-- Comment Form -->
                        <div class="comment-form">
                            <h3 class="comment-form__title">Để Lại Bình Luận</h3>
                            <div id="respond" class="comment-respond">
                                <form id="commentform" class="comment-form">
                                    <div class="comment-form__grid">
                                        <div class="form-group">
                                            <label for="author" class="form-label">Tên</label>
                                            <input type="text" id="author" name="author" class="form-input" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-input" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment" class="form-label">Bình luận</label>
                                        <textarea id="comment" name="comment" class="form-textarea" rows="5" required></textarea>
                                    </div>
                                    <div class="form-group form-group--checkbox">
                                        <input type="checkbox" id="save-info" name="save-info" class="form-checkbox" value="1">
                                        <label for="save-info" class="form-checkbox-label">Lưu tên và email của tôi cho lần bình luận tiếp theo</label>
                                    </div>
                                    <input type="hidden" name="comment_post_ID" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                                    <div class="comment-form__message"></div>
                                    <button type="submit" class="btn btn--primary">Đăng Bình Luận</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Related Articles -->
                <div class="related-articles">
                    <h3 class="related-articles__title">Bạn Cũng Có Thể Thích</h3>
                    <div class="related-articles__grid">
                        <?php
                        // Lấy ID của bài viết hiện tại
                        $current_post_id = get_the_ID();
                        
                        // Lấy danh mục của bài viết hiện tại
                        $categories = get_the_category($current_post_id);
                        
                        if ($categories) {
                            // Lấy ID của các danh mục
                            $category_ids = array();
                            foreach ($categories as $category) {
                                $category_ids[] = $category->term_id;
                            }
                            
                            // Thiết lập truy vấn để lấy các bài viết liên quan
                            $related_args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 3, // Hiển thị 3 bài viết liên quan
                                'post__not_in' => array($current_post_id), // Loại trừ bài viết hiện tại
                                'category__in' => $category_ids, // Lấy bài viết từ cùng danh mục
                                'orderby' => 'rand', // Sắp xếp ngẫu nhiên
                                'post_status' => 'publish' // Chỉ lấy bài viết đã xuất bản
                            );
                            
                            $related_query = new WP_Query($related_args);
                            
                            // Kiểm tra xem có bài viết liên quan không
                            if ($related_query->have_posts()) {
                                while ($related_query->have_posts()) {
                                    $related_query->the_post();
                                    
                                    // Lấy ảnh đại diện hoặc dùng ảnh mặc định nếu không có
                                    $thumbnail_url = has_post_thumbnail() ? 
                                        get_the_post_thumbnail_url(get_the_ID(), 'medium') : 
                                        'https://images.unsplash.com/photo-1618220179428-22790b461013?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                                    
                                    // Lấy danh mục đầu tiên của bài viết
                                    $post_categories = get_the_category();
                                    $category_name = !empty($post_categories) ? esc_html($post_categories[0]->name) : 'Chưa phân loại';
                                    ?>
                                    
                                    <div class="related-article">
                                        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="related-article__image">
                                        <div class="related-article__category"><?php echo $category_name; ?></div>
                                        <h4 class="related-article__title"><?php echo esc_html(get_the_title()); ?></h4>
                                        <a href="<?php the_permalink(); ?>" class="related-article__link">Đọc Bài Viết <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                    
                                <?php
                                }
                                // Khôi phục dữ liệu bài viết gốc
                                wp_reset_postdata();
                            } else {
                                // Hiển thị thông báo nếu không có bài viết liên quan
                                echo '<div class="related-articles__empty">Không có bài viết liên quan nào.</div>';
                            }
                        } else {
                            // Hiển thị thông báo nếu bài viết không có danh mục
                            echo '<div class="related-articles__empty">Không có bài viết liên quan nào.</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <!-- Categories -->
                <div class="sidebar__widget">
                    <h3 class="sidebar__widget-title">Danh Mục</h3>
                    <ul class="categories">
                        <?php
                        // Lấy tất cả các danh mục
                        $categories = get_categories(array(
                            'orderby' => 'name',
                            'order'   => 'ASC',
                            'hide_empty' => true,
                        ));

                        // Hiển thị từng danh mục
                        if (!empty($categories)) {
                            foreach ($categories as $cat) {
                                printf(
                                    '<li class="categories__item"><a href="%s" class="categories__link">%s <span class="categories__count">%s</span></a></li>',
                                    esc_url(get_category_link($cat->term_id)),
                                    esc_html($cat->name),
                                    esc_html($cat->count)
                                );
                            }
                        } else {
                            echo '<li class="categories__item">Không có danh mục nào</li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- Recent Posts -->
                <div class="sidebar__widget">
                    <h3 class="sidebar__widget-title">Bài Viết Gần Đây</h3>
                    <div class="recent-posts">
                        <?php
                        // Get current post ID to exclude it from the query
                        $current_post_id = get_the_ID();

                        // Setup arguments for WP_Query
                        $recent_posts_args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 4,
                            'post_status' => 'publish',
                            'post__not_in' => array($current_post_id), // Exclude current post
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );

                        // Create a new WP_Query instance
                        $recent_posts_query = new WP_Query($recent_posts_args);

                        // Check if there are posts
                        if ($recent_posts_query->have_posts()) :
                            // Loop through posts
                            while ($recent_posts_query->have_posts()) : $recent_posts_query->the_post();
                                // Get featured image or fallback image
                                $thumbnail_url = has_post_thumbnail() ?
                                    get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') :
                                    'https://images.unsplash.com/photo-1618220179428-22790b461013?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';

                                // Format post date
                                $post_date = get_the_date('j \T\h\á\n\g n, Y');
                        ?>
                                <div class="recent-post">
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="recent-post__image">
                                    <div class="recent-post__content">
                                        <h4 class="recent-post__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="recent-post__date"><?php echo esc_html($post_date); ?></div>
                                    </div>
                                </div>
                        <?php
                            endwhile;

                            // Restore original post data
                            wp_reset_postdata();
                        else :
                            // If no posts are found
                            echo '<div class="recent-post">Không có bài viết gần đây nào.</div>';
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Featured Products -->
                <div class="sidebar__widget">
                    <h3 class="sidebar__widget-title">Sản Phẩm Nổi Bật</h3>
                    <div class="sidebar-products">
                        <?php
                        // Lấy sản phẩm nổi bật
                        $featured_products_args = array(
                            'post_type' => 'san-pham',
                            'posts_per_page' => 3,
                            'post_status' => 'publish',
                            'meta_query' => array(
                                array(
                                    'key' => 'featured_product',
                                    'value' => '1',
                                    'compare' => '='
                                )
                            ),
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );

                        // Nếu không có trường meta 'featured_product', hãy lấy các sản phẩm mới nhất
                        $featured_products_query = new WP_Query($featured_products_args);

                        // Nếu không có sản phẩm nổi bật, lấy sản phẩm mới nhất
                        if (!$featured_products_query->have_posts()) {
                            wp_reset_postdata();
                            $featured_products_args = array(
                                'post_type' => 'san-pham',
                                'posts_per_page' => 3,
                                'post_status' => 'publish',
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                            $featured_products_query = new WP_Query($featured_products_args);
                        }

                        // Kiểm tra nếu có sản phẩm
                        if ($featured_products_query->have_posts()) :
                            // Duyệt qua các sản phẩm
                            while ($featured_products_query->have_posts()) : $featured_products_query->the_post();
                                // Lấy ảnh đại diện hoặc ảnh thay thế
                                $thumbnail_url = has_post_thumbnail() ?
                                    get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') :
                                    'https://images.unsplash.com/photo-1618220179428-22790b461013?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';

                                // Lấy giá sản phẩm (giả sử có trường meta 'price')
                                $price = get_post_meta(get_the_ID(), 'price', true);
                                $formatted_price = !empty($price) ? number_format($price, 0, ',', '.') . '₫' : 'Liên hệ';
                        ?>
                                <div class="sidebar-product">
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="sidebar-product__image">
                                    <div class="sidebar-product__content">
                                        <h4 class="sidebar-product__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="sidebar-product__price"><?php echo esc_html($formatted_price); ?></div>
                                    </div>
                                </div>
                        <?php
                            endwhile;

                            // Khôi phục dữ liệu bài viết gốc
                            wp_reset_postdata();
                        else :
                            // Nếu không tìm thấy sản phẩm nào
                            echo '<div class="sidebar-product">Không có sản phẩm nổi bật nào.</div>';
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Tags -->
                <div class="sidebar__widget">
                    <h3 class="sidebar__widget-title">Thẻ Phổ Biến</h3>
                    <div class="tags">
                        <?php
                        // Lấy các thẻ phổ biến nhất dựa trên số lượng bài viết
                        $popular_tags = get_tags(array(
                            'orderby' => 'count', // Sắp xếp theo số lượng bài viết
                            'order'   => 'DESC',  // Từ cao xuống thấp
                            'number'  => 12,      // Giới hạn số lượng thẻ hiển thị
                            'hide_empty' => true  // Chỉ hiển thị thẻ có bài viết
                        ));

                        // Kiểm tra nếu có thẻ nào
                        if (!empty($popular_tags)) {
                            foreach ($popular_tags as $tag) {
                                printf(
                                    '<a href="%s" class="tags__item">%s</a>',
                                    esc_url(get_tag_link($tag->term_id)),
                                    esc_html($tag->name)
                                );
                            }
                        } else {
                            // Hiển thị thông báo nếu không có thẻ nào
                            echo '<span class="tags__empty">Chưa có thẻ nào</span>';
                        }
                        ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="section section--newsletter" style="background-image: url('https://images.unsplash.com/photo-1618220179428-22790b461013?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <div class="newsletter">
            <h2 class="newsletter__title">Tham Gia Danh Sách Gửi Thư</h2>
            <p class="newsletter__subtitle">Đăng ký để nhận các mẹo thiết kế độc quyền, thông báo sản phẩm mới và ưu đãi đặc biệt.</p>
            <form class="newsletter__form" id="newsletter-form">
                <input type="email" name="subscriber_email" placeholder="Địa Chỉ Email Của Bạn" class="newsletter__input" required>
                <button type="submit" class="btn btn--primary newsletter__btn">Đăng Ký</button>
                <?php wp_nonce_field('newsletter_nonce_action', 'newsletter_nonce'); ?>
            </form>
            <div class="newsletter__message" style="display: none;"></div>
        </div>
    </div>
</section>

<?php
get_footer();
?>