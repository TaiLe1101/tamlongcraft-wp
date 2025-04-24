<?php
/**
 * Template cho trang danh mục sản phẩm (Product Category)
 */
get_header();

// Lấy thông tin term hiện tại
$current_term = get_queried_object();
?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('<?php echo get_theme_file_uri('images/products-header.jpg'); ?>');">
    <div class="container">
        <h1 class="page-header__title"><?php echo $current_term->name; ?></h1>
        <div class="breadcrumbs">
            <a href="<?= esc_url(home_url()); ?>" class="breadcrumbs__link">Trang chủ</a>
            <span class="breadcrumbs__separator">/</span>
            <a href="<?= esc_url(home_url('/san-pham')); ?>" class="breadcrumbs__link">Sản phẩm</a>
            <span class="breadcrumbs__separator">/</span>
            <span class="breadcrumbs__current"><?php echo $current_term->name; ?></span>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="section">
    <div class="container">
        <!-- Filter -->
        <div class="products-filter">
            <div class="filter-buttons">
                <button class="filter-btn" data-filter="all">Tất cả</button>

                <?php
                $product_categories = get_terms(array(
                    'taxonomy' => 'product-category',
                ));

                foreach ($product_categories as $category) {
                    $category_id = $category->term_id;
                    $category_name = $category->name;
                    $is_active = ($current_term->term_id == $category_id) ? 'filter-btn--active' : '';
                ?>
                    <button class="filter-btn <?php echo $is_active; ?>" data-filter="<?= esc_attr($category_id); ?>"><?= esc_html($category_name); ?></button>
                <?php }; ?>
            </div>
            <div class="products-sort">
                <label for="sort">Sắp xếp theo:</label>
                <select id="sort" class="products-sort__select">
                    <option value="newest">Mới nhất</option>
                    <option value="price-low">Giá: Thấp đến Cao</option>
                    <option value="price-high">Giá: Cao đến Thấp</option>
                    <option value="name">Tên: A đến Z</option>
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="products">
            <!-- Sẽ được nạp bằng AJAX -->
            <div class="products-loading">
                <i class="fas fa-spinner fa-spin"></i> Đang tải sản phẩm...
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination"></div>
        
        <!-- CSS cho loading status -->
        <style>
            .products.loading {
                opacity: 0.6;
                position: relative;
            }
            .products-loading {
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.5);
                z-index: 10;
                font-size: 18px;
            }
            .products-loading i {
                margin-right: 10px;
            }
            .products-empty, .products-error {
                padding: 40px;
                text-align: center;
                width: 100%;
                font-size: 18px;
                color: #666;
            }
            .products-error {
                color: #c00;
            }
            .pagination__number, .pagination__arrow {
                cursor: pointer;
            }
        </style>
    </div>
</section>

<!-- Script để lọc và sắp xếp sản phẩm -->
<script>
jQuery(document).ready(function($) {
    var currentCategory = '<?php echo $current_term->term_id; ?>';
    var currentPage = 1;
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    var nonce = '<?php echo wp_create_nonce('product_filter_nonce'); ?>';
    
    // Hàm tải sản phẩm bằng AJAX
    function loadProducts(category, sort, page) {
        category = category || $('.filter-btn--active').data('filter') || currentCategory;
        sort = sort || $('#sort').val() || 'newest';
        page = page || currentPage;
        
        // Đánh dấu trạng thái đang tải
        $('.products').addClass('loading');
        $('.products-loading').show();
        
        // Gửi AJAX request
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_products',
                security: nonce,
                category: category,
                sort: sort,
                page: page
            },
            success: function(response) {
                if (response.success) {
                    // Cập nhật nội dung sản phẩm
                    $('.products').html(response.data.html);
                    
                    // Cập nhật phân trang
                    $('.pagination').html(response.data.pagination);
                    
                    // Cập nhật category active
                    updateActiveCategory(category);
                    
                    // Ẩn loading
                    $('.products').removeClass('loading');
                    $('.products-loading').hide();
                    
                    // Lưu trang hiện tại
                    currentPage = page;
                } else {
                    $('.products').html('<div class="products-error">Đã xảy ra lỗi khi tải sản phẩm.</div>');
                    $('.products').removeClass('loading');
                    $('.products-loading').hide();
                }
            },
            error: function() {
                $('.products').html('<div class="products-error">Đã xảy ra lỗi khi kết nối với máy chủ.</div>');
                $('.products').removeClass('loading');
                $('.products-loading').hide();
            }
        });
    }
    
    // Cập nhật category active
    function updateActiveCategory(category) {
        $('.filter-btn').removeClass('filter-btn--active');
        if (category === 'all') {
            $('.filter-btn[data-filter="all"]').addClass('filter-btn--active');
        } else {
            $('.filter-btn[data-filter="' + category + '"]').addClass('filter-btn--active');
        }
    }
    
    // Xử lý khi nhấn nút lọc
    $('.filter-btn').on('click', function() {
        var category = $(this).data('filter');
        loadProducts(category, null, 1); // Reset về trang 1 khi thay đổi category
    });
    
    // Xử lý khi thay đổi sắp xếp
    $('#sort').on('change', function() {
        var sort = $(this).val();
        loadProducts(null, sort, currentPage);
    });
    
    // Xử lý khi nhấn vào phân trang
    $(document).on('click', '.pagination__number, .pagination__arrow:not(.pagination__arrow--disabled)', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadProducts(null, null, page);
        
        // Cuộn về đầu danh sách sản phẩm
        $('html, body').animate({
            scrollTop: $('.products-filter').offset().top - 100
        }, 300);
    });
    
    // Tải sản phẩm khi trang được tải
    loadProducts(currentCategory, 'newest', 1);
});
</script>

<?php get_template_part('section', 'newsletter'); ?>

<?php get_footer(); ?>