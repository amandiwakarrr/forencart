<?php
if (!isset($_POST['send_otp']) && !isset($_POST['verify_otp']) && !isset($_POST['reset_password'])) {
    unset($_SESSION['fp_step']);
}
include '../includes/db.php';
include '../includes/mailer.php';
session_start();

$msg = "";
// $step = $_SESSION['fp_step'] ?? 1; // 1=email, 2=otp, 3=reset

// ================= STEP 1: SEND OTP =================
if (isset($_POST['send_otp'])) {

    $email = $_POST['email'];

    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($res)) {

        $otp = rand(100000, 999999);
        $hashedOtp = password_hash($otp, PASSWORD_DEFAULT);
        $expire = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // store in email_otp table (your system)
        mysqli_query($conn, "
            INSERT INTO email_otp (email, otp, expires_at)
            VALUES ('$email', '$hashedOtp', '$expire')
        ");

        if (sendOTP($email, $otp)) {

            $_SESSION['temp_email'] = $email;
            $_SESSION['fp_step'] = 2;

            $msg = "OTP sent to your email";

        } else {
            $msg = "Failed to send OTP!";
        }

    } else {
        $msg = "Email not found!";
    }
}

// ================= STEP 2: VERIFY OTP =================
if (isset($_POST['verify_otp'])) {

    $email = $_SESSION['temp_email'];
    $otp = $_POST['otp'];

    $res = mysqli_query($conn,
    "SELECT * FROM email_otp 
     WHERE email='$email' 
     ORDER BY id DESC LIMIT 1");

    if ($row = mysqli_fetch_assoc($res)) {

        if (strtotime($row['expires_at']) < time()) {
            $msg = "OTP expired";
        } elseif (!password_verify($otp, $row['otp'])) {
            $msg = "Wrong OTP";
        } else {

            $_SESSION['fp_step'] = 3;
            $msg = "OTP verified successfully";

            // delete OTP
            mysqli_query($conn, "DELETE FROM email_otp WHERE email='$email'");
        }

    } else {
        $msg = "No OTP found";
    }
}

// ================= STEP 3: RESET PASSWORD =================
if (isset($_POST['reset_password'])) {

    $email = $_SESSION['temp_email'];
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

        // clear session
        session_destroy();

        header("Location: login.php?reset=success");
        exit;
    }
}
$step = $_SESSION['fp_step'] ?? 1;
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/forgot-password.css">
<div class="fp-box">

<h2>Forgot Password</h2>

<p><?php echo $msg; ?></p>

<!-- STEP 1: EMAIL -->
<?php if ($step == 1) { ?>
<form method="post">
    <input type="email" name="email" placeholder="Enter Email" required>
    <button name="send_otp">Send OTP</button>
</form>
<?php } ?>

<!-- STEP 2: OTP -->
<?php if ($step == 2) { ?>
<form method="post">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button name="verify_otp">Verify OTP</button>
</form>
<?php } ?>

<!-- STEP 3: RESET PASSWORD -->
<?php if ($step == 3) { ?>
<form method="post">
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <button name="reset_password">Reset Password</button>
</form>
<?php } ?>
<style>
    /* Page Center */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #000, #1a1a1a);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Box */
.fp-box {
    background: #111;
    padding: 35px;
    width: 350px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    text-align: center;
    color: white;
}

/* Heading */
.fp-box h2 {
    color: #ff6600;
    margin-bottom: 15px;
}

/* Message */
.fp-box p {
    font-size: 14px;
    margin-bottom: 10px;
    color: #ccc;
}

/* Inputs */
.fp-box input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    background: #222;
    color: white;
}

/* Focus */
.fp-box input:focus {
    outline: none;
    border: 1px solid #ff6600;
}

/* Button */
.fp-box button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: none;
    border-radius: 8px;
    background: #ff6600;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

/* Hover */
.fp-box button:hover {
    background: #e65c00;
}

/* Animation */
.fp-box form {
    animation: fade 0.4s ease;
}

@keyframes fade {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</div>