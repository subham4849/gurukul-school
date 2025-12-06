<?php
session_start();

// Include database connection (admin folder needs ../ to go up one level)
include_once '../backend/db.php';

// Handle Add Achievement
if (isset($_POST['add_achievement'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $achievement_date = mysqli_real_escape_string($conn, $_POST['achievement_date']);
    
    // File upload handling
    $target_dir = "../uploads/achievements/";
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'svg');
    
    if (in_array($file_extension, $allowed_types)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Save path without ../ for database so it works from any location
            $db_path = str_replace('../', '', $target_file);
            $sql = "INSERT INTO achievements (title, description, category, achievement_date, image_path) 
                    VALUES ('$title', '$description', '$category', '$achievement_date', '$db_path')";
            
            if ($conn->query($sql)) {
                $success_msg = "Achievement added successfully!";
            } else {
                $error_msg = "Database error: " . $conn->error;
            }
        } else {
            $error_msg = "Failed to upload image.";
        }
    } else {
        $error_msg = "Only JPG, JPEG, PNG, GIF & SVG files are allowed.";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    $result = $conn->query("SELECT image_path FROM achievements WHERE id = $id");
    if ($result && $row = $result->fetch_assoc()) {
        $image_path = $row['image_path'];
        
        if ($conn->query("DELETE FROM achievements WHERE id = $id")) {
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $success_msg = "Achievement deleted successfully!";
        }
    }
}

// Handle Edit
if (isset($_POST['edit_achievement'])) {
    $id = intval($_POST['achievement_id']);
    $title = mysqli_real_escape_string($conn, $_POST['edit_title']);
    $description = mysqli_real_escape_string($conn, $_POST['edit_description']);
    $category = mysqli_real_escape_string($conn, $_POST['edit_category']);
    $achievement_date = mysqli_real_escape_string($conn, $_POST['edit_achievement_date']);
    
    $sql = "UPDATE achievements SET title='$title', description='$description', 
            category='$category', achievement_date='$achievement_date' WHERE id=$id";
    
    if ($conn->query($sql)) {
        $success_msg = "Achievement updated successfully!";
    } else {
        $error_msg = "Update failed: " . $conn->error;
    }
}

// Fetch all achievements
$achievements_query = "SELECT * FROM achievements ORDER BY achievement_date DESC";
$achievements_result = $conn->query($achievements_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Achievements - Gurukul Public School</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f5f5f7;
            color: #1d1d1f;
        }

        .header-section {
            background: white;
            padding: 2rem 0;
            border-bottom: 1px solid #e5e5e7;
            margin-bottom: 2rem;
        }

        .header-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1d1d1f;
            margin-bottom: 0.5rem;
        }

        .header-section p {
            color: #86868b;
            font-size: 1.1rem;
        }

        .back-button {
            background: #f5f5f7;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            color: #1d1d1f;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #e8e8ed;
            transform: translateX(-5px);
        }

        .add-new-btn {
            background: #ffd60a;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            color: #1d1d1f;
            transition: all 0.3s ease;
        }

        .add-new-btn:hover {
            background: #ffc300;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 214, 10, 0.3);
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 3rem;
        }

        .add-form-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .add-form-section h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1d1d1f;
        }

        .form-label {
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border: 1px solid #d2d2d7;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0071e3;
            box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.1);
        }

        textarea.form-control {
            resize: none;
            min-height: 100px;
        }

        .upload-area {
            border: 2px dashed #d2d2d7;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .upload-area:hover {
            border-color: #0071e3;
            background: #f0f8ff;
        }

        .upload-area i {
            font-size: 2.5rem;
            color: #0071e3;
            margin-bottom: 0.5rem;
        }

        .upload-area p {
            color: #86868b;
            margin: 0.5rem 0 0;
            font-size: 0.875rem;
        }

        .btn-save {
            background: #0071e3;
            border: none;
            padding: 0.875rem;
            border-radius: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background: #0077ed;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 113, 227, 0.3);
        }

        .btn-clear {
            background: #f5f5f7;
            border: none;
            padding: 0.875rem;
            border-radius: 12px;
            font-weight: 600;
            color: #1d1d1f;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-clear:hover {
            background: #e8e8ed;
        }

        .existing-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .existing-section h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1d1d1f;
        }

        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-box input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 1px solid #d2d2d7;
            border-radius: 12px;
            font-size: 0.95rem;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #86868b;
        }

        .table-custom {
            margin-top: 1.5rem;
        }

        .table-custom thead {
            background: #f5f5f7;
            border-radius: 10px;
        }

        .table-custom th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            color: #1d1d1f;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-custom td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f5f5f7;
        }

        .achievement-photo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #f5f5f7;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }

        .btn-edit {
            background: #e8f4ff;
            color: #0071e3;
        }

        .btn-edit:hover {
            background: #0071e3;
            color: white;
        }

        .btn-delete {
            background: #ffe5e5;
            color: #ff3b30;
        }

        .btn-delete:hover {
            background: #ff3b30;
            color: white;
        }

        .preview-image {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 1rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }

        @media (max-width: 1024px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }

            .add-form-section {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body>

    <div class="header-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Manage Achievements</h1>
                    <p>Add, edit, or delete school achievements.</p>
                </div>
                <button class="back-button" onclick="window.history.back()">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($success_msg)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo $success_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="content-wrapper">
        <!-- Add New Achievement Form -->
        <div class="add-form-section">
            <h2>Add New Achievement</h2>
            <form method="POST" enctype="multipart/form-data" id="achievementForm">
                <div class="mb-3">
                    <label class="form-label">Achievement Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Science Olympiad Winner" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter a brief description of the achievement..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Achievement</label>
                    <input type="date" name="achievement_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        <option value="">Select Category</option>
                        <option value="Academics">Academics</option>
                        <option value="Sports">Sports</option>
                        <option value="Arts & Culture">Arts & Culture</option>
                        <option value="Community">Community</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Photo / Icon</label>
                    <div class="upload-area" onclick="document.getElementById('photoFile').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h6 class="mb-0">Click to upload or drag and drop</h6>
                        <p>PNG, JPG or SVG (MAX. 800x400px)</p>
                    </div>
                    <input type="file" name="photo" id="photoFile" accept="image/*" required style="display: none;" onchange="previewImage(event)">
                    <img id="imagePreview" class="preview-image" style="display: none;">
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <button type="submit" name="add_achievement" class="btn-save">
                            <i class="fas fa-save me-2"></i> Save Achi...
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="reset" class="btn-clear">Clear Form</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Existing Achievements -->
        <div class="existing-section">
            <h2>Existing Achievements</h2>
            
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by achievement title...">
            </div>

            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>PHOTO</th>
                            <th>TITLE</th>
                            <th>DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="achievementsTable">
                        <?php while ($row = $achievements_result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php 
                                // Fix image path for display
                                $display_path = str_replace('../', '', $row['image_path']);
                                if (!file_exists($row['image_path']) && file_exists('../' . $display_path)) {
                                    $display_path = '../' . $display_path;
                                } else {
                                    $display_path = $row['image_path'];
                                }
                                ?>
                                <img src="<?php echo $display_path; ?>" class="achievement-photo" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            </td>
                            <td>
                                <strong><?php echo $row['title']; ?></strong>
                            </td>
                            <td>
                                <?php echo date('M d, Y', strtotime($row['achievement_date'])); ?>
                            </td>
                            <td>
                                <button class="action-btn btn-edit" onclick="editAchievement(<?php echo htmlspecialchars(json_encode($row)); ?>)" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <a href="?delete=<?php echo $row['id']; ?>" class="action-btn btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this achievement?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header" style="background: #0071e3; color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Achievement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body p-4">
                        <input type="hidden" name="achievement_id" id="edit_achievement_id">
                        
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="edit_title" id="edit_title" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="edit_description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Achievement</label>
                            <input type="date" name="edit_achievement_date" id="edit_achievement_date" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="edit_category" id="edit_category" class="form-select" required>
                                <option value="Academics">Academics</option>
                                <option value="Sports">Sports</option>
                                <option value="Arts & Culture">Arts & Culture</option>
                                <option value="Community">Community</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <img id="edit_image_preview" src="" class="preview-image" style="max-height: 300px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_achievement" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        function editAchievement(data) {
            document.getElementById('edit_achievement_id').value = data.id;
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_description').value = data.description;
            document.getElementById('edit_category').value = data.category;
            document.getElementById('edit_achievement_date').value = data.achievement_date;
            document.getElementById('edit_image_preview').src = data.image_path;
            
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#achievementsTable tr');
            
            rows.forEach(row => {
                const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                row.style.display = title.includes(searchTerm) ? '' : 'none';
            });
        });

        // Auto dismiss alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

</body>
</html>