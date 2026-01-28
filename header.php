<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tam Long Craft Manifactory - In Export</title>
    <?php wp_head(); ?>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container header__container">
            <div style="display:flex; align-items: center; gap: 8px;">
                <a href="/" style="display: block; width: 52px; height: 52px; overflow: hidden">
                    <img src="https://tamlongcraft.com/wp-content/uploads/2026/01/cropped-a-scaled-1.jpg" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                </a>
                <a href="/" class="header__logo" style="line-height: 28px;">Tam LongCraft<p class="header__logo-accent" style="line-height: 28px;"> Manifactory - In Export</p></a>
            </div>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class' => 'nav__list',
                'container' => 'nav',
                'container_class' => 'nav', // Class cho thẻ container (nav)
                'items_wrap' => '<ul class="nav__list">%3$s</ul>',
                'add_li_class' => 'nav__item' // Custom parameter (sẽ cần thêm filter)
            ]);
            ?>
        </div>

    </header>