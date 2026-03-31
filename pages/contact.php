<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/contact.css">

<main class="page-container">

    <h1 class="page-title">Contact Us</h1>
    <p class="page-subtitle">
        We’d love to hear from you. Get in touch with ForenCart.
    </p>

    <div class="contact-wrapper">

        <!-- Contact Info -->
        <div class="contact-info">
            <h3>ForenCart Support</h3>
            <p>Email: support@forencart.com</p>
            <p>Phone: +91-90000-00000</p>
            <p>Location: India</p>
        </div>

        <!-- Contact Form -->
        <form id="contactForm" class="contact-form">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit" id="submitBtn">
                    Send Message
                </button>
                <input type="text" name="website" style="display:none">
        </form>

        <!-- Toast -->
        <div id="toast"></div>

    </div>
<script src="<?php echo $base_url; ?>assets/js/contact.js"></script>
</main>

<?php include_once '../includes/footer.php'; ?>
