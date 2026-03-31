<?php
session_start();
include_once '../includes/db.php';
include_once '../config/config.php';

use PHPMailer\PHPMailer\PHPMailer;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

$email = $_POST['email'];
$reply = $_POST['reply'];
$id = $_POST['id'];

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'yourgmail@gmail.com';
$mail->Password = 'your_app_password';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('yourgmail@gmail.com', 'ForenCart');
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject = "Reply from ForenCart";
$mail->Body = "<p>$reply</p>";

$mail->send();

// update status
$stmt = $conn->prepare("UPDATE contacts SET status='replied' WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: " . $base_url . "admin/messages.php");
exit;
?>