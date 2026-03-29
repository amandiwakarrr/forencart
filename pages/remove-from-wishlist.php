<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    // ✅ Secure query (prepared statement)
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        echo "Removed from wishlist!";
    } else {
        echo "Error removing item!";
    }

    $stmt->close();
}
?>