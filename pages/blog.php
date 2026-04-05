<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/blog.css">

<main class="page-container">

    <h1 class="page-title">Our Blog</h1>
    <p class="page-subtitle">
        Tips, updates, and stories from ForenCart
    </p>

    <div class="blog-list">

        <!-- Blog Card -->
        <div class="blog-card">
            <h3>Welcome to ForenCart</h3>
            <p>
                We are excited to launch ForenCart — your one-stop shop for
                electronics, fashion, home essentials, and more.
            </p>
            <span class="blog-date">Jan 2026</span>
        </div>

        <div class="blog-card">
            <h3>How to Choose the Best Products Online</h3>
            <p>
                Learn how to compare prices, check reviews, and make smart
                buying decisions online.
            </p>
            <span class="blog-date">Jan 2026</span>
        </div>

        <div class="blog-card">
            <h3>Upcoming Offers & Deals</h3>
            <p>
                Stay tuned for exciting offers, discounts, and exclusive
                deals coming soon.
            </p>
            <span class="blog-date">Jan 2026</span>
        </div>

    </div>

</main>
<?php include '../includes/faq.php'; ?>
<?php include_once '../includes/footer.php'; ?>
