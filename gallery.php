<?php
// ==========================================
// 1. DATABASE CONNECTION (FIXED PATH)
// ==========================================
// Since gallery.php and the backend folder are in the same directory:
include_once 'backend/db.php'; 

// Fetch only VISIBLE images, newest first
$sql = "SELECT * FROM gallery WHERE status = 'visible' ORDER BY id DESC";
$result = $conn->query($sql);

// Get unique categories for filter buttons
$cat_sql = "SELECT DISTINCT category FROM gallery WHERE status = 'visible'";
$cat_result = $conn->query($cat_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Gallery - Gurukul Public School</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #00fbffff;
            --secondary-color: #1869ffff;
            --accent-color: #fbff07ff;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
        }

        /* --- Modern Header Section --- */
        .gallery-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 80px 0 60px;
            margin-bottom: 50px;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        /* Back Button Style */
        .back-btn {
            position: absolute;
            top: 25px;
            left: 25px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            font-weight: 500;
            border: 1px solid rgba(255,255,255,0.3);
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: white;
            color: var(--secondary-color);
            transform: translateX(-5px);
        }

        /* --- Filter Buttons --- */
        .filter-btn {
            border-radius: 50px;
            padding: 10px 30px;
            margin: 5px;
            border: none;
            color: #555;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(30, 60, 114, 0.2);
        }

        /* --- Gallery Grid --- */
        .gallery-item {
            margin-bottom: 30px;
            animation: fadeIn 0.6s ease-in-out;
        }

        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
            cursor: pointer;
            height: 100%;
            background: white;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .img-container {
            height: 260px;
            overflow: hidden;
            position: relative;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .card:hover .img-container img {
            transform: scale(1.15);
        }

        /* Stylish Overlay */
        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(30, 60, 114, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.4s ease;
            backdrop-filter: blur(2px);
        }

        .card:hover .overlay {
            opacity: 1;
        }

        .overlay-icon {
            color: white;
            font-size: 1.5rem;
            transform: translateY(20px);
            transition: all 0.4s ease;
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 50%;
        }

        .card:hover .overlay-icon {
            transform: translateY(0);
        }

        .card-body {
            padding: 20px;
        }

        .category-badge {
            background: rgba(30, 60, 114, 0.1);
            color: var(--secondary-color);
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* --- Modal (Lightbox) --- */
        #modalImage {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }
        .modal-content {
            background-color: transparent;
            border: none;
        }
        .close-modal {
            position: absolute;
            top: -50px;
            right: 0;
            color: white;
            font-size: 35px;
            cursor: pointer;
            z-index: 1000;
            transition: transform 0.3s;
        }
        .close-modal:hover { transform: rotate(90deg); color: var(--accent-color); }
        
        .modal-caption-box {
            background: white;
            padding: 25px;
            border-radius: 0 0 15px 15px;
            text-align: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="gallery-header">
        
        <a href="index.html" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="container text-center">
            <h1 class="fw-bold display-4 mb-2">Our Moments</h1>
            <p class="lead opacity-75">Capturing the spirit of Gurukul Public School</p>
            <div class="mt-3" style="width: 60px; height: 4px; background: var(--accent-color); margin: 0 auto; border-radius: 2px;"></div>
        </div>
    </div>

    <div class="container">
        
        <div class="text-center mb-5">
            <button class="filter-btn active" data-filter="all">All Photos</button>
            <?php 
            if($cat_result && $cat_result->num_rows > 0){
                while($cat = $cat_result->fetch_assoc()){
                    echo '<button class="filter-btn" data-filter="'.$cat['category'].'">'.ucfirst($cat['category']).'</button>';
                }
            }
            ?>
        </div>

        <div class="row g-4" id="gallery-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    
                    <?php 
                        // ==========================================
                        // IMAGE PATH CLEANER LOGIC
                        // ==========================================
                        $img_path = $row['image_path'];
                        $img_path = str_replace('../', '', $img_path);

                        if (strpos($img_path, 'assets/') === false) {
                            $img_path = 'assets/images/gallery/' . $img_path;
                        }
                    ?>

                    <div class="col-lg-4 col-md-6 gallery-item" data-category="<?php echo $row['category']; ?>">
                        <div class="card" onclick="openModal('<?php echo $img_path; ?>', '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['description']); ?>')">
                            
                            <div class="img-container">
                                <img src="<?php echo $img_path; ?>" alt="Gallery Image" loading="lazy">
                                <div class="overlay">
                                    <div class="overlay-icon">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body text-center">
                                <span class="category-badge"><?php echo $row['category']; ?></span>
                                <h5 class="card-title fw-bold text-dark mt-2 mb-0"><?php echo $row['title']; ?></h5>
                            </div>

                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <div class="mb-3"><i class="far fa-images fa-4x text-secondary opacity-25"></i></div>
                    <h3>No images found.</h3>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0 position-relative">
                    <span class="close-modal" data-bs-dismiss="modal">&times;</span>
                    <img src="" id="modalImage" alt="Full View">
                    <div class="modal-caption-box">
                         <h3 id="modalTitle" class="fw-bold mb-2 text-dark"></h3>
                         <p id="modalDesc" class="text-secondary m-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Filter Logic
        $(document).ready(function(){
            $('.filter-btn').click(function(){
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');

                var category = $(this).attr('data-filter');

                if(category == 'all'){
                    $('.gallery-item').fadeIn(400);
                } else {
                    $('.gallery-item').hide();
                    $('.gallery-item[data-category="'+category+'"]').fadeIn(400);
                }
            });
        });

        // 2. Modal Logic
        function openModal(src, title, desc) {
            var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
            document.getElementById('modalImage').src = src;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerText = desc;
            myModal.show();
        }
    </script>

</body>
</html>