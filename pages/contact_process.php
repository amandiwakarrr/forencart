<?php
header('Content-Type: application/json');

include_once '../includes/db.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["status"=>"error","message"=>"All fields required"]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status"=>"error","message"=>"Invalid email"]);
        exit;
    }

    // ===============================
    // SAVE TO DATABASE
    // ===============================
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();

    // ===============================
    // SEND EMAIL
    // ===============================
    $mail = new PHPMailer(true);

    try {
        // SMTP config
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'amandiwakar8630@gmail.com'; // 🔥 your gmail
        $mail->Password   = 'your_app_password';   // 🔥 app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender & Receiver
        $mail->setFrom($email, $name);
        $mail->addAddress('yourgmail@gmail.com'); // receive mail

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message";
        $mail->Body    = "
            <h3>New Message</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Message:</b><br>$message</p>
        ";

        $mail->send();

        // ===============================
        // AUTO REPLY TO USER
        // ===============================
        $mail->clearAddresses();
        $mail->addAddress($email);

        $mail->Subject = "Thanks for contacting ForenCart";
        $mail->Body = "
            <h3>Hi $name,</h3>
            <p>Thanks for contacting us. We will get back to you soon.</p>
        ";

        $mail->send();

        echo json_encode([
            "status" => "success",
            "message" => "Message sent successfully!"
        ]);

    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Email failed but saved in DB"
        ]);
    }
}
?>