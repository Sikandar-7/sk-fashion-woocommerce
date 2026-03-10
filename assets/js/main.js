// SK Store - Main JavaScript
document.addEventListener('DOMContentLoaded', function() {

    // ============================
    // 1. STICKY HEADER SHADOW
    // ============================
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 10) {
            header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.12)';
        } else {
            header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.08)';
        }
    });

    // ============================
    // 2. SMOOTH SCROLL
    // ============================
    document.querySelectorAll('a[href^="#"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ============================
    // 3. CATEGORY CARDS ANIMATION
    // ============================
    const cards = document.querySelectorAll('.category-card, .feature-item');
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry, i) {
            if (entry.isIntersecting) {
                setTimeout(function() {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, i * 100);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(function(card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });

    // ============================
    // 4. ADD TO CART Notification
    // ============================
    document.addEventListener('added_to_cart', function() {
        const notif = document.createElement('div');
        notif.textContent = '✅ Added to cart!';
        notif.style.cssText = `
            position: fixed; bottom: 28px; right: 28px;
            background: #1a1a2e; color: white;
            padding: 14px 24px; border-radius: 50px;
            font-weight: 600; font-size: 0.9rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            z-index: 9999; animation: slideUp 0.3s ease;
        `;
        document.body.appendChild(notif);
        setTimeout(function() { notif.remove(); }, 3000);
    });

    // ============================
    // 5. WISHLIST FUNCTIONALITY
    // ============================
    
    // Update Header Count
    function updateWishlistCount() {
        let wishlist = JSON.parse(localStorage.getItem('sk_wishlist')) || [];
        const countBadge = document.querySelector('.wishlist-count');
        if (countBadge) {
            countBadge.textContent = wishlist.length;
            countBadge.style.display = wishlist.length > 0 ? 'inline-block' : 'none';
        }
    }
    
    // Initialize Wishlist Buttons
    function initWishlistButtons() {
        let wishlist = JSON.parse(localStorage.getItem('sk_wishlist')) || [];
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            const pid = parseInt(btn.getAttribute('data-product-id'));
            if (wishlist.includes(pid)) {
                btn.classList.add('wishlist-active');
            }
            
            // Avoid duplicate listeners by replacing node or checking flag
            if (!btn.dataset.initialized) {
                btn.dataset.initialized = 'true';
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    wishlist = JSON.parse(localStorage.getItem('sk_wishlist')) || [];
                    const p = parseInt(this.getAttribute('data-product-id'));
                    const idx = wishlist.indexOf(p);
                    if (idx > -1) {
                        wishlist.splice(idx, 1);
                        this.classList.remove('wishlist-active');
                    } else {
                        wishlist.push(p);
                        this.classList.add('wishlist-active');
                    }
                    localStorage.setItem('sk_wishlist', JSON.stringify(wishlist));
                    updateWishlistCount();
                });
            }
        });
    }

    updateWishlistCount();
    initWishlistButtons();

    // If on Wishlist Page, load products
    const wishlistContainer = document.getElementById('sk-wishlist-container');
    if (wishlistContainer) {
        let wishlist = JSON.parse(localStorage.getItem('sk_wishlist')) || [];
        if (wishlist.length === 0) {
            wishlistContainer.innerHTML = '<div class="no-products-found"><p>😕 Your wishlist is empty.</p><a href="/" class="btn btn-accent">Browse Shop</a></div>';
        } else {
            wishlistContainer.innerHTML = '<p>Loading your favorite items...</p>';
            fetch(sk_store_ajax.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'sk_get_wishlist_products',
                    ids: wishlist.join(',')
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    wishlistContainer.innerHTML = data.data;
                    initWishlistButtons(); // Re-bind buttons inside the loaded HTML!
                } else {
                    wishlistContainer.innerHTML = '<p>Items not found.</p>';
                }
            })
            .catch(err => {
                console.error('AJAX Error:', err);
                wishlistContainer.innerHTML = '<p>Error loading items.</p>';
            });
        }
    }

    // ============================
    // 6. PREMIUM SEARCH OVERLAY
    // ============================
    const searchIcon = document.querySelector('.header-search-icon');
    const searchOverlay = document.getElementById('sk-search-overlay');
    const searchCloseBtn = document.getElementById('search-close-btn');
    const searchInput = document.querySelector('.search-field');

    if (searchIcon && searchOverlay) {
        searchIcon.addEventListener('click', function(e) {
            e.preventDefault();
            searchOverlay.classList.add('active');
            // Small delay to allow CSS opacity transition to start before focusing input
            setTimeout(() => {
                if (searchInput) searchInput.focus();
            }, 100);
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });

        const closeSearch = () => {
            searchOverlay.classList.remove('active');
            document.body.style.overflow = '';
        };

        if (searchCloseBtn) {
            searchCloseBtn.addEventListener('click', closeSearch);
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                closeSearch();
            }
        });
    }

});
