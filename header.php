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
