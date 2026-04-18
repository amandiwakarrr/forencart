<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "forencart";

$conn = mysqli_connect("localhost", "root", "", "forencart", 3306);

if (!$conn) {
    die("Database connection failed");
}
?>
