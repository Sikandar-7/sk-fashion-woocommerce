<?php
/**
 * woocommerce.php — MASTER TEMPLATE
 * Yeh file sab WooCommerce pages handle karta hai
 */
get_header();
?>

<?php if ( is_singular('product') ) :
    // ================================================
    // SINGLE PRODUCT PAGE
    // ================================================
    global $product;
    the_post();
?>
<div class="single-product-page">
  <div class="container">

    <div class="single-breadcrumb">
      <a href="<?php echo home_url('/'); ?>">Home</a> /
      <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a> /
      <span><?php the_title(); ?></span>
    </div>

    <div class="single-product-layout">

      <!-- IMAGE -->
      <div class="single-product-gallery">
        <div class="main-product-image">
          <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('large', ['class'=>'main-img']); ?>
          <?php else: ?>
            <div class="no-img-placeholder">👗</div>
          <?php endif; ?>
          <?php if ($product->is_on_sale()): ?>
            <span class="sale-badge big-badge">SALE</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- DETAILS -->
      <div class="single-product-details">

        <?php
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)):
          foreach($terms as $t):
            if ($t->name === 'Uncategorized') continue; ?>
            <a href="<?php echo get_term_link($t); ?>" class="single-product-cat"><?php echo esc_html($t->name); ?></a>
        <?php endforeach; endif; ?>

        <h1 class="single-product-title"><?php the_title(); ?></h1>

        <div class="single-product-price"><?php echo $product->get_price_html(); ?></div>

        <?php if ($product->get_short_description()): ?>
          <div class="single-product-short-desc"><?php echo wp_kses_post($product->get_short_description()); ?></div>
        <?php endif; ?>

        <div class="single-stock-status <?php echo $product->is_in_stock() ? 'in-stock':'out-stock'; ?>">
          <?php echo $product->is_in_stock() ? '✅ In Stock' : '❌ Out of Stock'; ?>
        </div>

        <?php if ($product->is_in_stock()): ?>
        <form class="sk-add-to-cart-form" action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post">
          <div class="quantity-wrapper">
            <label>Quantity:</label>
            <div class="qty-control">
              <button type="button" class="qty-btn qty-minus">−</button>
              <input type="number" id="qty-input" name="quantity" value="1" min="1" max="99" class="qty-input">
              <button type="button" class="qty-btn qty-plus">+</button>
            </div>
          </div>
          <input type="hidden" name="add-to-cart" value="<?php echo $product->get_id(); ?>">
          <button type="submit" class="btn btn-accent btn-add-cart">🛒 Add to Cart</button>
          <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-dark btn-buy-now">⚡ Buy Now</a>
        </form>
        <?php endif; ?>

        <div class="single-product-meta">
          <?php if ($terms && !is_wp_error($terms)): ?>
          <p><strong>Category:</strong>
            <?php foreach($terms as $t): if($t->name!=='Uncategorized'): ?>
              <a href="<?php echo get_term_link($t); ?>"><?php echo esc_html($t->name); ?></a>
            <?php endif; endforeach; ?>
          </p>
          <?php endif; ?>
          <p><strong>SKU:</strong> SK-<?php echo str_pad($product->get_id(), 4, '0', STR_PAD_LEFT); ?></p>
        </div>

        <div class="single-product-share">
          <span>Share:</span>
          <a href="https://wa.me/?text=<?php echo urlencode(get_the_title().' - '.get_permalink()); ?>" target="_blank">💬 WhatsApp</a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank">📘 Facebook</a>
        </div>

      </div>
    </div>

    <?php if ($product->get_description()): ?>
    <div class="single-product-desc-section">
      <h2>Product Description</h2>
      <div class="desc-content"><?php echo wp_kses_post($product->get_description()); ?></div>
    </div>
    <?php endif; ?>

    <!-- Related Products -->
    <?php
    $related_ids = wc_get_related_products($product->get_id(), 4);
    if (!empty($related_ids)):
      $rq = new WP_Query(['post__in'=>$related_ids,'post_type'=>'product','posts_per_page'=>4]);
    ?>
    <div class="related-products-section">
      <h2>You May Also Like</h2>
      <div class="sk-products-grid related-grid">
        <?php while($rq->have_posts()): $rq->the_post(); global $product; ?>
          <div class="sk-product-card">
            <a href="<?php the_permalink(); ?>" class="sk-product-img-wrap">
              <?php if(has_post_thumbnail()): the_post_thumbnail('medium',['class'=>'sk-product-img']); else: ?>
                <div class="sk-product-img-placeholder">👗</div>
              <?php endif; ?>
              <?php if($product->is_on_sale()): ?><span class="sale-badge">SALE</span><?php endif; ?>
            </a>
            <div class="sk-product-info">
              <h3 class="sk-product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <div class="sk-product-footer">
                <div class="sk-product-price"><?php echo $product->get_price_html(); ?></div>
                <a href="<?php the_permalink(); ?>" class="sk-add-to-cart">View →</a>
              </div>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<script>
document.querySelector('.qty-minus')?.addEventListener('click',function(){
  var i=document.getElementById('qty-input'); if(parseInt(i.value)>1) i.value=parseInt(i.value)-1;
});
document.querySelector('.qty-plus')?.addEventListener('click',function(){
  var i=document.getElementById('qty-input'); if(parseInt(i.value)<99) i.value=parseInt(i.value)+1;
});
</script>

<?php elseif (is_shop() || is_product_category() || is_product_tag()) :
    // ================================================
    // SHOP / ARCHIVE PAGE
    // ================================================
?>
<div class="shop-page-wrapper">

  <div class="shop-hero-bar">
    <div class="container">
      <div class="shop-hero-inner">
        <div>
          <h1 class="shop-page-title"><?php is_shop() ? print('All Products') : single_cat_title(); ?></h1>
          <p class="shop-breadcrumb">
            <a href="<?php echo home_url('/'); ?>">Home</a> /
            <?php if(is_product_category()): ?>
              <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a> /
              <span><?php single_cat_title(); ?></span>
            <?php else: ?>
              <span>Shop</span>
            <?php endif; ?>
          </p>
        </div>
        <div class="shop-result-count"><?php woocommerce_result_count(); ?></div>
      </div>
    </div>
  </div>

  <div class="container shop-container">
    <div class="shop-layout">

      <!-- SIDEBAR -->
      <aside class="shop-sidebar">
        <div class="sidebar-widget">
          <h3 class="widget-title">Categories</h3>
          <ul class="cat-filter-list">
            <li>
              <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="<?php echo is_shop() ? 'active':''; ?>">
                All Products <span class="cat-count"><?php echo wp_count_posts('product')->publish; ?></span>
              </a>
            </li>
            <?php
            $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true]);
            foreach($cats as $cat):
              if($cat->name==='Uncategorized') continue;
            ?>
            <li>
              <a href="<?php echo get_term_link($cat); ?>" class="<?php echo is_product_category($cat->slug)?'active':''; ?>">
                <?php echo esc_html($cat->name); ?>
                <span class="cat-count"><?php echo $cat->count; ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </aside>

      <!-- PRODUCTS -->
      <main class="shop-main">
        <?php if (woocommerce_product_loop()): ?>
          <div class="sk-products-grid">
            <?php while(have_posts()): the_post(); global $product; ?>
              <div class="sk-product-card">
                <a href="<?php the_permalink(); ?>" class="sk-product-img-wrap">
                  <?php if(has_post_thumbnail()): the_post_thumbnail('medium',['class'=>'sk-product-img']); else: ?>
                    <div class="sk-product-img-placeholder">👗</div>
                  <?php endif; ?>
                  <?php if($product->is_on_sale()): ?><span class="sale-badge">SALE</span><?php endif; ?>
                  <div class="sk-product-overlay">
                    <span class="overlay-btn">View Product</span>
                  </div>
                </a>
                <div class="sk-product-info">
                  <?php
                  $t = get_the_terms(get_the_ID(),'product_cat');
                  if($t && !is_wp_error($t) && $t[0]->name!=='Uncategorized'):
                  ?><span class="sk-product-cat"><?php echo esc_html($t[0]->name); ?></span><?php endif; ?>
                  <h3 class="sk-product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <div class="sk-product-footer">
                    <div class="sk-product-price"><?php echo $product->get_price_html(); ?></div>
                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                       data-product_id="<?php echo $product->get_id(); ?>"
                       class="sk-add-to-cart ajax_add_to_cart add_to_cart_button">🛒 Add</a>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
          <div class="sk-pagination"><?php woocommerce_pagination(); ?></div>
        <?php else: ?>
          <div class="no-products-found">
            <p>😕 No products found.</p>
            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-accent">View All Products</a>
          </div>
        <?php endif; ?>
      </main>

    </div>
  </div>
</div>

<?php else :
    // ================================================
    // CART / CHECKOUT / MY ACCOUNT / OTHER WC PAGES
    // ================================================
?>
<div class="wc-generic-page">
  <div class="container">
    <?php while(have_posts()): the_post(); ?>
      <h1 class="wc-page-title"><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
