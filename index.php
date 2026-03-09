<?php get_header(); ?>

<!-- ===========================
     HERO BANNER
     =========================== -->
<section class="hero-banner" id="hero">

    <div class="hero-left">
        <div class="hero-content">
            <div class="hero-tag">✨ New Arrival 2025</div>
            <h1 class="hero-title">
                Style That <span>Speaks</span><br>For Itself
            </h1>
            <p class="hero-subtitle">
                Premium quality clothing for men, women & kids.
                Shop the latest trends at unbeatable prices in Pakistan.
            </p>
            <div class="hero-buttons">
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-accent">
                    Shop Now →
                </a>
                <a href="#categories" class="btn btn-outline" style="color:white; border-color:rgba(255,255,255,0.4);">
                    Browse Categories
                </a>
            </div>
        </div>
    </div>

    <div class="hero-right">
        <div class="hero-bg" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:10rem;">
            👗
        </div>
    </div>

</section>

<!-- ===========================
     CATEGORIES
     =========================== -->
<section class="categories-section" id="categories">
    <div class="container">

        <div class="section-header">
            <span class="section-tag">Browse By</span>
            <h2 class="section-title">Shop by <span>Category</span></h2>
        </div>

        <div class="categories-grid">

            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?filter=men" class="category-card">
                <div class="category-bg cat-men">👔</div>
                <div class="category-label">
                    <h3>Men's Fashion</h3>
                    <p>Shirts, Kurtas & More</p>
                </div>
            </a>

            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?filter=women" class="category-card">
                <div class="category-bg cat-women">👗</div>
                <div class="category-label">
                    <h3>Women's Fashion</h3>
                    <p>Dresses, Kurtis & More</p>
                </div>
            </a>

            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?filter=kids" class="category-card">
                <div class="category-bg cat-kids">🧸</div>
                <div class="category-label">
                    <h3>Kids Wear</h3>
                    <p>Cute & Comfortable</p>
                </div>
            </a>

            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?filter=sale" class="category-card">
                <div class="category-bg cat-sale">🔥</div>
                <div class="category-label">
                    <h3>Sale — Up to 50% Off</h3>
                    <p>Limited Time Only!</p>
                </div>
            </a>

        </div>

    </div>
</section>

<!-- ===========================
     FEATURED PRODUCTS
     =========================== -->
<section class="products-section" id="products">
    <div class="container">

        <div class="section-header">
            <span class="section-tag">Hand-Picked</span>
            <h2 class="section-title">Featured <span>Products</span></h2>
        </div>

        <?php if ( class_exists('WooCommerce') ) : ?>
            <?php
            // WooCommerce featured products
            echo do_shortcode('[products limit="8" columns="4" orderby="popularity"]');
            ?>
        <?php else : ?>
            <p style="text-align:center; color:var(--text-muted);">
                WooCommerce is not active. Please activate the plugin.
            </p>
        <?php endif; ?>

        <div style="text-align:center; margin-top:48px;">
            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-dark">
                View All Products →
            </a>
        </div>

    </div>
</section>

<!-- ===========================
     FEATURES STRIP
     =========================== -->
<section class="features-strip" id="features">
    <div class="container">
        <div class="features-grid">

            <div class="feature-item">
                <div class="feature-icon">🚚</div>
                <h4>Free Delivery</h4>
                <p>On orders above Rs. 2000</p>
            </div>

            <div class="feature-item">
                <div class="feature-icon">🔄</div>
                <h4>Easy Returns</h4>
                <p>7-day hassle-free return</p>
            </div>

            <div class="feature-item">
                <div class="feature-icon">🔒</div>
                <h4>Secure Payment</h4>
                <p>100% secure checkout</p>
            </div>

            <div class="feature-item">
                <div class="feature-icon">🎧</div>
                <h4>24/7 Support</h4>
                <p>WhatsApp & Email support</p>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
