<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TamLongCraft - CÔNG TY TNHH MTV MỸ NGHỆ TAM LONG</title>
    <?php wp_head(); ?>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container header__container">
            <a href="/" class="header__logo">Tam<span class="header__logo-accent">LongCraft</span></a>
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