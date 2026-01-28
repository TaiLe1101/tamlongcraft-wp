/* Main JavaScript file for Luxury Furniture Website */

$(document).ready(function() {
    // Mobile navigation toggle
    $('.nav__toggle').on('click', function() {
        $('.nav__list').toggleClass('nav__list--active');
    });

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.nav__toggle, .nav__list').length) {
            $('.nav__list').removeClass('nav__list--active');
        }
    });

    // Product detail page - thumbnail gallery
    $('.product-detail__thumbnail').on('click', function() {
        const imgSrc = $(this).attr('src');
        $('.product-detail__main-image').attr('src', imgSrc);
        $('.product-detail__thumbnail').removeClass('product-detail__thumbnail--active');
        $(this).addClass('product-detail__thumbnail--active');
    });

    // Product tabs functionality
    $('.product-tabs__btn').on('click', function() {
        const tabId = $(this).data('tab');
        
        // Update active button
        $('.product-tabs__btn').removeClass('product-tabs__btn--active');
        $(this).addClass('product-tabs__btn--active');
        
        // Update active panel
        $('.product-tabs__panel').removeClass('product-tabs__panel--active');
        $('#' + tabId).addClass('product-tabs__panel--active');
    });

    // Smooth scrolling for anchor links
    $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
        if (
            location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && 
            location.hostname == this.hostname
        ) {
            let target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        }
    });

    // Header scroll effect
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 50) {
            $('.header').addClass('header--scrolled');
        } else {
            $('.header').removeClass('header--scrolled');
        }
    });

    // Initialize contact form validation
    if ($('#contactForm').length) {
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            let isValid = true;
            const name = $('#name').val();
            const email = $('#email').val();
            const message = $('#message').val();
            
            if (!name) {
                $('#name').addClass('form__input--error');
                isValid = false;
            } else {
                $('#name').removeClass('form__input--error');
            }
            
            if (!email || !isValidEmail(email)) {
                $('#email').addClass('form__input--error');
                isValid = false;
            } else {
                $('#email').removeClass('form__input--error');
            }
            
            if (!message) {
                $('#message').addClass('form__input--error');
                isValid = false;
            } else {
                $('#message').removeClass('form__input--error');
            }
            
            if (isValid) {
                // Here you would normally send the form data to a server
                // For demo purposes, we're just showing a success message
                $('#contactForm').hide();
                $('.contact__success').show();
            }
        });
    }

    // Helper function to validate email
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Contact Form Handling
    if ($('#contact-form').length) {
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            // Lấy dữ liệu từ form
            const $form = $(this);
            const firstName = $form.find('#first-name').val();
            const lastName = $form.find('#last-name').val();
            const email = $form.find('#email').val();
            const phone = $form.find('#phone').val();
            const message = $form.find('#message').val();
            const contactTarget = $form.find('#contact-target').val();
            const newsletter = $form.find('#newsletter').is(':checked') ? '1' : '0';
            const privacy = $form.find('#privacy').is(':checked') ? '1' : '0';
            const nonce = $form.find('input[name="contact_nonce"]').val();
            
            // Kiểm tra dữ liệu đầu vào
            if (!firstName || !lastName || !email || !message || !privacy || !contactTarget) {
                showFormMessage($form, 'Vui lòng điền đầy đủ thông tin bắt buộc.', 'error');
                return;
            }
            
            // Kiểm tra email hợp lệ
            if (!isValidEmail(email)) {
                showFormMessage($form, 'Vui lòng nhập địa chỉ email hợp lệ.', 'error');
                return;
            }
            
            // Hiển thị trạng thái đang xử lý
            const $submitBtn = $form.find('button[type="submit"]');
            const originalBtnText = $submitBtn.text();
            $submitBtn.prop('disabled', true).text('Đang gửi...');
            
            // Gửi AJAX request
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'submit_contact_form',
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    phone: phone,
                    message: message,
                    contact_target: contactTarget,
                    newsletter: newsletter,
                    privacy: privacy,
                    contact_nonce: nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Hiển thị thông báo thành công
                        showFormMessage($form, response.data.message, 'success');
                        // Reset form
                        $form[0].reset();
                    } else {
                        // Hiển thị thông báo lỗi
                        showFormMessage($form, response.data.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    showFormMessage($form, 'Đã xảy ra lỗi khi gửi tin nhắn. Vui lòng thử lại sau.', 'error');
                },
                complete: function() {
                    // Khôi phục trạng thái ban đầu của nút submit
                    $submitBtn.prop('disabled', false).text(originalBtnText);
                }
            });
        });
    }

    // Helper function to show form message
    function showFormMessage($form, message, type) {
        const $messageContainer = $form.find('.form__message');
        $messageContainer.removeClass('form__message--success form__message--error')
                         .addClass('form__message--' + type)
                         .html(message)
                         .show();
        
        // Cuộn đến thông báo nếu cần
        if (!isElementInViewport($messageContainer[0])) {
            $('html, body').animate({
                scrollTop: $messageContainer.offset().top - 100
            }, 500);
        }
        
        // Tự động ẩn thông báo sau 5 giây (chỉ khi là thông báo thành công)
        if (type === 'success') {
            setTimeout(function() {
                $messageContainer.fadeOut();
            }, 5000);
        }
    }

    // Helper function to check if element is in viewport
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // AJAX Product filtering và sorting trên trang sản phẩm
    if ($('.products-filter').length) {
        // Biến để lưu trạng thái filter và sort
        let currentCategory = 'all';
        let currentSort = 'newest';
        let currentPage = 1;
        let isLoading = false;

        // Xử lý khi click vào nút filter
        $('.filter-btn').on('click', function() {
            if (isLoading) return;
            
            const filterValue = $(this).attr('data-filter');
            $('.filter-btn').removeClass('filter-btn--active');
            $(this).addClass('filter-btn--active');
            
            currentCategory = filterValue;
            currentPage = 1;
            loadProducts();
        });

        // Xử lý khi thay đổi select sort
        $('.products-sort__select').on('change', function() {
            if (isLoading) return;
            
            currentSort = $(this).val();
            currentPage = 1;
            loadProducts();
        });

        // Xử lý phân trang khi click vào số trang
        $(document).on('click', '.pagination__number, .pagination__arrow', function(e) {
            e.preventDefault();
            
            if (isLoading || $(this).hasClass('pagination__arrow--disabled')) return;
            
            currentPage = $(this).data('page');
            loadProducts();
            
            // Cuộn lên đầu danh sách sản phẩm
            $('html, body').animate({
                scrollTop: $('.products').offset().top - 100
            }, 500);
        });

        // Hàm load sản phẩm với AJAX
        function loadProducts() {
            isLoading = true;
            $('.products').addClass('loading');
            
            // Thêm loading indicator
            if (!$('.products-loading').length) {
                $('.products').append('<div class="products-loading"><i class="fas fa-spinner fa-spin"></i> Đang tải sản phẩm...</div>');
            }
            
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'filter_products',
                    security: ajax_object.nonce,
                    category: currentCategory,
                    sort: currentSort,
                    page: currentPage
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật HTML sản phẩm
                        $('.products').html(response.data.html);
                        
                        // Cập nhật phân trang
                        $('.pagination').html(response.data.pagination);
                        
                        // Hiển thị thông báo nếu không có sản phẩm nào
                        if (response.data.found_posts === 0) {
                            $('.products').html('<div class="products-empty">Không tìm thấy sản phẩm nào.</div>');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('.products').html('<div class="products-error">Đã xảy ra lỗi khi tải sản phẩm. Vui lòng thử lại sau.</div>');
                },
                complete: function() {
                    isLoading = false;
                    $('.products').removeClass('loading');
                    $('.products-loading').remove();
                }
            });
        }
    }

    // Add tab functionality for contact page
    if ($('.tabs__btn').length) {
        $('.tabs__btn').on('click', function() {
            const tabId = $(this).data('tab');
            
            // Update active button
            $('.tabs__btn').removeClass('tabs__btn--active');
            $(this).addClass('tabs__btn--active');
            
            // Update active panel
            $('.tabs__panel').removeClass('tabs__panel--active');
            $('#' + tabId).addClass('tabs__panel--active');
        });
    }

    // FAQ functionality
    if ($('.faq').length) {
        $('.faq__question').on('click', function() {
            const faq = $(this).parent('.faq');
            faq.toggleClass('faq--active');
            
            // Toggle the icon
            const icon = $(this).find('.faq__toggle i');
            if (faq.hasClass('faq--active')) {
                icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                icon.removeClass('fa-minus').addClass('fa-plus');
            }
        });
    }

    // Articles filtering functionality
    if ($('.articles-filter').length) {
        // Biến để lưu trạng thái filter và trang
        let currentCategory = 'all';
        let currentPage = 1;
        let isLoading = false;
        
        // Xử lý khi click vào nút filter
        $('.articles-filter__btn').on('click', function() {
            if (isLoading) return;
            
            const filterValue = $(this).data('filter');
            
            // Update active button
            $('.articles-filter__btn').removeClass('articles-filter__btn--active');
            $(this).addClass('articles-filter__btn--active');
            
            currentCategory = filterValue;
            currentPage = 1;
            loadArticles();
        });

        // Xử lý phân trang khi click vào số trang
        $(document).on('click', '.pagination__number, .pagination__arrow', function(e) {
            e.preventDefault();
            
            if (isLoading || $(this).hasClass('pagination__arrow--disabled')) return;
            
            currentPage = $(this).data('page');
            loadArticles();
            
            // Cuộn lên đầu danh sách bài viết
            $('html, body').animate({
                scrollTop: $('.articles').offset().top - 100
            }, 500);
        });

        // Hàm load bài viết với AJAX
        function loadArticles() {
            isLoading = true;
            $('.articles').addClass('loading');
            
            // Thêm loading indicator
            if (!$('.articles-loading').length) {
                $('.articles').append('<div class="articles-loading"><i class="fas fa-spinner fa-spin"></i> Đang tải bài viết...</div>');
            }
            
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'filter_articles',
                    security: ajax_object.nonce,
                    category: currentCategory,
                    page: currentPage
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật HTML bài viết
                        $('.articles').html(response.data.html);
                        
                        // Cập nhật phân trang
                        $('.pagination').html(response.data.pagination);
                        
                        // Hiển thị thông báo nếu không có bài viết nào
                        if (response.data.found_posts === 0) {
                            $('.articles').html('<div class="articles-empty">Không tìm thấy bài viết nào.</div>');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('.articles').html('<div class="articles-error">Đã xảy ra lỗi khi tải bài viết. Vui lòng thử lại sau.</div>');
                },
                complete: function() {
                    isLoading = false;
                    $('.articles').removeClass('loading');
                    $('.articles-loading').remove();
                }
            });
        }
    }

    // AJAX comment form submission
    if ($('#commentform').length) {
        $('#commentform').on('submit', function(e) {
            e.preventDefault();
            
            // Lấy dữ liệu từ form
            const author = $('#author').val();
            const email = $('#email').val();
            const comment = $('#comment').val();
            const post_id = $('input[name="comment_post_ID"]').val();
            const parent = $('#comment_parent').val();
            const save_info = $('#save-info').is(':checked') ? '1' : '0';
            
            // Kiểm tra dữ liệu đầu vào
            if (!author || !email || !comment) {
                $('.comment-form__message').html('<div class="alert alert--error">Vui lòng điền đầy đủ thông tin.</div>');
                return;
            }
            
            // Kiểm tra email hợp lệ
            if (!isValidEmail(email)) {
                $('.comment-form__message').html('<div class="alert alert--error">Vui lòng nhập địa chỉ email hợp lệ.</div>');
                return;
            }
            
            // Hiển thị thông báo đang xử lý
            $('.comment-form__message').html('<div class="alert alert--info">Đang gửi bình luận...</div>');
            
            // Gửi AJAX request
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'submit_comment',
                    security: ajax_object.comment_nonce,
                    comment_author: author,
                    comment_author_email: email,
                    comment_content: comment,
                    comment_post_ID: post_id,
                    comment_parent: parent,
                    save_info: save_info
                },
                success: function(response) {
                    if (response.success) {
                        // Hiển thị thông báo thành công
                        $('.comment-form__message').html('<div class="alert alert--success">' + response.data.message + '</div>');
                        
                        // Thêm comment mới vào danh sách comments
                        if (parent == '0') {
                            // Thêm comment mới vào cuối danh sách
                            $('.comments .comment').last().after(response.data.comment_html);
                        } else {
                            // Thêm comment mới như là phản hồi
                            $('div[data-comment-id="' + parent + '"]').after(response.data.comment_html);
                        }
                        
                        // Xóa nội dung form
                        $('#comment').val('');
                        
                        // Reset comment_parent nếu đang trả lời
                        $('#comment_parent').val('0');
                        
                        // Cuộn đến comment mới
                        $('html, body').animate({
                            scrollTop: $('.comment--new').offset().top - 100
                        }, 800);
                        
                        // Xóa class new sau 5 giây
                        setTimeout(function() {
                            $('.comment--new').removeClass('comment--new');
                        }, 5000);
                    } else {
                        // Hiển thị thông báo lỗi
                        $('.comment-form__message').html('<div class="alert alert--error">' + response.data.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('.comment-form__message').html('<div class="alert alert--error">Đã xảy ra lỗi khi gửi bình luận. Vui lòng thử lại sau.</div>');
                }
            });
        });
        
        // Xử lý nút trả lời comment
        $(document).on('click', '.comment__reply', function(e) {
            e.preventDefault();
            
            // Lấy comment ID cần trả lời
            const commentId = $(this).closest('.comment').data('comment-id');
            
            // Cập nhật hidden field comment_parent
            $('#comment_parent').val(commentId);
            
            // Thêm thông báo đang trả lời
            if ($('.replying-to-message').length === 0) {
                $('.comment-form__title').after('<div class="replying-to-message">Đang trả lời bình luận. <a href="#" class="cancel-reply">Hủy trả lời</a></div>');
            }
            
            // Cuộn đến form bình luận
            $('html, body').animate({
                scrollTop: $('.comment-form').offset().top - 100
            }, 800);
            
            // Focus vào textarea
            $('#comment').focus();
        });
        
        // Xử lý hủy trả lời
        $(document).on('click', '.cancel-reply', function(e) {
            e.preventDefault();
            
            // Reset comment_parent
            $('#comment_parent').val('0');
            
            // Xóa thông báo đang trả lời
            $('.replying-to-message').remove();
        });
    }

    // Newsletter Form Handling
    $('#newsletter-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $messageContainer = $('.newsletter__message');
        var email = $form.find('input[name="subscriber_email"]').val();
        var nonce = $form.find('input[name="newsletter_nonce"]').val();
        
        // Validate email
        if (!isValidEmail(email)) {
            showMessage($messageContainer, 'Vui lòng nhập địa chỉ email hợp lệ.', 'error');
            return;
        }
        
        // Show loading state
        $form.find('button').prop('disabled', true).text('Đang xử lý...');
        
        // Send AJAX request
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'subscribe_newsletter',
                subscriber_email: email,
                newsletter_nonce: nonce
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showMessage($messageContainer, response.data.message, 'success');
                    // Reset form
                    $form[0].reset();
                } else {
                    // Show error message
                    showMessage($messageContainer, response.data.message, 'error');
                }
            },
            error: function() {
                showMessage($messageContainer, 'Có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
            },
            complete: function() {
                // Reset button state
                $form.find('button').prop('disabled', false).text('Đăng Ký');
            }
        });
    });
    
    // Helper function to validate email
    function isValidEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    
    // Helper function to show message
    function showMessage($container, message, type) {
        $container.removeClass('success error').addClass(type).html(message).show();
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            $container.fadeOut();
        }, 5000);
    }

    // Handle error state for images
    $('img').on('error', function() {
        $(this).addClass('img-error');
    });
});

// Add CSS class when document is loaded
$(window).on('load', function() {
    $('body').addClass('loaded');
});