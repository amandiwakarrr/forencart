<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/includes/admin-header.php";
$order_id = (int)$_GET['id'];

// Fetch order
$order = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id")
);

// Fetch order items
$items = mysqli_query($conn, "
    SELECT oi.*, p.name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = $order_id
");
?>

<main class="admin-content">

    <h1>Order #<?php echo $order['id']; ?></h1>

    <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
    <p><strong>Total:</strong> ₹<?php echo number_format($order['total'], 2); ?></p>

    <h3>Products</h3>

    <table class="admin-table">
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>

        <?php while ($item = mysqli_fetch_assoc($items)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>₹<?php echo number_format($item['price'], 2); ?></td>
            <td>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
        </tr>
        <?php } ?>
    </table>

            <p><strong>Status:</strong> 
            <span style="font-weight:bold;">
                <?php echo ucfirst($order['status']); ?>
            </span>
        </p>

        <!-- ✅ ADMIN ACTION BUTTONS -->
        <div style="margin: 15px 0;">

        <?php if ($order['status'] == 'pending') { ?>

            <a href="update-order.php?id=<?php echo $order['id']; ?>&action=confirm"
            style="background:green;color:white;padding:8px 12px;text-decoration:none;">
            Approve Order
            </a>

        <?php } ?>

        <?php if ($order['status'] == 'confirmed') { ?>

            <a href="update-order.php?id=<?php echo $order['id']; ?>&action=ship"
            style="background:blue;color:white;padding:8px 12px;text-decoration:none;">
            Mark as Shipped
            </a>

        <?php } ?>

        <?php if ($order['status'] == 'shipped') { ?>

            <a href="update-order.php?id=<?php echo $order['id']; ?>&action=deliver"
            style="background:black;color:white;padding:8px 12px;text-decoration:none;">
            Mark as Delivered
            </a>

        <?php } ?>

        <?php if ($order['status'] == 'cancelled') { ?>

            <span style="color:red;font-weight:bold;">
                Order Cancelled
            </span>

        <?php } ?>

        </div>

</main>

</body>
</html>
