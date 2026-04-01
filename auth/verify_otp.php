<?php
session_start();
include '../includes/db.php';

$email = $_POST['email'] ?? '';
$otp   = $_POST['otp'] ?? '';

// Get latest OTP
$res = mysqli_query($conn,
"SELECT * FROM email_otp 
 WHERE email='$email' 
 ORDER BY id DESC LIMIT 1");

if(!$row = mysqli_fetch_assoc($res)){
    echo "No OTP found";
    exit;
}

// Expiry check
if(strtotime($row['expires_at']) < time()){
    echo "OTP expired";
    exit;
}

// Verify
if(!password_verify($otp, $row['otp'])){
    echo "Wrong OTP";
    exit;
}

// Get user
$user = mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'");

if(!$u = mysqli_fetch_assoc($user)){
    echo "User not found";
    exit;
}

// Set session
$_SESSION['user_id'] = $u['id'];
$_SESSION['user_name'] = $u['name'];

// Redirect
header("Location: ../pages/account.php");
exit;