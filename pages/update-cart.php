<?php
session_start();
include '../includes/db.php';

if (isset($_POST['id']) && isset($_POST['qty'])) {

    $id = (int) $_POST['id'];
    $qty = (int) $_POST['qty'];

    if ($qty > 0) {
        $_SESSION['cart'][$id] = $qty;
    } else {
        unset($_SESSION['cart'][$id]);
    }

    // 🔥 Recalculate totals
    $grandTotal = 0;
    $itemTotal = 0;

    foreach ($_SESSION['cart'] as $pid => $q) {

        $res = mysqli_query($conn, "SELECT price FROM products WHERE id = $pid");
        $p = mysqli_fetch_assoc($res);

        $total = $p['price'] * $q;

        if ($pid == $id) {
            $itemTotal = $total;
        }

        $grandTotal += $total;
    }

    echo json_encode([
        "itemTotal" => number_format($itemTotal, 2),
        "grandTotal" => number_format($grandTotal, 2)
    ]);
}
?>