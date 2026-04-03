<?php
session_start();
include '../includes/db.php';

// DEBUG (remove later)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = $_GET['action'] ?? '';

if (!$order_id || !$action) {
    die("Invalid request");
}

// Decide status
$status = '';

if ($action == 'confirm') {
    $status = 'confirmed';
}
elseif ($action == 'ship') {
    $status = 'shipped';
}
elseif ($action == 'deliver') {
    $status = 'delivered';
}
else {
    die("Invalid action");
}

// ✅ Update order
$update1 = mysqli_query($conn, "
    UPDATE orders SET status='$status' WHERE id=$order_id
");

// ✅ Update items
$update2 = mysqli_query($conn, "
    UPDATE order_items SET status='$status' WHERE order_id=$order_id
");

if (!$update1 || !$update2) {
    die("DB Error: " . mysqli_error($conn));
}

// 🔥 SUCCESS CHECK
header("Location: orders-view.php?id=$order_id&msg=updated");
exit;