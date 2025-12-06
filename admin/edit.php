<?php
session_start();
require_once("../backend/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM admissions WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $status = $_POST['status'];
    mysqli_query($conn, "UPDATE admissions SET status='$status', updated_at=NOW() WHERE id=$id");
    header("Location: view-details.php?id=$id&updated=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Status</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<a href="view-details.php?id=<?= $id ?>" class="btn btn-secondary mb-3">⬅ Back</a>

<div class="card shadow p-4" style="max-width: 500px;">
    <h4 class="fw-bold mb-3">Update Status</h4>

    <form method="POST">
        <label class="form-label">Status:</label>
        <select name="status" class="form-select">
            <option <?= $data['status']=="New"?"selected":"" ?>>New</option>
            <option <?= $data['status']=="In Review"?"selected":"" ?>>In Review</option>
            <option <?= $data['status']=="Approved"?"selected":"" ?>>Approved</option>
            <option <?= $data['status']=="Rejected"?"selected":"" ?>>Rejected</option>
        </select>

        <button class="btn btn-primary mt-3 w-100">Update</button>
    </form>
</div>
</body>
</html>
