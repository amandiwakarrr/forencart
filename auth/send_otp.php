<?php
session_start();
header('Content-Type: application/json');
include '../includes/db.php';

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$email = $_POST['email'] ?? '';

// ✅ STEP 1: Check session (VERY IMPORTANT)
if (!isset($_SESSION['temp_email']) || $_SESSION['temp_email'] !== $email) {
    echo json_encode(["status"=>"error","msg"=>"Unauthorized request"]);
    exit;
}

// Validate
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status"=>"error","msg"=>"Invalid email"]);
    exit;
}

// Rate limit
$check = mysqli_query($conn,
"SELECT id FROM email_otp 
 WHERE email='$email' 
 AND created_at > NOW() - INTERVAL 30 SECOND");

if(mysqli_num_rows($check)>0){
    echo json_encode(["status"=>"error","msg"=>"Wait 30 sec"]);
    exit;
}

// OTP
$otp = rand(100000,999999);
$hash = password_hash($otp, PASSWORD_DEFAULT);
$expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// OPTIONAL: delete old OTPs (clean DB)
mysqli_query($conn, "DELETE FROM email_otp WHERE email='$email'");

// Insert
mysqli_query($conn,
"INSERT INTO email_otp (email,otp,expires_at)
 VALUES('$email','$hash','$expires')");

// Send Mail
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'amandiwakarfghp@gmail.com';
    $mail->Password = 'pftmwagwmcqxgrmc';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('amandiwakarfghp@gmail.com', 'Forencart');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body = "
        <div style='font-family:sans-serif'>
            <h2>Forencart Login OTP</h2>
            <p>Your OTP is:</p>
            <h1 style='letter-spacing:3px;'>$otp</h1>
            <p>This OTP will expire in 5 minutes.</p>
        </div>
    ";

    $mail->send();

    echo json_encode(["status"=>"success","msg"=>"OTP sent"]);

} catch (Exception $e) {
    echo json_encode(["status"=>"error","msg"=>"Mail failed"]);
}