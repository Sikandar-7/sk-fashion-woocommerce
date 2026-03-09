<!-- NEWSLETTER SECTION -->
<section class="newsletter-section">
    <div class="container">
        <h2>Get Exclusive Offers 🎁</h2>
        <p>Subscribe to get notified about new arrivals, sales and promotions!</p>
        <form class="newsletter-form" onsubmit="return false;">
            <input type="email" placeholder="Enter your email address...">
            <button type="submit" class="btn btn-accent">Subscribe</button>
        </form>
    </div>
</section>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            <!-- Brand -->
            <div class="footer-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    SK <span style="color:var(--accent)">Fashion</span>
                </a>
                <p>
                    Premium clothing store based in Lahore, Pakistan.
                    Quality fashion at affordable prices. Built with ❤️ by Sikandar Abbas.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a></li>
                    <li><a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>">Cart</a></li>
                    <li><a href="<?php echo get_permalink(wc_get_page_id('checkout')); ?>">Checkout</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="footer-col">
                <h4>Categories</h4>
                <ul>
                    <li><a href="#">Men's Clothing</a></li>
                    <li><a href="#">Women's Clothing</a></li>
                    <li><a href="#">Kids Wear</a></li>
                    <li><a href="#">Sale Items</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:sikandar8sa@gmail.com">📧 Email Us</a></li>
                    <li><a href="https://wa.me/923197171279">💬 WhatsApp</a></li>
                    <li><a href="#">📍 Lahore, Pakistan</a></li>
                    <li><a href="https://github.com/Sikandar-7">🐙 GitHub</a></li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <strong>SK Fashion</strong> &mdash;
            Designed &amp; Developed by
            <strong>Sikandar Abbas</strong> | WordPress + WooCommerce</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
