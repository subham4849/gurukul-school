<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Gurukul School</title>
    <link rel="icon" type="image/png"href="../assets/imges/icon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            height: 100vh;
            background-color: #f1f3f4;
        }
        .sidebar {
            width: 250px;
            background: #0d6efd;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            display: block;
            font-size: 16px;
            margin: 15px 0;
        }
        .sidebar a:hover {
            background: #084298;
            padding-left: 10px;
            border-radius: 5px;
        }
        .content {
            flex-grow: 1;
            padding: 25px;
        }
        .card:hover{
            transform: scale(1.02);
            transition: 0.3s;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center mb-4">Admin Panel</h3>
        
        <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="manage-gallery.php"><i class="fa-solid fa-image"></i> Manage Gallery</a>
        <a href="manage-achievement.php"><i class="fa-solid fa-trophy"></i> Achievements</a>
        <a href="view.php"><i class="fa-solid fa-list-check"></i> Admission Entries</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">

       <h2 class="fw-bold">Welcome back, <?php echo $_SESSION['admin']; ?> 👋</h2>

        <p class="text-muted">Manage your school website content easily.</p>

        <!-- Cards -->
        <div class="row mt-4">

            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h5><i class="fa-solid fa-image"></i> Gallery Upload</h5>
                    <p class="text-muted">Add or delete photos for school website gallery.</p>
                    <a href="manage-gallery.php" class="btn btn-primary btn-sm">Open</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h5><i class="fa-solid fa-trophy"></i> Achievements</h5>
                    <p class="text-muted">Update academic or sports achievements.</p>
                    <a href="manage-achievement.php" class="btn btn-warning btn-sm">Update</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h5><i class="fa-solid fa-users"></i> Admissions</h5>
                    <p class="text-muted">Review admission forms submitted by students.</p>
                    <a href="view.php" class="btn btn-success btn-sm">View Data</a>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
