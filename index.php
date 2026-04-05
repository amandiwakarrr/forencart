<?php
// Load header (config + db + session + <head>)
include_once 'includes/header.php';
// Load navigation bar
include_once 'includes/navbar.php';
?>
<!-- PAGE-SPECIFIC CSS -->
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/hero.css">
<main>
    <?php
        include 'includes/hero.php';
        include 'includes/categories-section.php';
        include 'includes/featured-products.php';
        include 'includes/mixed-products.php';
        include 'includes/why-us.php';
        include 'includes/faq.php';
    ?>
</main>
<!-- PAGE-SPECIFIC JS -->
<script src="<?php echo $base_url; ?>assets/js/hero.js"></script>
<?php
// Load footer
include_once 'includes/footer.php';
?>
