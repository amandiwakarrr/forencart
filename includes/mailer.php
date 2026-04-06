<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

function sendOTP($toEmail, $otp) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // 🔴 CHANGE THIS
        $mail->Username = 'amandiwakarfghp@gmail.com';
        $mail->Password = 'pftmwagwmcqxgrmc';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('amandiwakarfghp@gmail.com', 'Forencart');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'OTP for Password Reset';

        $mail->Body = "
            <h2>Your OTP: $otp</h2>
            <p>Valid for 10 minutes</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}