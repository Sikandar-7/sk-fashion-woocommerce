<?php
/**
 * SK Clothing Store — Functions
 */

// =============================
// THEME SETUP
// =============================
function sk_store_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce'); // WooCommerce support!
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('html5', array('search-form', 'gallery'));

    register_nav_menus(array(
        'primary-menu' => 'Primary Menu',
    ));
}
add_action('after_setup_theme', 'sk_store_setup');


// =============================
// ENQUEUE STYLES & SCRIPTS
// =============================
function sk_store_enqueue()
{
    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap',
        array(), null
    );

    // Main CSS
    wp_enqueue_style('sk-store-style', get_stylesheet_uri(), array('google-fonts'), '1.0');

    // Main JS
    wp_enqueue_script('sk-store-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
    wp_localize_script('sk-store-js', 'sk_store_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'sk_store_enqueue');


// =============================
// CUSTOM IMAGE SIZES
// =============================
add_image_size('sk-product-thumb', 400, 480, true);
add_image_size('sk-category-thumb', 600, 400, true);


// =============================
// WOOCOMMERCE STYLES
// We will use default styles and override them in style.css
// =============================
// =============================
add_action('init', function () {
    if (!get_option('sk_rewrites_flushed_v2')) {
        flush_rewrite_rules();
        update_option('sk_rewrites_flushed_v2', 1);
    }
});


// =============================
// CART COUNT in HEADER
// =============================
function sk_cart_count()
{
    if (class_exists('WooCommerce')) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}


// =============================
// CUSTOM EXCERPT LENGTH
// =============================
add_filter('excerpt_length', function () {
    return 18;

});

// =============================
// REVERT CART & CHECKOUT TO CLASSIC SHORTCODES
// Fixes 'Empty Cart' issue caused by Gutenberg Cart Blocks crashing
// =============================
add_action('init', 'sk_revert_cart_checkout_to_shortcodes');
function sk_revert_cart_checkout_to_shortcodes()
{
    if (!get_option('sk_cart_shortcode_reverted_v1') && function_exists('wc_get_page_id')) {
        $cart_page_id = wc_get_page_id('cart');
        $checkout_page_id = wc_get_page_id('checkout');

        if ($cart_page_id) {
            wp_update_post(array(
                'ID' => $cart_page_id,
                'post_content' => '<!-- wp:shortcode -->[woocommerce_cart]<!-- /wp:shortcode -->'
            ));
        }
        if ($checkout_page_id) {
            wp_update_post(array(
                'ID' => $checkout_page_id,
                'post_content' => '<!-- wp:shortcode -->[woocommerce_checkout]<!-- /wp:shortcode -->'
            ));
        }

        update_option('sk_cart_shortcode_reverted_v1', 1);
    }
}

// =============================
// FORCE WOOCOMMERCE CART COOKIE
// Fixes 'Cart empty' session sync token drop on local dev
// =============================
add_action('woocommerce_add_to_cart', 'sk_force_cart_cookie_on_add', 10, 6);
function sk_force_cart_cookie_on_add($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data)
{
    if (function_exists('WC') && isset(WC()->session) && !WC()->session->has_session()) {
        WC()->session->set_customer_session_cookie(true);
    }
    do_action('woocommerce_set_cart_cookies', true);
}

// =============================
// WISHLIST: BUTON INJECTION
// =============================
add_action('woocommerce_before_shop_loop_item_title', 'sk_add_wishlist_btn', 15);
function sk_add_wishlist_btn() {
    global $product;
    if ( ! $product ) return;
    $pid = $product->get_id();
    echo '<button class="wishlist-btn" aria-label="Add to Wishlist" data-product-id="' . esc_attr($pid) . '">
            <svg viewBox="0 0 24 24">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
          </button>';
}

// =============================
// WISHLIST: AUTO-CREATE PAGE
// =============================
add_action('init', 'sk_create_wishlist_page');
function sk_create_wishlist_page() {
    if ( ! get_option('sk_wishlist_page_created_v2') ) {
        $page = get_page_by_path('wishlist');
        if ( ! $page ) {
            $page_id = wp_insert_post([
                'post_title' => 'Wishlist',
                'post_name' => 'wishlist',
                'post_status' => 'publish',
                'post_type' => 'page'
            ]);
            update_post_meta($page_id, '_wp_page_template', 'page-wishlist.php');
        }
        update_option('sk_wishlist_page_created_v2', 1);
    }
}

// Ensure the Wishlist page *always* uses our custom template
add_filter('template_include', function($template) {
    if ( is_page('wishlist') ) {
        $new_template = locate_template( array( 'page-wishlist.php' ) );
        if ( !empty( $new_template ) ) {
            return $new_template;
        }
    }
    return $template;
}, 99);

// =============================
// WISHLIST: FETCH AJAX
// =============================
add_action('wp_ajax_sk_get_wishlist_products', 'sk_get_wishlist_products_ajax');
add_action('wp_ajax_nopriv_sk_get_wishlist_products', 'sk_get_wishlist_products_ajax');
function sk_get_wishlist_products_ajax() {
    $ids = isset($_POST['ids']) ? sanitize_text_field($_POST['ids']) : '';
    if ( ! $ids ) {
        wp_send_json_success('');
    }
    $product_ids = array_map('intval', explode(',', $ids));
    
    ob_start();
    $args = [
        'post_type' => 'product',
        'post__in' => $product_ids,
        'posts_per_page' => -1,
        'orderby' => 'post__in'
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        echo '<div class="woocommerce"><ul class="products">';
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        echo '</ul></div>';
    } else {
        echo '<p>Products not found.</p>';
    }
    wp_reset_postdata();
    $html = ob_get_clean();
    wp_send_json_success($html);
}
