<?php
include '../includes/db.php';

$res = mysqli_query($conn, "
SELECT oc.*, oi.product_id, oi.quantity, oi.price
FROM order_cancellations oc
JOIN order_items oi ON oc.order_item_id = oi.id
WHERE oc.status = 'pending'
");
?>

<h2>Cancel Requests</h2>

<?php while($row = mysqli_fetch_assoc($res)) { ?>

<div>
    <p>Reason: <?php echo $row['reason']; ?></p>

    <a href="process-cancel.php?id=<?php echo $row['id']; ?>&action=approve">Approve</a>
    <a href="process-cancel.php?id=<?php echo $row['id']; ?>&action=reject">Reject</a>
</div>

<?php } ?>