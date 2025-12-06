<?php
session_start();
require_once("../backend/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$result = mysqli_query($conn, "SELECT * FROM admissions WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("<h3 style='color:red;'>Record not found!</h3>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Admission | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="p-4">

<a href="view.php" class="btn btn-secondary mb-3"><i class="fa-solid fa-arrow-left"></i> Back</a>

<div class="card shadow p-4">
    <h4 class="fw-bold mb-3">Admission Details</h4>
    <div class="row">
        
        <div class="col-md-6">
            <p><strong>Student Name:</strong> <?= $data['student_name'] ?></p>
            <p><strong>Class:</strong> <?= $data['class'] ?></p>
            <p><strong>Date of Birth:</strong> <?= $data['dob'] ?></p>
            <p><strong>Gender:</strong> <?= $data['gender'] ?></p>
        </div>

        <div class="col-md-6">
            <p><strong>Parent Name:</strong> <?= $data['parent_name'] ?></p>
            <p><strong>Relationship:</strong> <?= $data['relationship'] ?></p>
            <p><strong>Phone:</strong> <?= $data['contact'] ?></p>
            <p><strong>Email:</strong> <?= $data['email'] ?></p>
        </div>

        <div class="col-12 mt-3">
            <p><strong>Previous School:</strong> <?= $data['previous_school'] ?></p>
            <p><strong>Address:</strong> <?= nl2br($data['address']) ?></p>
        </div>

        <div class="col-12 mt-3">
            <p><strong>Status:</strong> 
                <span class="badge bg-primary"><?= $data['status'] ?></span>
                <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-warning btn-sm ms-3"><i class="fa-solid fa-edit"></i> Edit Status</a>
            </p>
        </div>

        <p><strong>Date Applied:</strong> <?= $data['date_applied'] ?></p>
    </div>
</div>

</body>
</html>
