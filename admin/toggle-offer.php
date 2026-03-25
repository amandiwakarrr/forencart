<?php
include_once '../includes/header.php';

$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT status FROM offers WHERE id=$id");
$data = mysqli_fetch_assoc($res);

$newStatus = $data['status'] ? 0 : 1;

mysqli_query($conn, "UPDATE offers SET status=$newStatus WHERE id=$id");

header("Location: manage-offers.php");
exit;