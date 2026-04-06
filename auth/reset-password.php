<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['otp_verified'])) {
    header("Location: forgot-password.php");
    exit;
}

$email = $_SESSION['temp_email'] ?? '';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass !== $confirm) {
        $msg = "Passwords do not match!";
    } else {

        $hash = password_hash($pass, PASSWORD_DEFAULT);

        mysqli_query($conn, "
            UPDATE users 
            SET password='$hash'
            WHERE email='$email'
        ");

        unset($_SESSION['otp_verified']);
        unset($_SESSION['otp_purpose']);

        header("Location: login.php?reset=success");
        exit;
    }
}
?>

<form method="post">
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <button>Reset Password</button>
</form>

<p><?php echo $msg; ?></p>