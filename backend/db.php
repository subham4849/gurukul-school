<?php
$host = "sql100.infinityfree.com";
$user = "if0_40658180";
$pass = "EJNt49jxlAeTXd";
$db   = "if0_40658180_gurukul_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
