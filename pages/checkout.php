<?php
include '../includes/header.php';
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}
include '../includes/navbar.php';
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/checkout.css">

<main class="checkout-page">

    <h1>Checkout</h1>

    <form action="place-order.php" method="post" class="checkout-form">

        <!-- CUSTOMER INFO -->
        <div class="checkout-box">
            <h3>Billing Details</h3>

            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
        </div>

        <!-- ORDER SUMMARY -->
        <div class="checkout-box">
            <h3>Your Order</h3>

            <ul class="order-list">
                <?php
                $grandTotal = 0;

                foreach ($cart as $id => $qty) {
                    $res = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
                    $p = mysqli_fetch_assoc($res);
                    $total = $p['price'] * $qty;
                    $grandTotal += $total;
                ?>
                    <li>
                        <?php echo htmlspecialchars($p['name']); ?> × <?php echo $qty; ?>
                        <span>₹<?php echo number_format($total, 2); ?></span>
                    </li>
                <?php } ?>
            </ul>

            <h4 class="grand-total">
                Total: ₹<?php echo number_format($grandTotal, 2); ?>
            </h4>

            <button type="submit" class="place-order-btn">
                Place Order
            </button>
        </div>

    </form>

</main>
<?php include '../includes/faq.php'; ?>
<?php include '../includes/footer.php'; ?>
