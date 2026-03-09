<?php
/**
 * SK Clothing Store — Functions
 */

// =============================
// THEME SETUP
// =============================
function sk_store_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );             // WooCommerce support!
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'html5', array( 'search-form', 'gallery' ) );

    register_nav_menus( array(
        'primary-menu' => 'Primary Menu',
    ));
}
add_action( 'after_setup_theme', 'sk_store_setup' );


// =============================
// ENQUEUE STYLES & SCRIPTS
// =============================
function sk_store_enqueue() {
    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap',
        array(), null
    );

    // Main CSS
    wp_enqueue_style( 'sk-store-style', get_stylesheet_uri(), array('google-fonts'), '1.0' );

    // WooCommerce CSS (agar WooCommerce active hai)
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_style( 'sk-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), '1.0' );
    }

    // Main JS
    wp_enqueue_script( 'sk-store-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'sk_store_enqueue' );


// =============================
// CUSTOM IMAGE SIZES
// =============================
add_image_size( 'sk-product-thumb', 400, 480, true );
add_image_size( 'sk-category-thumb', 600, 400, true );


// =============================
// REMOVE WooCommerce DEFAULT CSS
// (hum khud apna CSS likh rahe hain)
// =============================
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


// =============================
// CART COUNT in HEADER
// =============================
function sk_cart_count() {
    if ( class_exists('WooCommerce') ) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}


// =============================
// CUSTOM EXCERPT LENGTH
// =============================
add_filter( 'excerpt_length', function() { return 18; } );
