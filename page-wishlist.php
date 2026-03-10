<?php
/**
 * Template Name: Wishlist Page
 * Description: Displays the user's wishlist
 */
get_header(); ?>

<div class="wc-page-wrapper page-wishlist">
    <div class="container">
        <div class="wc-page-inner" style="min-height: 400px;">
            <div class="wc-page-header">
                <h1 class="wc-page-title">My ❤️ Wishlist</h1>
                <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">
                    Your saved items ready to be added to the cart!
                </p>
            </div>
            
            <div id="sk-wishlist-container" style="min-height: 200px;">
                <p style="text-align: center; padding: 40px;"><span class="spinner"></span> Loading your favorite items...</p>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
