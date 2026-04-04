<?php require_once 'header.php'; ?>

<!-- FONT AWESOME (for icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<footer class="site-footer">

    <div class="footer-container">

        <!-- BRAND -->
        <div class="footer-box">
            <h2 class="logo">Foren<span>Cart</span></h2>
            <p>Your one-stop destination for all category products at the best prices.</p>

            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- QUICK LINKS -->
        <div class="footer-box">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="<?php echo $base_url; ?>">Home</a></li>
                <li><a href="<?php echo $base_url; ?>pages/shop.php">Shop</a></li>
                <li><a href="<?php echo $base_url; ?>pages/cart.php">Cart</a></li>
                <li><a href="<?php echo $base_url; ?>pages/contact.php">Contact</a></li>
                <li><a href="#">FAQs</a></li>
            </ul>
        </div>

        <!-- CATEGORIES -->
        <div class="footer-box">
            <h4>Categories</h4>
            <ul>
                <li><a href="<?php echo $base_url; ?>pages/shop.php?category=electronics">Electronics</a></li>
                <li><a href="<?php echo $base_url; ?>pages/shop.php?category=fashion">Fashion</a></li>
                <li><a href="<?php echo $base_url; ?>pages/shop.php?category=jewellery">Jewellery</a></li>
                <li><a href="<?php echo $base_url; ?>pages/shop.php?category=beauty">Beauty</a></li>
                <li><a href="<?php echo $base_url; ?>pages/shop.php?category=toys">Toys</a></li>
                <li><a href="<?php echo $base_url; ?>pages/shop.php?category=sports">Sports</a></li>
            </ul>
        </div>

        <!-- NEWSLETTER -->
        <div class="footer-box">
            <h4>Subscribe</h4>
            <p>Get updates on latest offers & products.</p>
            <form class="newsletter">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

        <!-- CONTACT -->
        <div class="footer-box">
            <h4>Contact</h4>
            <p>Email: contact@forencart.com</p>
            <p>Phone: +91-8630750297</p>
            <p>Location: Firozabad, India</p>
        </div>

    </div>

    <!-- PAYMENT METHODS -->
    <div class="payment-methods">
        <img src="https://img.icons8.com/color/48/visa.png"/>
        <img src="https://img.icons8.com/color/48/mastercard.png"/>
        <img src="https://img.icons8.com/color/48/paypal.png"/>
        <img src="https://img.icons8.com/color/48/google-pay.png"/>
    </div>

    <!-- BOTTOM -->
    <div class="footer-bottom">
        © <?php echo date("Y"); ?> ForenCart. All rights reserved.
    </div>

</footer>