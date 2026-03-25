<?php
include_once '../includes/header.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: shop.php");
    exit;
}

$product_id = (int) $_POST['id'];
$qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 1;

if ($qty < 1) $qty = 1;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $qty;  // ✅ FIXED
} else {
    $_SESSION['cart'][$product_id] = $qty;   // ✅ FIXED
}

header("Location: cart.php");
exit;