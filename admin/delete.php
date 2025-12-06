<?php
session_start();
require_once("../backend/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM admissions WHERE id=$id");

header("Location: view.php?deleted=1");
exit();
?>
