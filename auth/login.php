<?php
include '../includes/header.php';
include '../includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../pages/account.php");
    exit;
}
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/auth.css">

<div class="auth-box">

    <h2>Login</h2>

    <input type="email" id="email" name="email" placeholder="Enter Email" required>
    <input type="password" id="password" name="password" placeholder="Enter Password" required>
    <a href="forgot-password.php">Forgot Password?</a>

   <button type="button" id="checkBtn" onclick="checkUser()">Check</button>

    <button type="button" id="sendOtpBtn" onclick="sendOTP()" style="display:none;">
        Send OTP
    </button>

    <button type="button" id="loginBtn" onclick="verifyOTP()" style="display:none;">
        Login
    </button>
    <!-- OTP -->
    <input type="text" id="otpBox" name="otp" placeholder="Enter OTP" style="display:none;">    

    <!-- RESEND -->
    <p id="resendText" style="display:none;">
        Resend OTP in <span id="timer">30</span>s
    </p>


    <!-- LOADER -->
    <div id="loader" style="display:none;"></div>

    <p id="msg"></p>

</div>

<script src="<?php echo $base_url; ?>assets/js/email-auth.js"></script>