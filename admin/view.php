<?php
session_start();
require_once("../backend/db.php");

// Ensure admin login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search feature
$search = $_GET['search'] ?? "";

// Query with search
$query = "SELECT * FROM admissions WHERE student_name LIKE '%$search%' OR class LIKE '%$search%' ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

// Count total records for pagination
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM admissions");
$totalRows = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admission Records | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body { background-color: #f5f7fa; }
        .badge-new { background:#ffcd29; color:#000; }
        .badge-review { background:#74aaff; }
        .badge-approved { background:#4caf50; }
        .badge-rejected { background:#e63946; }
        .table-hover tbody tr:hover { background: #eef4ff; cursor:pointer; }
    </style>
</head>
<body class="p-4">

<div class="container">

    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Admission Submissions</h3>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>

    <!-- Search -->
    <form class="input-group mb-3" method="GET">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search student or class...">
        <button class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
       <a href="export.php" class="btn btn-success ms-2">
    <i class="fa-solid fa-file-export"></i> Export CSV
</a>

    </form>

    <!-- Table -->
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php if(mysqli_num_rows($result) > 0) : ?>
                    <?php while($row = mysqli_fetch_assoc($result)) : ?>

                        <tr>
                            <td>#ADM-<?= str_pad($row['id'], 4, "0", STR_PAD_LEFT); ?></td>
                            <td><strong><?= $row['student_name']; ?></strong></td>
                            <td><?= $row['class']; ?></td>
                            <td><?= $row['date_applied']; ?></td>

                            <td>
                                <?php
                                $status = strtolower($row['status']);
                                echo match($status) {
                                    "new" => "<span class='badge badge-new'>New</span>",
                                    "in review" => "<span class='badge badge-review'>In Review</span>",
                                    "approved" => "<span class='badge badge-approved'>Approved</span>",
                                    "rejected" => "<span class='badge badge-rejected'>Rejected</span>",
                                    default => "<span class='badge bg-secondary'>Unknown</span>"
                                };
                                ?>
                            </td>

                            <td class="text-end">
                                <a href="view-details.php?id=<?= $row['id']; ?>" class="text-primary me-3"><i class="fa-solid fa-eye"></i></a>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="text-warning me-3"><i class="fa-solid fa-pen"></i></a>
                                <a href="delete.php?id=<?= $row['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                    <?php endwhile; ?>
                <?php else : ?>
                    <tr><td colspan="6" class="text-center text-danger py-3">No records found</td></tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav class="mt-3">
        <ul class="pagination justify-content-end">
            <li class="page-item <?= $page <= 1 ? 'disabled':'' ?>">
                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= $search ?>">Previous</a>
            </li>

            <li class="page-item <?= $page >= $totalPages ? 'disabled':'' ?>">
                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= $search ?>">Next</a>
            </li>
        </ul>
    </nav>

</div>

</body>
</html>
