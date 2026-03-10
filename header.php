<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOP BAR -->
<div class="top-bar">
    🚚 <strong>Free Shipping</strong> on orders over Rs. 2000 &nbsp;|&nbsp; 🎉 New Summer Collection is Live!
</div>

<!-- HEADER -->
<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                SK <span>Fashion</span>
            </a>

            <!-- Navigation -->
            <nav class="nav-links">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a>
                <a href="#categories">Categories</a>
                <a href="#features">About</a>
            </nav>

            <!-- Actions -->
            <div class="header-actions">
                <?php if ( class_exists('WooCommerce') ) : ?>
                    <a href="#" class="header-search-icon" aria-label="Search">
                        🔍
                    </a>
                    <a href="<?php echo esc_url(home_url('/wishlist')); ?>" class="header-wishlist">
                        ❤️ <span class="wishlist-count" style="display:none;">0</span>
                    </a>
                    <a href="<?php echo wc_get_cart_url(); ?>" class="header-cart">
                        🛒
                        <?php $count = WC()->cart->get_cart_contents_count(); ?>
                        <?php if ($count > 0) : ?>
                            <span class="cart-count"><?php echo $count; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-accent">Shop Now</a>
            </div>

        </div>
    </div>
</header>

<!-- PREMIUM FULLSCREEN SEARCH OVERLAY -->
<div class="sk-search-overlay" id="sk-search-overlay">
    <button class="search-close-btn" id="search-close-btn" aria-label="Close Search">✖</button>
    <div class="search-overlay-content">
        <h2 class="search-title">What are you looking for?</h2>
        <form role="search" method="get" class="sk-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="hidden" name="post_type" value="product" />
            <div class="search-input-wrapper">
                <input type="search" class="search-field" placeholder="Type your keyword..." value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" required />
                <button type="submit" class="search-submit-btn">🔍</button>
            </div>
            <p class="search-suggestions">Trending: <span>Men's Kurta</span>, <span>Summer Deals</span>, <span>Party Wear</span></p>
        </form>
    </div>
</div>
