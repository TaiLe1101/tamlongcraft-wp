<?php

function load_assets() {
    // Đăng ký tài font Google
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap', array(), null);

    // Đăng ký và tải Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), null);

    // Đăng ký và tải file CSS chính
    wp_enqueue_style('main-css', get_theme_file_uri() . '/css/main.css', array(), '1.0.3', 'all');
    
    // Đăng ký và tải jQuery (nếu cần thiết)
    wp_enqueue_script('jquery', get_theme_file_uri() . '/js/jquery.min.js', array(), '3.6.0', true);
    
    // Đăng ký và tải file JavaScript chính
    wp_enqueue_script('main-js', get_theme_file_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Đăng ký font chữ (nếu cần thiết)
    wp_enqueue_style('playfair-font', get_theme_file_uri() . '/assets/fonts/PlayfairDisplay-Regular.woff2', array(), '1.0.0', 'all');
}

add_action('wp_enqueue_scripts', 'load_assets');
add_filter('show_admin_bar', '__return_false');
