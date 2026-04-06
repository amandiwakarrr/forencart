<?php
session_start();
header('Content-Type: application/json');
include '../includes/db.php';

$email = $_POST['email'] ?? '';
$otp   = $_POST['otp'] ?? '';

// ✅ SESSION CHECK
if (!isset($_SESSION['temp_email']) || $_SESSION['temp_email'] !== $email) {
    echo json_encode(["status"=>"error","msg"=>"Unauthorized"]);
    exit;
}

// Get latest OTP
$res = mysqli_query($conn,
"SELECT * FROM email_otp 
 WHERE email='$email' 
 ORDER BY id DESC LIMIT 1");

if(!$row = mysqli_fetch_assoc($res)){
    echo json_encode(["status"=>"error","msg"=>"No OTP found"]);
    exit;
}

// Expiry check
if(strtotime($row['expires_at']) < time()){
    echo json_encode(["status"=>"error","msg"=>"OTP expired"]);
    exit;
}

// Verify OTP
if(!password_verify($otp, $row['otp'])){
    echo json_encode(["status"=>"error","msg"=>"Wrong OTP"]);
    exit;
}

// Get user
$user = mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'");

if(!$u = mysqli_fetch_assoc($user)){
    echo json_encode(["status"=>"error","msg"=>"User not found"]);
    exit;
}

// 🔥 CHECK PURPOSE (IMPORTANT)
$purpose = $_SESSION['otp_purpose'] ?? 'login';

if ($purpose === "login") {

    // ✅ LOGIN FLOW
    $_SESSION['user_id'] = $u['id'];
    $_SESSION['user_name'] = $u['name'];

    // delete OTP
    mysqli_query($conn, "DELETE FROM email_otp WHERE email='$email'");

    // clear session
    unset($_SESSION['temp_email']);
    unset($_SESSION['otp_purpose']);

    echo json_encode([
        "status" => "success",
        "msg" => "Login successful",
        "redirect" => "../index.php"
    ]);
    exit;
}

if ($purpose === "reset") {

    // ✅ FORGOT PASSWORD FLOW
    $_SESSION['otp_verified'] = true;

    // delete OTP
    mysqli_query($conn, "DELETE FROM email_otp WHERE email='$email'");

    // ❗ DO NOT unset temp_email (needed for reset-password.php)
    unset($_SESSION['otp_purpose']);

    echo json_encode([
        "status" => "success",
        "msg" => "OTP verified",
        "redirect" => "reset-password.php"
    ]);
    exit;
}

// fallback
echo json_encode(["status"=>"error","msg"=>"Invalid request"]);