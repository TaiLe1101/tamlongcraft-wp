# TamLongCraft WordPress Theme - AI Development Guide

## Project Overview

This is a **Vietnamese handcrafted furniture e-commerce WordPress theme** ("Tâm Long" means "wholehearted" in Vietnamese). Built from scratch without page builders, featuring custom post types for products, AJAX-powered filtering, and Vietnamese-first UX.

**Key Technologies:** WordPress 5.0+, PHP 7.0+, jQuery, Advanced Custom Fields (ACF), custom taxonomies, custom database tables

## Architecture Patterns

### Custom Post Type: Products (`san-pham`)
- **Post type slug:** `san-pham` (Vietnamese for "product")
- **Custom taxonomy:** `product-category`
- **Template files:** 
  - [single-san-pham.php](single-san-pham.php) - Single product view
  - [taxonomy-product-category.php](taxonomy-product-category.php) - Category archive
  - [products-page.php](products-page.php) - Main product listing (template name: "Trang Sản Phẩm")

### ACF Field Structure
Product fields are organized in **grouped repeaters**:
```php
// Example from single-san-pham.php
$group_desc_product = get_field('group_desc_product');
$specifications = $group_desc_product['specifications'] ?? [];
$product_code = $specifications['product_code'] ?? '';
```

Footer fields (contact info, social links) use `sync_acf_fields_on_update()` to auto-sync across all pages when updated on any single page.

### AJAX Architecture

**Pattern:** All AJAX handlers follow strict nonce verification:
```php
wp_verify_nonce($_POST['nonce_field'], 'nonce_action_name')
```

**Registration Pattern (in functions.php):**
```php
function register_ajax_actions() {
    add_action('wp_ajax_action_name', 'handler_function');
    add_action('wp_ajax_nopriv_action_name', 'handler_function'); // For non-logged users
}
add_action('init', 'register_ajax_actions');
```

**Key AJAX Endpoints:**
- `filter_products` / `sort_products` - Product filtering/sorting (line ~733)
- `filter_articles` - Blog post filtering
- `subscribe_newsletter` - Newsletter subscriptions (uses custom table)
- `submit_contact_form` - Contact form submissions (uses custom table)
- `submit_comment` - Custom comment handling

**JavaScript Pattern:** Nonces passed via `wp_localize_script()`:
```php
wp_localize_script('main-js', 'ajax_object', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('product_filter_nonce')
));
```

### Custom Database Tables

**Auto-created on theme activation** (see `after_switch_theme` hooks):

1. **`wp_newsletter_subscribers`:**
   ```sql
   email (unique), date_subscribed, status ('active'/'inactive')
   ```

2. **`wp_contact_submissions`:**
   ```sql
   first_name, last_name, email, phone, message, newsletter (tinyint), 
   date_submitted, status ('read'/'unread'), ip_address, user_agent
   ```

**Creation Pattern:**
```php
function check_and_create_table() {
    global $wpdb;
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
```

### WordPress Hooks & Functions

**Menu System:**
- **Locations:** `primary` (header), `footer`
- **Custom classes added via filters:** 
  - `add_menu_li_class()` adds `nav__item` to `<li>`
  - `add_menu_link_class()` adds `nav__link` + `nav__link--active` to `<a>`
  - Footer menu uses separate filter functions

**Asset Loading:**
```php
function load_assets() {
    // Google Fonts: Montserrat + Playfair Display
    // Font Awesome 6.4.0
    // Main CSS: /css/main.css (cache-busted with time())
    // jQuery + /js/main.js
    wp_add_inline_script('main-js', 'var $ = jQuery;', 'before');
}
```

## Development Workflows

### Local Development (Laragon)
**Environment:** Windows + Laragon stack (Apache/MySQL)
**Theme path:** `c:\laragon\www\tamlongraft-local\wp-content\themes\tamlongcraft-wp`

**No build process** - direct CSS/JS editing in [css/main.css](css/main.css) and [js/main.js](js/main.js)

### Testing AJAX Handlers
1. Check `ajax_object` in browser console (contains `ajax_url` + nonces)
2. Test nonce verification first - intentionally fail to verify error handling
3. Use `error_log()` for debugging (e.g., `error_log('Email đã tồn tại: ' . $email);`)
4. Response pattern: `wp_send_json_success(['message' => '...'])` or `wp_send_json_error(['message' => '...'])`

### Adding New Products
1. Products use custom taxonomy `product-category` (NOT default WooCommerce)
2. Category images stored as ACF field: `get_field('image', 'product-category_' . $term_id)`
3. Product prices formatted Vietnamese-style: `number_format($price, 0, ',', '.')`

## Code Conventions

### File Naming
- **Template files:** `{page-type}-page.php` (e.g., `about-us-page.php`, `contact-us-page.php`)
- **Custom post type single:** `single-{post-type}.php` → `single-san-pham.php`
- **Taxonomy archive:** `taxonomy-{taxonomy-slug}.php` → `taxonomy-product-category.php`
- **Partials/sections:** `section-{name}.php` → `section-newsletter.php`

### Vietnamese Language
- **Comments & messages** are in Vietnamese (e.g., `'Đăng ký thành công!'`)
- **Function names** remain in English
- **URL slugs** use Vietnamese: `/san-pham` (products), `/ve-chung-toi` (about us), `/lien-he` (contact)

### HTML/CSS Patterns
**BEM-like methodology:**
```html
<div class="product-card">
    <img class="product-card__image">
    <h3 class="product-card__title">
    <a class="btn btn--primary">
</div>
```

**Common components:**
- `.btn` (`.btn--primary`, `.btn--secondary`, `.btn--dark`)
- `.section` (`.section--alt` for alternate backgrounds)
- `.breadcrumbs` (`.breadcrumbs__link`, `.breadcrumbs__current`)

### Sanitization Standards
- Text fields: `sanitize_text_field()`
- Emails: `sanitize_email()` + `is_email()` validation
- Textareas: `sanitize_textarea_field()`
- URLs: `esc_url()`
- Output: `esc_html()`, `esc_attr()`

## Admin Features

**Custom Admin Pages** (see [functions.php](functions.php) line ~425):
- **Newsletter Management:** Dashicons menu "Newsletter" → view/delete subscribers
- **Contact Submissions:** Dashicons menu "Tin Nhắn Liên Hệ" → mark read/unread, reply, delete

**Bulk actions:** Use `$wpdb->update()` / `$wpdb->delete()` with `intval()` for IDs

## Common Pitfalls

1. **ACF Field Syntax:** Always use null coalescing for grouped fields:
   ```php
   $field = $group['field_name'] ?? '';
   ```

2. **AJAX Die Required:** Always end AJAX handlers with `die();` after `wp_send_json_*()` (even though it's redundant)

3. **Menu Class Filters:** Custom menu classes require checking `theme_location` to avoid conflicts:
   ```php
   if ($args->theme_location === 'footer') { /* apply footer classes */ }
   ```

4. **Custom Tables:** Check existence before every operation or call `check_and_create_table()` in handler

5. **Product Category Terms:** Get via `get_the_terms($post_id, 'product-category')` NOT `get_categories()`

## Quick Reference

**Get product categories:**
```php
$categories = get_terms(array('taxonomy' => 'product-category'));
```

**Loop products with relationship:**
```php
$products = get_field('highlight_products'); // ACF relationship field
foreach ($products as $product) {
    $price = get_field('price', $product->ID);
    $cats = get_the_terms($product->ID, 'product-category');
}
```

**Add admin menu page:**
```php
add_menu_page('Page Title', 'Menu Title', 'manage_options', 'menu-slug', 'callback', 'dashicons-icon', 30);
```
