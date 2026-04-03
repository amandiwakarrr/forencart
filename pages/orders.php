<?php
require_once '../includes/header.php';

/* 🔐 Login check */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../includes/navbar.php';

$user_id = (int) $_SESSION['user_id'];

/* 📦 Fetch orders */
$orders = mysqli_query($conn, "
    SELECT * FROM orders
    WHERE user_id = $user_id
    ORDER BY created_at DESC
");

if (!$orders) {
    die("Orders query failed: " . mysqli_error($conn));
}
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/orders.css">

<div class="orders-page">
    <h2 class="orders-title">📦 My Orders</h2>

    <?php if (mysqli_num_rows($orders) === 0) { ?>
        <p>No orders found.</p>
    <?php } ?>

    <?php while ($order = mysqli_fetch_assoc($orders)) { ?>

        <!-- ORDER CARD -->
        <div class="order-landscape-card">

            <!-- IMAGE -->
            <div class="order-image">
                <?php
                $preview = mysqli_query($conn, "
                    SELECT p.image
                    FROM order_items oi
                    JOIN products p ON p.id = oi.product_id
                    WHERE oi.order_id = {$order['id']}
                    LIMIT 1
                ");
                $prev = mysqli_fetch_assoc($preview);
                ?>
                <img src="<?php echo $base_url; ?>assets/images/products/<?php echo $prev['image'] ?? 'placeholder.png'; ?>">
            </div>

            <!-- INFO -->
            <div class="order-info">
                <h3>Order #<?php echo $order['id']; ?></h3>

                <p>📅 <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>

                <p class="total">
                    Total: ₹<?php echo number_format($order['total'], 2); ?>
                </p>

                <!-- ORDER STATUS -->
                <p>
                    Status:
                    <strong class="status <?php echo $order['status']; ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </strong>
                </p>
            </div>

            <!-- ACTION -->
            <div class="order-actions">
                <a href="<?php echo $base_url; ?>pages/invoice.php?order_id=<?php echo $order['id']; ?>"
                   class="btn invoice" target="_blank">
                   Invoice
                </a>
                <?php if ($order['status'] == 'pending' || $order['status'] == 'confirmed' || $order['status'] == 'active') { ?>

                    <form action="cancel-order.php" method="POST"
                        onsubmit="return confirm('Cancel this order?')">

                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">

                        <button type="submit" class="cancel-btn">
                            Cancel Order
                        </button>

                    </form>

                <?php } ?>
            </div>
        </div>

        <!-- ITEMS (ALWAYS VISIBLE) -->
        <div class="order-items">

            <?php
            $items = mysqli_query($conn, "
                SELECT oi.id, oi.status, p.name, p.image, oi.quantity, oi.price
                FROM order_items oi
                JOIN products p ON p.id = oi.product_id
                WHERE oi.order_id = {$order['id']}
            ");
            ?>

            <?php while ($it = mysqli_fetch_assoc($items)) { ?>
                <div class="order-item">

                    <img src="<?php echo $base_url; ?>assets/images/products/<?php echo $it['image']; ?>">

                    <div>
                        <p class="item-name"><?php echo htmlspecialchars($it['name']); ?></p>

                        <p>
                            Qty: <?php echo $it['quantity']; ?> × ₹<?php echo number_format($it['price'], 2); ?>
                        </p>

                        <!-- ITEM STATUS -->
                        <p>
                            Status:
                            <?php if ($it['status'] == 'active') { ?>
                                <span style="color:blue;">Active</span>
                            <?php } elseif ($it['status'] == 'cancelled') { ?>
                                <span style="color:red;">Cancelled</span>
                            <?php } else { ?>
                                <span style="color:orange;">Pending</span>
                            <?php } ?>
                        </p>

                        <!-- CANCEL BUTTON -->
                        <?php if ($it['status'] == 'active') { ?>

                            <form action="request-cancel.php" method="POST">

                                <input type="hidden" name="order_item_id" value="<?php echo $it['id']; ?>">

                                <select name="reason" required>
                                    <option value="">Cancel Reason</option>
                                    <option value="Ordered by mistake">Ordered by mistake</option>
                                    <option value="Found cheaper">Found cheaper</option>
                                    <option value="Delivery delay">Delivery delay</option>
                                    <option value="Other">Other</option>
                                </select>

                                <button type="submit">Cancel Item</button>

                            </form>

                        <?php } ?>

                    </div>

                    <strong>
                        ₹<?php echo number_format($it['quantity'] * $it['price'], 2); ?>
                    </strong>

                </div>
            <?php } ?>

        </div>

    <?php } ?>
</div>

<?php include '../includes/footer.php'; ?>