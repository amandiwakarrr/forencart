<?php
include("../config/config.php");
include("../includes/db.php");

$id = $_GET['id'];

// Step 1: Delete from child table
mysqli_query($conn, "DELETE FROM offer_products WHERE offer_id = $id");

// Step 2: Delete from offers
mysqli_query($conn, "DELETE FROM offers WHERE id = $id");

header("Location: manage-offers.php");
exit;
?>