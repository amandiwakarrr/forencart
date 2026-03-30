document.addEventListener("DOMContentLoaded", function () {

    // ================= MOBILE MENU TOGGLE =================
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    }

    // ================= MIDDLE BAR STICKY =================
    const header = document.querySelector('.main-header'); // 🔥 NEW
    const middleBar = document.querySelector('.middle-bar');
    const spacer = document.querySelector('.middle-spacer');

    if (!header || !middleBar) return;

    // 🔥 Trigger AFTER full navbar scrolls
    const stickyPoint = header.offsetHeight;

    // 🔥 Auto set spacer height
    if (spacer) {
        spacer.style.height = middleBar.offsetHeight + "px";
    }

    // Scroll event
    window.addEventListener('scroll', () => {

        if (window.scrollY > stickyPoint) {
            middleBar.classList.add('is-sticky');

            if (spacer) {
                spacer.style.display = 'block';
            }

        } else {
            middleBar.classList.remove('is-sticky');

            if (spacer) {
                spacer.style.display = 'none';
            }
        }

    });

});