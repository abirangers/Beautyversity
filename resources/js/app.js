import "./libs/trix";
import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenuCloseButton = document.getElementById('mobile-menu-close-button');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

    if (mobileMenuButton && mobileMenuCloseButton && mobileMenuOverlay) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenuOverlay.classList.remove('hidden');
        });

        mobileMenuCloseButton.addEventListener('click', function() {
            mobileMenuOverlay.classList.add('hidden');
        });

        // Optional: Close menu when clicking outside the menu content
        mobileMenuOverlay.addEventListener('click', function(e) {
            if (e.target === mobileMenuOverlay) {
                mobileMenuOverlay.classList.add('hidden');
            }
        });
    }
});
