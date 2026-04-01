<?php
header('Content-Type: application/json');
include '../includes/db.php';

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$email = $_POST['email'] ?? '';

// Validate
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status"=>"error","msg"=>"Invalid email"]);
    exit;
}

// Check user exists
$res = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
if(mysqli_num_rows($res)==0){
    echo json_encode(["status"=>"error","msg"=>"Email not registered"]);
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
    $mail->Body = "<h2>Your OTP is: $otp</h2>";

    $mail->send();

    echo json_encode(["status"=>"success","msg"=>"OTP sent"]);

} catch (Exception $e) {
    echo json_encode(["status"=>"error","msg"=>"Mail failed"]);
}