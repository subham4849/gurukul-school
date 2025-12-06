<?php
session_start();
require_once(__DIR__ . "/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $hashedPassword = hash("sha256", $password);

    $sql = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin'] = $email;

        // FINAL WORKING REDIRECT (RELATIVE PATH)
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        header("Location: ../admin/login.php?error=1");
        exit;
    }

} else {
    header("Location: ../admin/login.php");
    exit;
}
?>