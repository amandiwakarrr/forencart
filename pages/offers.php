<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/offers.css">

<main class="offers-page">

<h1>🔥 Latest Offers</h1>

<div class="offers-grid">

<?php
$res = mysqli_query($conn, "
SELECT p.*, o.type, o.value
FROM products p
JOIN offer_products op ON p.id = op.product_id
JOIN offers o ON op.offer_id = o.id
WHERE o.status = 1
AND NOW() BETWEEN o.start_date AND o.end_date
");

while ($p = mysqli_fetch_assoc($res)) {

    $price = $p['price'];
    $finalPrice = $price;

    if ($p['type'] == 'percentage') {
        $finalPrice = $price - ($price * $p['value'] / 100);
    } else {
        $finalPrice = $price - $p['value'];
    }
?>

<div class="offer-card">

    <!-- Image -->
    <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $p['id']; ?>">
        <img src="<?php echo $base_url; ?>assets/images/products/<?php echo $p['image']; ?>">
    </a>

    <!-- Discount Badge -->
    <?php if ($p['type'] == 'percentage') { ?>
        <div class="badge">-<?php echo $p['value']; ?>%</div>
    <?php } ?>

    <!-- Product Name -->
    <h3><?php echo htmlspecialchars($p['name']); ?></h3>

    <!-- Price -->
    <div class="price">
        ₹<?php echo number_format($finalPrice,2); ?>
        <span class="old">₹<?php echo number_format($price,2); ?></span>
    </div>

    <!-- Button -->
    <div class="btn-group">

    <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $p['id']; ?>" 
       class="view-btn">
        View
    </a>

    <a href="<?php echo $base_url; ?>pages/add-to-cart.php?id=<?php echo $p['id']; ?>" 
       class="cart-btn">
        🛒 Get Offer
    </a>

</div>
</div>

<?php } ?>

</div>

</main>

<?php include_once '../includes/footer.php'; ?>