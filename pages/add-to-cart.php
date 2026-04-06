<?php
include_once '../includes/header.php'; // session already started

// Support BOTH POST (product page) and GET (offers page)
$id = $_POST['id'] ?? $_GET['id'] ?? null;

// Validate product ID
if (!$id || !is_numeric($id)) {
    header("Location: shop.php");
    exit;
}

$product_id = (int) $id;

// Get quantity (default = 1)
$qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 1;

// Ensure valid quantity
if ($qty < 1) {
    $qty = 1;
}

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add or update cart
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $qty;
} else {
    $_SESSION['cart'][$product_id] = $qty;
}

// Redirect to cart page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;