<?php
include_once '../includes/header.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn, "
        INSERT INTO users (name, email, password)
        VALUES ('$name', '$email', '$pass')
    ");

    $msg = "Account created. Please login.";
}
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/auth.css">

<form method="post">
    <input name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button>Create Account</button>
    <p><?php echo $msg; ?></p>
    <a href="login.php">Back to login</a>
</form>

