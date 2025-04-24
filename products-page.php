<?php
/* Template Name: Trang Sản Phẩm */
get_header();
?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('images/products-header.jpg');">
    <div class="container">
        <h1 class="page-header__title">Bộ Sưu Tập Của Chúng Tôi</h1>
        <div class="breadcrumbs">
            <a href="<?= esc_url(home_url()); ?>" class="breadcrumbs__link">Trang chủ</a>
            <span class="breadcrumbs__separator">/</span>
            <span class="breadcrumbs__current">Sản phẩm</span>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="section">
    <div class="container">
        <!-- Filter -->
        <div class="products-filter">
            <div class="filter-buttons">
                <button class="filter-btn filter-btn--active" data-filter="all">Tất cả</button>

                <?php
                $product_categories = get_terms(array(
                    'taxonomy' => 'product-category',
                ));

                foreach ($product_categories as $category) {
                    $category_link = get_term_link($category);
                    $category_id = $category->term_id;
                    $category_name = $category->name;
                    $category_image = get_field('image', 'product-category_' . $category->term_id); // Lấy ảnh từ custom field

                ?>
                    <button class="filter-btn" data-filter="<?= esc_attr($category_id); ?>"><?= esc_html($category_name); ?></button>
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
        <div class="products"></div>

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

<!-- Script để khởi động load sản phẩm khi trang tải xong -->
<script>
jQuery(document).ready(function($) {
    // Kích hoạt load sản phẩm khi trang tải xong
    if ($('.products-filter').length) {
        // Kiểm tra nếu hàm loadProducts đã được định nghĩa
        if (typeof loadProducts === 'function') {
            // Gọi trực tiếp
            loadProducts();
        } else {
            // Nếu hàm chưa được định nghĩa, chờ một chút
            setTimeout(function() {
                // Truy cập hàm qua sự kiện được kích hoạt
                $('.filter-btn.filter-btn--active').trigger('click');
            }, 100);
        }
    }
});
</script>

<?php
get_footer();
?>