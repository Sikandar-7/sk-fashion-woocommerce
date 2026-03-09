<?php
/**
 * single-product.php
 * Har individual product ki apni page — yahan add to cart kaam karta hai
 */
get_header();
the_post();
global $product;
?>

<div class="single-product-page">
    <div class="container">

        <!-- Breadcrumb -->
        <div class="single-breadcrumb">
            <a href="<?php echo home_url('/'); ?>">Home</a> /
            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a> /
            <span><?php the_title(); ?></span>
        </div>

        <!-- Product Layout -->
        <div class="single-product-layout">

            <!-- LEFT: Images -->
            <div class="single-product-gallery">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="main-product-image">
                        <?php the_post_thumbnail('large', ['class' => 'main-img']); ?>
                        <?php if ( $product->is_on_sale() ) : ?>
                            <span class="sale-badge big-badge">SALE</span>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="main-product-image no-img-placeholder">👗</div>
                <?php endif; ?>
            </div>

            <!-- RIGHT: Details -->
            <div class="single-product-details">

                <!-- Category -->
                <?php
                $terms = get_the_terms(get_the_ID(), 'product_cat');
                if ($terms && !is_wp_error($terms)) :
                    foreach($terms as $term) :
                        if ($term->name === 'Uncategorized') continue;
                ?>
                    <a href="<?php echo get_term_link($term); ?>" class="single-product-cat">
                        <?php echo esc_html($term->name); ?>
                    </a>
                <?php endforeach; endif; ?>

                <!-- Title -->
                <h1 class="single-product-title"><?php the_title(); ?></h1>

                <!-- Price -->
                <div class="single-product-price">
                    <?php echo $product->get_price_html(); ?>
                </div>

                <!-- Short Description -->
                <?php if ( $product->get_short_description() ) : ?>
                    <div class="single-product-short-desc">
                        <?php echo wp_kses_post($product->get_short_description()); ?>
                    </div>
                <?php endif; ?>

                <!-- Stock Status -->
                <div class="single-stock-status <?php echo $product->is_in_stock() ? 'in-stock' : 'out-stock'; ?>">
                    <?php echo $product->is_in_stock() ? '✅ In Stock' : '❌ Out of Stock'; ?>
                </div>

                <!-- Quantity + Add to Cart Form -->
                <?php if ( $product->is_in_stock() ) : ?>
                    <form class="sk-add-to-cart-form" action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" method="post">
                        <div class="quantity-wrapper">
                            <label>Quantity:</label>
                            <div class="qty-control">
                                <button type="button" class="qty-btn qty-minus">−</button>
                                <input type="number" name="quantity" value="1" min="1" max="10" class="qty-input" id="qty-input">
                                <button type="button" class="qty-btn qty-plus">+</button>
                            </div>
                        </div>
                        <input type="hidden" name="add-to-cart" value="<?php echo $product->get_id(); ?>">
                        <button type="submit" class="btn btn-accent btn-add-cart">
                            🛒 Add to Cart
                        </button>
                        <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-dark btn-buy-now">
                            ⚡ Buy Now
                        </a>
                    </form>
                <?php endif; ?>

                <!-- Product Meta -->
                <div class="single-product-meta">
                    <p><strong>SKU:</strong> <?php echo $product->get_sku() ?: 'SK-' . str_pad($product->get_id(), 4, '0', STR_PAD_LEFT); ?></p>
                    <p><strong>Type:</strong> <?php echo ucfirst($product->get_type()); ?></p>
                    <?php if ($terms && !is_wp_error($terms)) : ?>
                    <p><strong>Category:</strong>
                        <?php foreach($terms as $t) : if($t->name !== 'Uncategorized') : ?>
                            <a href="<?php echo get_term_link($t); ?>"><?php echo esc_html($t->name); ?></a>
                        <?php endif; endforeach; ?>
                    </p>
                    <?php endif; ?>
                </div>

                <!-- Share -->
                <div class="single-product-share">
                    <span>Share:</span>
                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" target="_blank">💬 WhatsApp</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank">📘 Facebook</a>
                </div>

            </div>
        </div>

        <!-- Full Description -->
        <?php if ( $product->get_description() ) : ?>
        <div class="single-product-desc-section">
            <h2>Product Description</h2>
            <div class="desc-content">
                <?php echo wp_kses_post($product->get_description()); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Related Products -->
        <div class="related-products-section">
            <h2>You May Also Like</h2>
            <?php
            $related_ids = wc_get_related_products($product->get_id(), 4);
            if (!empty($related_ids)) :
                $related_query = new WP_Query(['post__in' => $related_ids, 'post_type' => 'product', 'posts_per_page' => 4]);
            ?>
            <div class="sk-products-grid related-grid">
                <?php while ($related_query->have_posts()) : $related_query->the_post(); global $product; ?>
                    <div class="sk-product-card">
                        <a href="<?php the_permalink(); ?>" class="sk-product-img-wrap">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'sk-product-img']); ?>
                            <?php else : ?>
                                <div class="sk-product-img-placeholder">👗</div>
                            <?php endif; ?>
                            <?php if ($product->is_on_sale()) : ?><span class="sale-badge">SALE</span><?php endif; ?>
                        </a>
                        <div class="sk-product-info">
                            <h3 class="sk-product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="sk-product-footer">
                                <div class="sk-product-price"><?php echo $product->get_price_html(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="sk-add-to-cart">View</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
// Quantity buttons
document.querySelector('.qty-minus')?.addEventListener('click', function() {
    var input = document.getElementById('qty-input');
    if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
});
document.querySelector('.qty-plus')?.addEventListener('click', function() {
    var input = document.getElementById('qty-input');
    if (parseInt(input.value) < 10) input.value = parseInt(input.value) + 1;
});

// Buy Now - add to cart then go to checkout
document.querySelector('.btn-buy-now')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.sk-add-to-cart-form').submit();
    setTimeout(function() {
        window.location.href = '<?php echo wc_get_checkout_url(); ?>';
    }, 800);
});
</script>

<?php get_footer(); ?>
