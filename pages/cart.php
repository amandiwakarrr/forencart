<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';

$cart = $_SESSION['cart'] ?? [];
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/cart.css">

<main class="cart-page">

<h1>Your Cart</h1>

<?php if (empty($cart)) { ?>
    <p>Your cart is empty.</p>
<?php } else { ?>

<div class="cart-container">

    <!-- LEFT SIDE: CART ITEMS -->
    <div class="cart-items">

    <?php
    $grandTotal = 0;

    foreach ($cart as $pid => $qty) {

        $res = mysqli_query($conn, "
        SELECT p.name, p.price, p.image, o.type, o.value
        FROM products p
        LEFT JOIN offer_products op ON p.id = op.product_id
        LEFT JOIN offers o ON op.offer_id = o.id
            AND o.status = 1
            AND NOW() BETWEEN o.start_date AND o.end_date
        WHERE p.id = $pid
        ");

        if ($p = mysqli_fetch_assoc($res)) {

            // Apply offer logic
            $price = $p['price'];

            if (!empty($p['type'])) {
                if ($p['type'] == 'percentage') {
                    $price = $price - ($price * $p['value'] / 100);
                } else {
                    $price = $price - $p['value'];
                }
            }

            $total = $price * $qty;
            $grandTotal += $total;
    ?>

    <div class="cart-item">

        <!-- IMAGE -->
        <div class="cart-img">
            <img src="<?php echo $base_url; ?>assets/images/products/<?php echo $p['image']; ?>">
        </div>

        <!-- DETAILS -->
        <div class="cart-details">
            <h3><?php echo htmlspecialchars($p['name']); ?></h3>

            <p class="cart-price">
                ₹<?php echo number_format($price, 2); ?>
            </p>

            <?php if (!empty($p['type'])) { ?>
                <p class="old-price">
                    ₹<?php echo number_format($p['price'], 2); ?>
                </p>
            <?php } ?>
        </div>

        <!-- QUANTITY -->
        <div class="quantity-control cart-mode" data-product-id="<?php echo $pid; ?>">
            <button type="button" class="qty-btn minus">−</button>
            <input type="number" class="qty-input" value="<?php echo $qty; ?>" min="0">
            <button type="button" class="qty-btn plus">+</button>
        </div>

        <!-- TOTAL -->
        <div class="cart-total">
            ₹<?php echo number_format($total, 2); ?>
        </div>

        <!-- REMOVE -->
        <div class="cart-remove">
            <a href="remove-from-cart.php?id=<?php echo $pid; ?>">❌</a>
        </div>

    </div>

    <?php }} ?>

    </div> <!-- cart-items -->


    <!-- RIGHT SIDE: TOTAL -->
    <div class="cart-actions">

        <h3>Cart Total</h3>

        <p class="grand-total">
            ₹<?php echo number_format($grandTotal, 2); ?>
        </p>

        <a href="<?php echo $base_url; ?>pages/checkout.php" class="checkout-btn">
            Proceed to Checkout
        </a>

    </div>

</div> <!-- cart-container -->

<?php } ?>

</main>
<script src="<?php echo $base_url; ?>assets/js/quantity.js"></script>
<?php include '../includes/faq.php'; ?>
<?php include_once '../includes/footer.php'; ?>