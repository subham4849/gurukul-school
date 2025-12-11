<?php
$host = "sql100.infinityfree.com";
$user = "if0_40658180";
$pass = "EJNt49jxlAeTXd";
$dbname = "if0_40658180_gurukul_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}
?>