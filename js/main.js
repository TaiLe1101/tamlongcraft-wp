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

    // Product filtering on product listing page
    if ($('.products-filter').length) {
        $('.filter-btn').on('click', function() {
            const filterValue = $(this).attr('data-filter');
            
            $('.filter-btn').removeClass('filter-btn--active');
            $(this).addClass('filter-btn--active');
            
            if (filterValue === 'all') {
                $('.product-card').show();
            } else {
                $('.product-card').hide();
                $(`.product-card[data-category="${filterValue}"]`).show();
            }
        });
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

    // Handle error state for images
    $('img').on('error', function() {
        $(this).addClass('img-error');
    });
});

// Add CSS class when document is loaded
$(window).on('load', function() {
    $('body').addClass('loaded');
});