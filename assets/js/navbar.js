document.addEventListener("DOMContentLoaded", function () {

    // ================= MOBILE MENU TOGGLE =================
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    }

    // ================= DEPARTMENTS TOGGLE =================
    const deptBtn = document.querySelector('.all-departments');
    const dropdown = document.querySelector('.departments-dropdown');

    if (deptBtn && dropdown) {

        deptBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (!deptBtn.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }

    // ================= MIDDLE BAR STICKY =================
    const header = document.querySelector('.main-header');
    const middleBar = document.querySelector('.middle-bar');
    const spacer = document.querySelector('.middle-spacer');

    if (!header || !middleBar) return;

    const stickyPoint = header.offsetHeight;

    if (spacer) {
        spacer.style.height = middleBar.offsetHeight + "px";
    }

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