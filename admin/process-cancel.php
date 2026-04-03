<?php
include '../includes/db.php';

$id = (int) $_GET['id'];
$action = $_GET['action'];

// Get cancellation request
$res = mysqli_query($conn, "
SELECT oc.*, oi.product_id, oi.quantity, oi.price, oi.order_id
FROM order_cancellations oc
JOIN order_items oi ON oc.order_item_id = oi.id
WHERE oc.id = $id
");

$data = mysqli_fetch_assoc($res);

if (!$data) die("Invalid");

// REJECT
if ($action == 'reject') {
    mysqli_query($conn, "UPDATE order_cancellations SET status='rejected' WHERE id=$id");
    header("Location: cancel-requests.php");
    exit;
}

// APPROVE
if ($action == 'approve') {

    // 1. Mark cancellation approved
    mysqli_query($conn, "UPDATE order_cancellations SET status='approved' WHERE id=$id");

    // 2. Cancel item
    mysqli_query($conn, "
        UPDATE order_items 
        SET status='cancelled', cancelled_at=NOW() 
        WHERE id={$data['order_item_id']}
    ");

    // 3. Restore stock
    mysqli_query($conn, "
        UPDATE products 
        SET stock = stock + {$data['quantity']} 
        WHERE id={$data['product_id']}
    ");

    // 4. Create refund
    mysqli_query($conn, "
        INSERT INTO refunds (order_id, amount)
        VALUES ({$data['order_id']}, {$data['price']})
    ");

    // 5. Email user
    include '../includes/mail.php';
    sendCancelMail($data['order_id']);

    header("Location: cancel-requests.php?msg=approved");
}