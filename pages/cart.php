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

<table class="cart-table">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
    <th>Remove</th>
</tr>

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
<tr>
    <td><?php echo htmlspecialchars($p['name']); ?></td>

    <td>
        ₹<?php echo number_format($price, 2); ?>
        <?php if (!empty($p['type'])) { ?>
            <br>
            <small style="text-decoration: line-through; color: gray;">
                ₹<?php echo number_format($p['price'], 2); ?>
            </small>
        <?php } ?>
    </td>

    <td><?php echo $qty; ?></td>

    <td>₹<?php echo number_format($total, 2); ?></td>

    <td>
        <a href="remove-from-cart.php?id=<?php echo $pid; ?>">❌</a>
    </td>
</tr>
<?php }} ?>

<tr>
    <td colspan="3"><strong>Grand Total</strong></td>
    <td colspan="2"><strong>₹<?php echo number_format($grandTotal, 2); ?></strong></td>
</tr>

</table>

<?php if (!empty($cart)) { ?>
    <div class="cart-actions">
        <a href="<?php echo $base_url; ?>pages/checkout.php" class="checkout-btn">
            Proceed to Checkout
        </a>
    </div>
<?php } ?>

<?php } ?>

</main>

<?php include_once '../includes/footer.php'; ?>