<?php
$host = "127.0.0.1:3307";
$user = "root";
$pass = "admin123";
$dbname = "gurukul_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}
?>