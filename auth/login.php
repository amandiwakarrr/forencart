<?php
include '../includes/header.php';
include '../includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../pages/account.php");
    exit;
}
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/auth.css">
<form method="POST" action="verify_otp.php">

    <input type="email" name="email" placeholder="Enter Email" required>

    <button type="button" onclick="sendOTP()">Send OTP</button>

    <input type="text" name="otp" id="otpBox" placeholder="Enter OTP" style="display:none;">

    <button type="submit">Login</button>

    <p id="msg"></p>

</form>

<script src="<?php echo $base_url; ?>assets/js/email-auth.js"></script>
<!-- <div class="auth-box">
    <h2>Login</h2>

    <input type="email" name="email" placeholder="Enter Email" required>

    <button type="button" onclick="sendOTP()">Send OTP</button>

    <input type="text" name="otp" id="otpBox" placeholder="Enter OTP" style="display:none;">

    <button type="button" onclick="verifyOTP()">Login</button>

    <p id="msg"></p>

    <a href="register.php">Create account</a>
</div>

<script src="assets/js/email-auth.js"></script> -->