<?php
// Include database connection
include_once 'backend/db.php';

// Fetch all achievements
$sql = "SELECT * FROM achievements ORDER BY achievement_date DESC";
$result = $conn->query($sql);

$achievements = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $achievements[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall of Fame - Gurukul Public School</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
       * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Inter", sans-serif;
    background: linear-gradient(140deg, #0047ff, #009dff, #00eaff);
    color: #0f172a;
    min-height: 100vh;
    overflow-x: hidden;
}

/* ---------------- HEADER ---------------- */

.header-section {
    background: linear-gradient(90deg, #0047ff, #009dff);
    padding: 4rem 0 3rem;
    text-align: center;
    color: white;
    border-bottom-left-radius: 30px;
    border-bottom-right-radius: 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.header-section h1 {
    font-size: 3rem;
    font-weight: 900;
    text-shadow: 0px 4px 15px rgba(0,0,0,0.2);
}

.header-section p {
    font-size: 1.2rem;
    opacity: 0.9;
}

/* ---------------- BACK BUTTON ---------------- */

.back-button {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    color: white;
    transition: 0.3s;
    text-decoration: none;
}

.back-button:hover {
    transform: translateX(-5px);
    background: rgba(255,255,255,0.4);
}

/* ---------------- FILTER BUTTONS ---------------- */

.filter-section {
    background: white;
    border-radius: 30px;
    padding: 1.8rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    margin-bottom: 3rem;
}

.filter-btn {
    background: #f1f5f9;
    border: none;
    padding: 0.7rem 1.5rem;
    border-radius: 30px;
    margin: 0.4rem;
    font-weight: 600;
    color: #0f172a;
    transition: 0.3s ease;
}

.filter-btn:hover {
    background: #e2e8f0;
}

.filter-btn.active {
    background: linear-gradient(90deg,#0047ff,#009dff);
    color: white !important;
    box-shadow: 0 6px 15px rgba(0,72,255,0.4);
    transform: scale(1.05);
}

/* ---------------- ACHIEVEMENT CARD ---------------- */

.achievement-card {
    background: white;
    border-radius: 25px;
    overflow: hidden;
    transition: 0.35s ease-in-out;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.achievement-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 18px 40px rgba(0,0,0,0.15);
}

.card-image-wrapper {
    height: 230px;
    position: relative;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .5s;
}

.achievement-card:hover .card-image {
    transform: scale(1.08);
}

.category-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255,255,255,0.85);
    padding: 8px 15px;
    border-radius: 20px;
    font-size: .75rem;
    font-weight: 700;
    color: #1e293b;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
}

/* ---------------- CONTENT ---------------- */

.card-content {
    padding: 1.8rem;
}

.achievement-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.4;
}

.achievement-meta {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
}

.event-info {
    font-size: 0.9rem;
    color: #64748b;
}

.year-badge {
    background: #ffe15d;
    padding: 6px 14px;
    font-size: 0.9rem;
    border-radius: 12px;
    font-weight: bold;
}

/* ---------------- NO RESULTS ---------------- */

.no-results {
    padding: 4rem;
    text-align: center;
    color: #475569;
}

.no-results i {
    font-size: 4rem;
    opacity: 0.4;
}

/* ---------------- FOOTER ---------------- */

.footer-section {
    background: #ffffff;
    padding: 2rem;
    margin-top: 4rem;
    border-top: 1px solid #e2e8f0;
}

.footer-links a {
    color: #0f172a;
    font-weight: 600;
    margin: 0 15px;
    transition: 0.3s;
}

.footer-links a:hover {
    color: #0078ff;
}

@media(max-width:768px){
    .header-section h1 {
        font-size: 2rem;
    }
}
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.html" class="back-button">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
            <h1>Gurukul Public School Hall of Fame</h1>
            <p>Celebrating the outstanding achievements of our students and faculty.</p>
        </div>
    </div>

    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section" data-aos="fade-up">
            <div class="text-center">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-trophy me-2"></i>All
                </button>
                <button class="filter-btn" data-filter="Academics">
                    <i class="fas fa-graduation-cap me-2"></i>Academics
                </button>
                <button class="filter-btn" data-filter="Sports">
                    <i class="fas fa-running me-2"></i>Sports
                </button>
                <button class="filter-btn" data-filter="Arts & Culture">
                    <i class="fas fa-palette me-2"></i>Arts & Culture
                </button>
                <button class="filter-btn" data-filter="Community">
                    <i class="fas fa-hands-helping me-2"></i>Community
                </button>
            </div>
        </div>

        <!-- Achievements Grid -->
        <div class="achievements-grid" id="achievementsGrid">
            <?php foreach ($achievements as $index => $achievement): ?>
            <div class="achievement-card" data-category="<?php echo $achievement['category']; ?>" 
                 data-aos="zoom-in" data-aos-delay="<?php echo $index * 100; ?>">
                <div class="card-image-wrapper">
                    <span class="category-badge"><?php echo strtoupper($achievement['category']); ?></span>
                    <img src="<?php echo $achievement['image_path']; ?>" class="card-image" alt="<?php echo $achievement['title']; ?>">
                </div>
                <div class="card-content">
                    <h3 class="achievement-title"><?php echo $achievement['title']; ?></h3>
                    <div class="achievement-meta">
                        <span class="event-info">
                            <?php 
                            if (!empty($achievement['description'])) {
                                echo "Event: " . substr($achievement['description'], 0, 30) . "...";
                            } else {
                                echo "Achievement";
                            }
                            ?>
                        </span>
                        <span class="year-badge"><?php echo date('Y', strtotime($achievement['achievement_date'])); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            <i class="fas fa-search"></i>
            <h3>No achievements found</h3>
            <p>Try selecting a different category</p>
        </div>

        <!-- Load More Button -->
        <div class="load-more-section" id="loadMoreSection" style="display: none;">
            <button class="load-more-btn" id="loadMoreBtn">
                <i class="fas fa-chevron-down me-2"></i> Load More
            </button>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <p><i class="fas fa-school me-2"></i>© <?php echo date('Y'); ?> Gurukul Public School. All Rights Reserved.</p>
                <div class="footer-links">
                    <a href="privacy.php">Privacy Policy</a>
                    <a href="terms.php">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        let currentFilter = 'all';
        const itemsPerPage = 6;
        let currentPage = 1;

        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                currentPage = 1;
                filterAchievements();
            });
        });

        function filterAchievements() {
            const cards = document.querySelectorAll('.achievement-card');
            const noResults = document.getElementById('noResults');
            let visibleCount = 0;
            let totalMatching = 0;

            cards.forEach((card, index) => {
                const category = card.getAttribute('data-category');
                const matches = currentFilter === 'all' || category === currentFilter;
                
                if (matches) {
                    totalMatching++;
                    if (totalMatching <= itemsPerPage * currentPage) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';

            // Show/hide load more button
            const loadMoreSection = document.getElementById('loadMoreSection');
            loadMoreSection.style.display = totalMatching > itemsPerPage * currentPage ? 'block' : 'none';
        }

        // Load more functionality
        document.getElementById('loadMoreBtn').addEventListener('click', function() {
            currentPage++;
            filterAchievements();
            
            // Smooth scroll to new items
            setTimeout(() => {
                const cards = document.querySelectorAll('.achievement-card[style="display: block;"]');
                const lastVisibleCard = cards[cards.length - 1];
                if (lastVisibleCard) {
                    lastVisibleCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 100);
        });

        // Initial setup
        filterAchievements();

        // Add click animation to cards
        document.querySelectorAll('.achievement-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });
    </script>

</body>
</html>