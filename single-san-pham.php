<?php
get_header();
?>
<?php
// Get all value product

// Get featured image
$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');

// Get sub thumbnail
$sub_image_1 = get_field('sub_image_1');
$sub_image_2 = get_field('sub_image_2');
$sub_image_3 = get_field('sub_image_3');
$sub_image_4 = get_field('sub_image_4');

// Get title
$title = get_the_title(get_the_ID());

// Get price
$price = get_field('price');
$price = number_format($price, 0, ',', '.');

// Get Short description
$short_description = get_field('short_desc');

// Get long description
$group_desc_product = get_field('group_desc_product');

// Acceder a los campos individuales del grupo
$desc_product = $group_desc_product['desc_product'] ?? '';
$specifications = $group_desc_product['specifications'] ?? [];
$transport_return = $group_desc_product['transport_return'] ?? '';

// Acceder a los campos individuales de specifications
$product_code = isset($specifications['product_code']) ? $specifications['product_code'] : '';
$frame = isset($specifications['frame']) ? $specifications['frame'] : '';
$production_process = isset($specifications['production_process']) ? $specifications['production_process'] : '';
$origin = isset($specifications['origin']) ? $specifications['origin'] : '';
$size = isset($specifications['size']) ? $specifications['size'] : '';
$material = isset($specifications['material']) ? $specifications['material'] : '';
$colors = isset($specifications['colors']) ? $specifications['colors'] : '';
$guarantee = isset($specifications['guarantee']) ? $specifications['guarantee'] : '';
$tutorial = isset($specifications['tutorial']) ? $specifications['tutorial'] : '';
?>

<!-- Breadcrumbs -->
<div class="breadcrumbs-container">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo home_url(); ?>" class="breadcrumbs__link">Trang chủ</a>
            <span class="breadcrumbs__separator">/</span>
            <a href="<?php echo home_url('/san-pham'); ?>" class="breadcrumbs__link">Sản phẩm</a>
            <span class="breadcrumbs__separator">/</span>
            <span class="breadcrumbs__current"><?php echo $title; ?></span>
        </div>
    </div>
</div>

<!-- Product Detail -->
<section class="section">
    <div class="container">
        <div class="product-detail">
            <div class="product-detail__gallery">
                <img src="<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>" class="product-detail__main-image">
                <div class="product-detail__thumbnails">
                    <img src="<?php echo $sub_image_1; ?>" alt="<?php echo $title; ?>" class="product-detail__thumbnail product-detail__thumbnail--active">
                    <img src="<?php echo $sub_image_2; ?>" alt="<?php echo $title; ?>" class="product-detail__thumbnail">
                    <img src="<?php echo $sub_image_3; ?>" alt="<?php echo $title; ?>" class="product-detail__thumbnail">
                    <img src="<?php echo $sub_image_4; ?>" alt="<?php echo $title; ?>" class="product-detail__thumbnail">
                </div>
            </div>

            <div class="product-detail__info">
                <div class="product-detail__category">Sofa</div>
                <h1 class="product-detail__title"><?php echo $title; ?></h1>
                <div class="product-detail__price"><?php echo $price; ?> VNĐ</div>
                <!-- <div class="product-detail__rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span>(24 đánh giá)</span>
                </div> -->
                <div class="product-detail__description">
                    <?php echo $short_description; ?>
                </div>

                <div class="product-detail__meta">
                    <?php if (!empty($size)) : ?>
                        <div class="product-detail__meta-item">
                            <span class="product-detail__meta-label">Kích thước:</span>
                            <span class="product-detail__meta-value"><?php echo $size; ?></span>
                        </div>
                    <?php endif; ?>

                   

                    <?php if (!empty($material)) : ?>
                        <div class="product-detail__meta-item">
                            <span class="product-detail__meta-label">Chất liệu:</span>
                            <span class="product-detail__meta-value"><?php echo $material; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($colors)) : ?>
                        <div class="product-detail__meta-item">
                            <span class="product-detail__meta-label">Màu sắc:</span>
                            <span class="product-detail__meta-value"><?php echo $colors; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($guarantee)) : ?>
                        <div class="product-detail__meta-item">
                            <span class="product-detail__meta-label">Bảo hành:</span>
                            <span class="product-detail__meta-value"><?php echo $guarantee; ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- <div class="product-detail__options">
                    <div class="product-detail__option">
                        <h4 class="product-detail__option-title">Màu sắc</h4>
                        <div class="product-detail__color-options">
                            <div class="color-option color-option--active" style="background-color: #0f553b;" title="Xanh ngọc"></div>
                            <div class="color-option" style="background-color: #1a2b4a;" title="Xanh đậm"></div>
                            <div class="color-option" style="background-color: #36454f;" title="Than chì"></div>
                            <div class="color-option" style="background-color: #e8c4c4;" title="Hồng phấn"></div>
                        </div>
                    </div>

                    <div class="product-detail__option">
                        <h4 class="product-detail__option-title">Có sẵn tại showroom</h4>
                        <div class="product-detail__availability">
                            <span class="availability-badge availability-badge--in-stock">
                                <i class="fas fa-check-circle"></i> Hà Nội
                            </span>
                            
                            <span class="availability-badge availability-badge--in-stock">
                                <i class="fas fa-check-circle"></i> Hồ Chí Minh
                            </span>
                        </div>
                    </div>
                </div> -->


                <div class="product-detail__actions">
                    <a href="/lien-he" class="btn btn--primary btn--lg">Liên hệ đặt hàng</a>
                    <button class="btn btn--secondary btn--lg">Yêu cầu catalogue <i class="far fa-file-alt"></i></button>
                </div>
            </div>
        </div>

        <!-- Product Layout with Sidebar -->
        <div class="product-layout">
            <div class="product-layout__main">
                <!-- Product Tabs -->
                <div class="product-tabs">
                    <div class="product-tabs__header">
                        <button class="product-tabs__btn product-tabs__btn--active" data-tab="description">Mô tả</button>
                        <button class="product-tabs__btn" data-tab="specifications">Thông tin sản phẩm</button>
                        <!-- <button class="product-tabs__btn" data-tab="reviews">Đánh giá (24)</button> -->
                        <button class="product-tabs__btn" data-tab="shipping">Vận chuyển & Đổi trả</button>
                    </div>

                    <div class="product-tabs__content">
                        <div class="product-tabs__panel product-tabs__panel--active" id="description">
                            <div>
                                <?php echo $desc_product; ?>
                            </div>
                        </div>

                        <div class="product-tabs__panel" id="specifications">
                            <h3>Thông tin sản phẩm</h3>
                            <table class="specs-table">
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <td><?php echo $product_code; ?></td>
                                </tr>
                                <tr>
                                    <th>Kích cỡ</th>
                                    <td><?php echo $size; ?></td>
                                </tr>
                                <tr>
                                    <th>Chất liệu</th>
                                    <td><?php echo $material; ?></td>
                                </tr>
                                <tr>
                                    <th>Khung</th>
                                    <td><?php echo $frame; ?></td>
                                </tr>
                                <tr>
                                    <th>Xuất xứ</th>
                                    <td><?php echo $origin; ?></td>
                                </tr>
                                <tr>
                                    <th>Quy trình sản xuát</th>
                                    <td><?php echo $production_process; ?></td>
                                </tr>
                                <tr>
                                    <th>Màu sắc</th>
                                    <td><?php echo $colors; ?></td>
                                </tr>
                                <tr>
                                    <th>Hướng dẫn sử dụng</th>
                                    <td><?php echo $tutorial; ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="product-tabs__panel" id="shipping">
                            <div>
                                <?php echo $transport_return; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <div class="related-products">
                    <h2 class="section__title">Bạn cũng có thể thích</h2>
                    <div class="products">
                        <?php
                        // Obtener la categoría del producto actual
                        $product_cats = get_the_terms(get_the_ID(), 'product-category');
                        $category_ids = array();
                        
                        if ($product_cats && !is_wp_error($product_cats)) {
                            foreach ($product_cats as $cat) {
                                $category_ids[] = $cat->term_id;
                            }
                        }
                        
                        // Consultar productos relacionados (misma categoría, excepto el producto actual)
                        $args = array(
                            'post_type' => 'san-pham',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()), // Excluir el producto actual
                            'orderby' => 'rand', // Ordenar aleatoriamente
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product-category',
                                    'field' => 'term_id',
                                    'terms' => $category_ids
                                )
                            )
                        );
                        
                        $related_products = new WP_Query($args);
                        
                        // Mostrar los productos relacionados
                        if ($related_products->have_posts()) :
                            while ($related_products->have_posts()) : $related_products->the_post();
                                // Obtener datos del producto
                                $rel_product_id = get_the_ID();
                                $rel_product_title = get_the_title();
                                $rel_product_image = get_the_post_thumbnail_url($rel_product_id, 'full');
                                $rel_price = get_field('price', $rel_product_id);
                                $rel_price = number_format($rel_price, 0, ',', '.');
                                $rel_short_desc = get_field('short_desc', $rel_product_id);
                                $rel_product_cats = get_the_terms($rel_product_id, 'product-category');
                                $rel_category_name = isset($rel_product_cats[0]) ? $rel_product_cats[0]->name : '';
                        ?>
                        <div class="product-card">
                            <img src="<?php echo $rel_product_image; ?>" alt="<?php echo $rel_product_title; ?>" class="product-card__image">
                            <div class="product-card__content">
                                <div class="product-card__category"><?php echo $rel_category_name; ?></div>
                                <h3 class="product-card__title"><?php echo $rel_product_title; ?></h3>
                                <div class="product-card__price"><?php echo $rel_price; ?> VNĐ</div>
                                <p class="product-card__description"><?php echo $rel_short_desc; ?></p>
                                <a href="<?php echo get_permalink($rel_product_id); ?>" class="btn btn--dark">Xem chi tiết</a>
                            </div>
                        </div>
                        <?php
                            endwhile;
                            
                        else:
                            echo '<p>Không có sản phẩm liên quan.</p>';
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <aside class="sidebar">
                <!-- Categories -->
                <div class="sidebar__widget">
                    <h3 class="sidebar__widget-title">Danh Mục Sản Phẩm</h3>
                    <ul class="categories">
                        <?php
                        // Lấy tất cả danh mục sản phẩm
                        $product_categories = get_terms(array(
                            'taxonomy' => 'product-category',
                            'hide_empty' => true,
                            'orderby' => 'name',
                            'order' => 'ASC'
                        ));

                        // Hiển thị từng danh mục
                        if (!empty($product_categories) && !is_wp_error($product_categories)) {
                            foreach ($product_categories as $category) {
                                printf(
                                    '<li class="categories__item"><a href="%s" class="categories__link">%s <span class="categories__count">%s</span></a></li>',
                                    esc_url(get_term_link($category)),
                                    esc_html($category->name),
                                    esc_html($category->count)
                                );
                            }
                        } else {
                            echo '<li class="categories__item">Không có danh mục sản phẩm nào</li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- Featured Products -->
                <div class="sidebar__widget">
                    <h3 class="sidebar__widget-title">Sản Phẩm Nổi Bật</h3>
                    <div class="sidebar-products">
                        <?php
                        // Truy vấn các sản phẩm nổi bật
                        $featured_args = array(
                            'post_type' => 'san-pham',
                            'posts_per_page' => 3,
                            'meta_key' => 'is_featured',  // Giả sử có trường ACF is_featured
                            'meta_value' => '1',
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );
                        
                        $featured_products = new WP_Query($featured_args);
                        
                        if ($featured_products->have_posts()) :
                            while ($featured_products->have_posts()) : $featured_products->the_post();
                                $feat_product_id = get_the_ID();
                                $feat_product_title = get_the_title();
                                $feat_product_image = get_the_post_thumbnail_url($feat_product_id, 'thumbnail');
                                $feat_price = get_field('price', $feat_product_id);
                                $feat_price = number_format($feat_price, 0, ',', '.');
                        ?>
                        <div class="sidebar-product">
                            <img src="<?php echo $feat_product_image; ?>" alt="<?php echo $feat_product_title; ?>" class="sidebar-product__image">
                            <div class="sidebar-product__content">
                                <h4 class="sidebar-product__title"><a href="<?php echo get_permalink($feat_product_id); ?>"><?php echo $feat_product_title; ?></a></h4>
                                <div class="sidebar-product__price"><?php echo $feat_price; ?> VNĐ</div>
                            </div>
                        </div>
                        <?php
                            endwhile;
                        else:
                            echo '<p>Không có sản phẩm nổi bật.</p>';
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php get_footer(); ?>