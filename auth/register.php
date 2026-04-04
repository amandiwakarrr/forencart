<?php
include '../includes/db.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];
    $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 🔍 Check email or mobile exists
    $check = mysqli_prepare($conn, 
        "SELECT id FROM users WHERE email = ? OR mobile = ?"
    );
    mysqli_stmt_bind_param($check, "ss", $email, $mobile);
    mysqli_stmt_execute($check);
    $res = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($res) > 0) {

        // Optional: detect which one
        $row = mysqli_fetch_assoc($res);

        $msg = "⚠️ Email or Mobile already registered";

    } else {

        $stmt = mysqli_prepare($conn,
            "INSERT INTO users (name,email,password,mobile,role,status,created_at)
             VALUES (?,?,?,?,'user','active',NOW())"
        );

        mysqli_stmt_bind_param($stmt,"ssss",$name,$email,$pass,$mobile);
        // mysqli_stmt_execute($stmt);

        // $msg = "✅ Account created successfully";
        if (mysqli_stmt_execute($stmt)) {

            $_SESSION['success_msg'] = "Account created successfully. Please login.";

            header("Location: login.php");
            exit();

        } else {
            $msg = "❌ Something went wrong";
        }
    }
}
include '../includes/header.php';
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/auth.css">

<div class="auth-box">
    <h2>Register</h2>

    <form method="post">
        <input name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="mobile" placeholder="Mobile Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Create Account</button>
    </form>

    <p><?php echo $msg; ?></p>
    <a href="login.php">Back to login</a>
</div>