<?php
session_start();
include_once '../includes/db.php';
include_once '../config/config.php';

$id = $_GET['id'];

$stmt = $conn->prepare("UPDATE contacts SET status='read' WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: " . $base_url . "admin/messages.php");
exit;
?>