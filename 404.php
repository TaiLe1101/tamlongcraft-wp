<?php
get_header();
?>

<section class="error-page">
    <div class="container">
        <div class="error-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Không tìm thấy trang</h2>
        <p class="error-description">Rất tiếc, trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển. Vui lòng kiểm tra lại đường dẫn hoặc quay lại trang chủ.</p>
        <div class="section__action">
            <a href="<?php echo home_url('/'); ?>" class="btn btn--primary">Quay lại trang chủ</a>
            <a href="<?php echo home_url('/san-pham/'); ?>" class="btn btn--dark-custom">Xem sản phẩm của chúng tôi</a>
        </div>
    </div>
</section>

<?php
get_footer();
?>