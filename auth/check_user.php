<?php
session_start();
header('Content-Type: application/json');
include '../includes/db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($res) == 0){
    echo json_encode(["status"=>"error","msg"=>"User not found"]);
    exit;
}

$user = mysqli_fetch_assoc($res);

if(!password_verify($password, $user['password'])){
    echo json_encode(["status"=>"error","msg"=>"Wrong Password"]);
    exit;
}

$_SESSION['temp_email'] = $email;
$_SESSION['temp_user_id'] = $user['id'];

echo json_encode(["status"=>"success","msg"=>"Verified"]);
