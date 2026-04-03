<?php
use PHPMailer\PHPMailer\PHPMailer;

function sendCancelMail($order_id) {

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'amandiwakarfghp@gmail.com';
    $mail->Password = 'app_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('amandiwakarfghp@gmail.com', 'Store');
    $mail->addAddress('user@email.com');

    $mail->Subject = "Cancellation Approved";
    $mail->Body = "Order #$order_id item cancelled & refund initiated.";

    $mail->send();
}