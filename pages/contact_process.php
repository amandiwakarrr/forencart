<?php
session_start();

$ip = $_SERVER['REMOTE_ADDR'];
$time = time();

if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}

// Remove old requests (older than 60 sec)
$_SESSION['requests'] = array_filter($_SESSION['requests'], function($t) use ($time) {
    return ($time - $t) < 60;
});

// Limit: max 3 requests per minute
if (count($_SESSION['requests']) >= 3) {
    echo json_encode([
        "status" => "error",
        "message" => "Too many requests. Try again later."
    ]);
    exit;
}

// Add current request
$_SESSION['requests'][] = $time;


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
        $mail->Username   = 'amandiwakarfghp@gmail.com'; // 🔥 your gmail
        $mail->Password   = 'pftmwagwmcqxgrmc';   // 🔥 app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender & Receiver
        $mail->setFrom($email, $name);
        $mail->addAddress('amandiwakarfghp@gmail.com'); // receive mail

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