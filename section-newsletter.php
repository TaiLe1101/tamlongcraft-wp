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
                <div class="newsletter__message"></div>
            </form>
        </div>
    </div>
</section>

<style>
    /* CSS cho thông báo đăng ký newsletter */
    .newsletter__message {
        margin-top: 15px;
        text-align: center;
        font-weight: 500;
    }
    .newsletter__loading {
        color: #555;
    }
    .newsletter__success {
        color: #4caf50;
    }
    .newsletter__error {
        color: #f44336;
    }
</style>

<script>
jQuery(document).ready(function($) {
    $('#newsletter-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $messageDiv = $form.find('.newsletter__message');
        var formData = $form.serialize();
        
        // Thêm action cho AJAX
        formData += '&action=subscribe_newsletter';
        
        console.log('Đang gửi dữ liệu:', formData);
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $messageDiv.html('<p class="newsletter__loading">Đang xử lý...</p>');
                $form.find('button').prop('disabled', true);
            },
            success: function(response) {
                console.log('Phản hồi từ server:', response);
                if (response.success) {
                    $messageDiv.html('<p class="newsletter__success">' + response.data.message + '</p>');
                    $form.find('input[name="subscriber_email"]').val('');
                } else {
                    $messageDiv.html('<p class="newsletter__error">' + (response.data ? response.data.message : 'Có lỗi xảy ra. Vui lòng thử lại sau.') + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi AJAX:', status, error);
                $messageDiv.html('<p class="newsletter__error">Đã có lỗi xảy ra. Vui lòng thử lại sau.</p>');
            },
            complete: function() {
                $form.find('button').prop('disabled', false);
            }
        });
    });
});
</script>