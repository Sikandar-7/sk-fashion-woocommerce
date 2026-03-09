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

});
