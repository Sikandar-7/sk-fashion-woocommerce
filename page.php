<?php
/**
 * page.php — Regular WordPress Pages Template
 * Yeh Cart, Checkout, My Account aur baki pages handle karta hai
 */
get_header(); ?>

<div class="wc-page-wrapper">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>

            <?php if ( class_exists('WooCommerce') && ( is_cart() || is_checkout() || is_account_page() ) ) : ?>
                <!-- WooCommerce Page — shortcode render karo -->
                <div class="wc-page-inner">
                    <h1 class="wc-page-title"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>

            <?php else : ?>
                <!-- Regular WordPress Page -->
                <div class="regular-page">
                    <h1><?php the_title(); ?></h1>
                    <div class="page-content"><?php the_content(); ?></div>
                </div>

            <?php endif; ?>

        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
