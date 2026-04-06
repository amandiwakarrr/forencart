<?php
include '../includes/header.php';
include '../includes/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $pass  = $_POST['password'];

   $stmt = mysqli_prepare($conn,
    "SELECT * FROM users WHERE email=? AND role='admin' AND status=1"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($res)) {

        if (password_verify($pass, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: ../admin/index.php");
            exit;

        } else {
            $error = "Wrong password";
        }

    } else {
        $error = "Admin not found";
    }
}
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/admin-login.css">

<div class="auth-box">
    <h2>Admin Login</h2>

    <?php if($error) echo "<p>$error</p>"; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Login</button>
    </form>
</div>