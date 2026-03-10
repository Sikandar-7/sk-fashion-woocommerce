<?php
/**
 * archive-product.php
 * Yeh file WooCommerce Shop page ke liye hai
 * Sab products yahan dikhengi — categories filter bhi yahan kaam karta hai
 */
get_header(); ?>

<div class="shop-page-wrapper">

    <!-- SHOP HERO BAR -->
    <div class="shop-hero-bar">
        <div class="container">
            <div class="shop-hero-inner">
                <div>
                    <h1 class="shop-page-title">
                        <?php
                        if ( is_product_category() ) {
                            single_cat_title(); // Category name
                        } else {
                            echo 'All Products';
                        }
                        ?>
                    </h1>
                    <p class="shop-breadcrumb">
                        <a href="<?php echo home_url('/'); ?>">Home</a> /
                        <?php if ( is_product_category() ) : ?>
                            <a href="<?php echo get_permalink( wc_get_page_id('shop') ); ?>">Shop</a> /
                            <span><?php single_cat_title(); ?></span>
                        <?php else : ?>
                            <span>Shop</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="shop-result-count">
                    <?php woocommerce_result_count(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container shop-container">
        <div class="shop-layout">

            <!-- ===== SIDEBAR — CATEGORIES ===== -->
            <aside class="shop-sidebar">

                <div class="sidebar-widget">
                    <h3 class="widget-title">Categories</h3>
                    <ul class="cat-filter-list">
                        <li>
                            <a href="<?php echo get_permalink( wc_get_page_id('shop') ); ?>"
                               class="<?php echo !is_product_category() ? 'active' : ''; ?>">
                                All Products
                                <span class="cat-count"><?php echo wp_count_posts('product')->publish; ?></span>
                            </a>
                        </li>
                        <?php
                        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
                        foreach ($cats as $cat) :
                            if ($cat->name === 'Uncategorized') continue;
                        ?>
                            <li>
                                <a href="<?php echo get_term_link($cat); ?>"
                                   class="<?php echo (is_product_category($cat->slug)) ? 'active' : ''; ?>">
                                    <?php echo esc_html($cat->name); ?>
                                    <span class="cat-count"><?php echo $cat->count; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">Filter by Price</h3>
                    <?php the_widget('WC_Widget_Price_Filter'); ?>
                </div>

            </aside>

            <!-- ===== MAIN PRODUCTS GRID ===== -->
            <main class="shop-main">

                <?php if ( woocommerce_product_loop() ) : ?>

                    <div class="sk-products-grid woocommerce">
                        <?php woocommerce_product_loop_start(); ?>
                        
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                        ?>
                        
                        <?php woocommerce_product_loop_end(); ?>
                    </div>

                    <!-- Pagination -->
                    <div class="sk-pagination">
                        <?php woocommerce_pagination(); ?>
                    </div>

                <?php else : ?>
                    <div class="no-products-found">
                        <p>😕 No products found in this category.</p>
                        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-accent">View All Products</a>
                    </div>
                <?php endif; ?>

            </main>

        </div>
    </div>

</div>

<?php get_footer(); ?>
