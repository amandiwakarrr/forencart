<?php
include '../includes/header.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['user_role'] !== 'admin'
) {
    header("Location: " . $base_url . "auth/admin_login.php");
    exit;
}