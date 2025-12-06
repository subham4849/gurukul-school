<?php
session_start();
include_once '../backend/db.php';

// ===================== 1. UPLOAD IMAGE LOGIC =====================
if (isset($_POST['upload_image'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    // Safety check for admin ID
    $uploaded_by = isset($_SESSION['admin_id']) ? intval($_SESSION['admin_id']) : "NULL";

    $target_dir = "../assets/images/gallery/";

    // Create folder if not exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];

    if (!in_array($file_ext, $allowed)) {
        $error_msg = "Only JPG, PNG, GIF, WEBP allowed.";
    } else {
        $new_filename = uniqid() . "." . $file_ext;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Path to store in DB
            $db_path = "assets/images/gallery/" . $new_filename;

            // Default status is 'visible'
            $sql = "INSERT INTO gallery (title, description, image_path, category, uploaded_by, uploaded_at, status)
                    VALUES ('$title','$description','$db_path','$category',$uploaded_by,NOW(),'visible')";

            if ($conn->query($sql)) {
                $success_msg = "Image uploaded successfully!";
            } else {
                $error_msg = "Database Error: " . $conn->error;
            }
        } else {
            $error_msg = "File upload failed.";
        }
    }
}

// ===================== 2. DELETE LOGIC =====================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $result = $conn->query("SELECT image_path FROM gallery WHERE id=$id");

    if ($result && $row = $result->fetch_assoc()) {
        $filePath = "../" . $row['image_path'];
        if (file_exists($filePath)) unlink($filePath);
        $conn->query("DELETE FROM gallery WHERE id=$id");
        
        // Redirect to refresh page cleanly
        echo "<script>window.location.href='manage-gallery.php?msg=deleted';</script>";
        exit();
    }
}

// ===================== 3. TOGGLE STATUS (FIXED) =====================
if (isset($_GET['toggle_status'])) {
    $id = intval($_GET['toggle_status']);
    
    // Check current status
    $res = $conn->query("SELECT status FROM gallery WHERE id=$id");
    if ($res && $row = $res->fetch_assoc()) {
        // Trim removes spaces, strtolower handles 'Visible' vs 'visible'
        $current = strtolower(trim($row['status']));
        
        // If it looks like 'visible' (or truncated 'visibl'), hide it. Otherwise show it.
        if ($current == 'visible' || $current == 'visibl') {
            $new_status = 'hidden';
        } else {
            $new_status = 'visible';
        }

        $conn->query("UPDATE gallery SET status='$new_status' WHERE id=$id");
    }
    
    // JavaScript Redirect (Smoother than header sometimes)
    echo "<script>window.location.href='manage-gallery.php?msg=updated';</script>";
    exit();
}

// Messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'updated') $success_msg = "Status updated successfully.";
    if ($_GET['msg'] == 'deleted') $success_msg = "Image deleted successfully.";
}

// ===================== 4. FETCH DATA =====================
$images_result = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Gallery Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        body { background: #eef2fc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .img-thumbnail-custom { width: 80px; height: 60px; object-fit: cover; border-radius: 6px; }
        .table-responsive { overflow-x: auto; }
        /* Badge Styles */
        .status-visible { background-color: #198754; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; }
        .status-hidden { background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark m-0"><i class="fas fa-images text-primary"></i> Gallery Management</h2>
            <a href="dashboard.php" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i>Dashboard</a>
        </div>

        <?php if (isset($success_msg)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?php echo $success_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $error_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Upload New Image</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Image Title</label>
                            <input class="form-control" type="text" name="title" required placeholder="Enter title">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="events">Events</option>
                                <option value="sports">Sports</option>
                                <option value="cultural">Cultural</option>
                                <option value="academics">Academics</option>
                                <option value="infrastructure">Infrastructure</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter description (optional)" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Select Image</label>
                            <input class="form-control" type="file" required name="image" accept="image/*">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success px-4" name="upload_image">
                                <i class="fas fa-upload me-2"></i>Upload Image
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Manage Uploaded Images</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive p-3">
                    <table id="galleryTable" class="table table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Preview</th>
                                <th>Details</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $images_result->fetch_assoc()): ?>
                            <?php 
                                // Logic to handle 'visible', 'Visible', 'visibl' (truncated)
                                $status_raw = strtolower(trim($row['status']));
                                $is_visible = ($status_raw == 'visible' || $status_raw == 'visibl');
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                
                                <td>
                                    <img src="../<?php echo $row['image_path']; ?>" class="img-thumbnail-custom" alt="img">
                                </td>
                                
                                <td>
                                    <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                                </td>
                                
                                <td>
                                    <span class="badge bg-info text-dark"><?php echo ucfirst($row['category']); ?></span>
                                </td>
                                
                                <td class="small text-muted">
                                    <?php echo date('d M Y', strtotime($row['uploaded_at'])); ?>
                                </td>
                                
                                <td>
                                    <?php if($is_visible): ?>
                                        <span class="status-visible">Visible</span>
                                    <?php else: ?>
                                        <span class="status-hidden">Hidden</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-end">
                                    <a href="?toggle_status=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm <?php echo $is_visible ? 'btn-warning' : 'btn-success'; ?>"
                                       title="<?php echo $is_visible ? 'Hide Image' : 'Show Image'; ?>">
                                        <i class="fas fa-<?php echo $is_visible ? 'eye-slash' : 'eye'; ?>"></i>
                                        <?php echo $is_visible ? 'Hide' : 'Show'; ?>
                                    </a>

                                    <a href="?delete=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-danger ms-1" 
                                       onclick="return confirm('Are you sure you want to delete this image permanently?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function(){
        $('#galleryTable').DataTable({
            "order": [[ 0, "desc" ]], // Newest first
            "pageLength": 10
        });
    });
    </script>

</body>
</html>