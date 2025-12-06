<?php
header('Content-Type: application/json');
require_once(__DIR__ . "/db.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

// Collect data
$student_name = $_POST['student_name'];
$class = $_POST['class'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$parent_name = $_POST['parent_name'];
$relationship = $_POST['relationship'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$address = $_POST['address'];
$previous_school = $_POST['previous_school'] ?? "";

// SQL Query
$sql = "INSERT INTO admissions 
(student_name, class, dob, gender, parent_name, relationship, contact, email, address, previous_school, status, date_applied) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";

$stmt = mysqli_prepare($conn, $sql);

// FIXED BIND COUNT → 10 placeholders = 10 "s"
mysqli_stmt_bind_param($stmt, "ssssssssss",
    $student_name, $class, $dob, $gender, $parent_name,
    $relationship, $contact, $email, $address, $previous_school
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../thank-you.html");
    exit();
} else {
    echo "Database Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
