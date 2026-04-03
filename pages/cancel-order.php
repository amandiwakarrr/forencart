<?php
session_start();
include '../includes/db.php';

// ✅ Allow only POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: orders.php");
    exit;
}

// ✅ Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$order_id = (int) $_POST['order_id'];

// ✅ Get order
$res = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE id = $order_id AND user_id = $user_id
");

$order = mysqli_fetch_assoc($res);

if (!$order) {
    die("Invalid order");
}

// ❌ Prevent cancel after shipping
if (!in_array($order['status'], ['pending', 'confirmed', 'active'])) {
    die("Order cannot be cancelled");
}

// 🔁 Get all items of this order
$items = mysqli_query($conn, "
    SELECT product_id, quantity 
    FROM order_items 
    WHERE order_id = $order_id
");

// ✅ Restore stock
while ($item = mysqli_fetch_assoc($items)) {
    mysqli_query($conn, "
        UPDATE products 
        SET stock = stock + {$item['quantity']} 
        WHERE id = {$item['product_id']}
    ");
}

// ✅ Cancel all order items
mysqli_query($conn, "
    UPDATE order_items 
    SET status='cancelled', cancelled_at=NOW()
    WHERE order_id = $order_id
");

// ✅ Update order status
mysqli_query($conn, "
    UPDATE orders 
    SET status='cancelled', cancelled_at=NOW() 
    WHERE id = $order_id
");

// ✅ Redirect
header("Location: orders.php?msg=order_cancelled");
exit;