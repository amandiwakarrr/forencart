<?php
session_start();
header('Content-Type: application/json');
include '../includes/db.php';

$email = $_POST['email'] ?? '';
$otp   = $_POST['otp'] ?? '';

// ✅ SESSION CHECK (IMPORTANT)
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

// ✅ SUCCESS LOGIN
$_SESSION['user_id'] = $u['id'];
$_SESSION['user_name'] = $u['name'];

// 🔥 DELETE OTP AFTER USE (VERY IMPORTANT)
mysqli_query($conn, "DELETE FROM email_otp WHERE email='$email'");

// OPTIONAL: clear temp session
unset($_SESSION['temp_email']);

// ✅ JSON RESPONSE (for JS)
echo json_encode(["status"=>"success","msg"=>"Login successful"]);