<?php
session_start();
include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$order_item_id = (int) $_POST['order_item_id'];
$reason = mysqli_real_escape_string($conn, $_POST['reason']);

// Get item + ownership check
$res = mysqli_query($conn, "
SELECT oi.*, o.user_id 
FROM order_items oi
JOIN orders o ON oi.order_id = o.id
WHERE oi.id = $order_item_id
");

$item = mysqli_fetch_assoc($res);

// Validation
if (!$item || $item['user_id'] != $user_id) {
    die("Unauthorized");
}

if ($item['status'] != 'active') {
    die("Already processed");
}

// Insert request
mysqli_query($conn, "
INSERT INTO order_cancellations (order_id, order_item_id, user_id, reason)
VALUES ({$item['order_id']}, $order_item_id, $user_id, '$reason')
");

header("Location: orders.php?msg=requested");