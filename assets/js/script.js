// Gurukul Academy Website JavaScript

// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Close mobile menu after clicking
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        }
    });
});

// Navbar background change on scroll
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('shadow');
    } else {
        navbar.classList.remove('shadow');
    }
});

// Counter Animation for Stats
function animateCounter(element, target) {
    let current = 0;
    const increment = target / 100;
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target + '+';
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current) + '+';
        }
    }, 20);
}

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.2,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            
            // Animate counters when stats section is visible
            if (entry.target.classList.contains('stats-section')) {
                const counters = entry.target.querySelectorAll('.stat-card h2');
                counters.forEach((counter, index) => {
                    const targets = [500, 50, 15, 50];
                    setTimeout(() => {
                        animateCounter(counter, targets[index]);
                    }, index * 200);
                });
                observer.unobserve(entry.target);
            }
        }
    });
}, observerOptions);

// Observe sections for animation
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        observer.observe(section);
    });
    
    // Animate cards on load
    const cards = document.querySelectorAll('.facility-card, .testimonial-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }, index * 100);
    });
});

// Change hero background image (if needed)
function changeHeroImage(imageUrl) {
    const heroSection = document.querySelector('.hero-section');
    heroSection.style.backgroundImage = `url('${imageUrl}')`;
}
changeHeroImage("assets/images/gallery/banner.jpg");


// Function to update admission banner
function updateAdmissionBanner(title, subtitle, imageUrl) {
    const heroTitle = document.querySelector('.hero-content h1');
    const heroSubtitle = document.querySelector('.hero-content p');
    const heroSection = document.querySelector('.hero-section');
    
    if (heroTitle) heroTitle.textContent = title;
    if (heroSubtitle) heroSubtitle.textContent = subtitle;
    if (imageUrl) heroSection.style.backgroundImage = `url('${imageUrl}')`;
}

// Example: How to change the hero image
// Uncomment and modify the URL to change the admission banner
// changeHeroImage('your-image-url.jpg');

// Example: How to update admission banner text
// updateAdmissionBanner('New Admission Open!', 'Join us for excellence', 'new-image.jpg');

// Add active class to current nav item
const currentLocation = window.location.hash;
if (currentLocation) {
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentLocation) {
            link.classList.add('active');
        }
    });
}

// Form validation (if you add a contact form later)
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form validation logic here
            console.log('Form submitted successfully!');
        });
    }
}

// Lazy loading for images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('fade-in');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Back to top button functionality
const backToTopBtn = document.createElement('button');
backToTopBtn.innerHTML = '↑';
backToTopBtn.className = 'btn btn-primary position-fixed bottom-0 end-0 m-4 rounded-circle';
backToTopBtn.style.width = '50px';
backToTopBtn.style.height = '50px';
backToTopBtn.style.display = 'none';
backToTopBtn.style.zIndex = '1000';
backToTopBtn.style.fontSize = '1.5rem';
document.body.appendChild(backToTopBtn);

window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        backToTopBtn.style.display = 'block';
    } else {
        backToTopBtn.style.display = 'none';
    }
});

backToTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Console welcome message
console.log('%c Welcome to Gurukul Public School Website! ', 'background: #0d6efd; color: white; font-size: 16px; padding: 10px;');
console.log('Developed with ❤️ for education');




// ---- ADMISSION PAGE SCRIPT ----

document.addEventListener("DOMContentLoaded", () => {

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Navbar scroll shadow effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('shadow', window.scrollY > 50);
        });
    }

    // Form handling
    const admissionForm = document.getElementById('admissionForm');

    if (admissionForm) {
        admissionForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                showErrorMessage("Please fill all required fields correctly.");
                return;
            }

            const submitBtn = admissionForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerText = "Submitting...";

            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerText = "Submit";
                admissionForm.reset();
                showSuccessMessage();
            }, 1500);
        });
    }

    // Phone number formatting
    const phoneInput = document.querySelector('input[type="tel"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', e => {
            let value = e.target.value.replace(/\D/g, '').slice(0, 10);
            e.target.value = value.replace(/(\d{3})(\d{3})(\d{1,4})/, "$1-$2-$3");
        });
    }

    // Back to top button
    let backToTopBtn = document.querySelector('.back-to-top-btn');
    if (!backToTopBtn) {
        backToTopBtn = document.createElement("button");
        backToTopBtn.className = "btn btn-primary position-fixed bottom-0 end-0 m-4 rounded-circle back-to-top-btn";
        backToTopBtn.innerText = "↑";
        backToTopBtn.style.display = "none";
        document.body.appendChild(backToTopBtn);
    }

    window.addEventListener("scroll", () => {
        backToTopBtn.style.display = window.scrollY > 300 ? "block" : "none";
    });

    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    console.log("%c Gurukul Public School - Admission Form Active", "background:#0d6efd;color:white;padding:6px;border-radius:4px;");

}); // END DOMContentLoaded

// ---- FUNCTIONS ----

function validateForm() {
    const form = document.getElementById("admissionForm");
    if (!form) return false;

    let valid = true;

    form.querySelectorAll("input[required], select[required], textarea[required]").forEach(field => {
        if (!field.value.trim()) {
            field.classList.add("is-invalid");
            valid = false;
        } else {
            field.classList.remove("is-invalid");
        }
    });

    return valid;
}

function showSuccessMessage() {
    alert("🎉 Form submitted successfully!");
}

function showErrorMessage(message) {
    alert("❌ " + message);
}




//dashboard script 
// Dashboard JavaScript

let currentApplicationId = null;
let admissionsData = [];

// Toggle Sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}

// Show Section
function showSection(sectionName) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });

    // Remove active class from all menu items
    document.querySelectorAll('.sidebar-menu li').forEach(item => {
        item.classList.remove('active');
    });

    // Show selected section
    const targetSection = document.getElementById(sectionName + '-section');
    if (targetSection) {
        targetSection.classList.add('active');
    }

    // Add active class to menu item
    const menuItems = document.querySelectorAll('.sidebar-menu li a');
    menuItems.forEach(item => {
        if (item.textContent.toLowerCase().includes(sectionName)) {
            item.parentElement.classList.add('active');
        }
    });

    // Load data for specific sections
    if (sectionName === 'admissions') {
        loadAdmissions();
    }

    // Close sidebar on mobile
    if (window.innerWidth <= 992) {
        document.getElementById('sidebar').classList.remove('active');
    }
}

// Load Admissions from API
async function loadAdmissions() {
    try {
        const response = await fetch('get-admissions.php');
        const data = await response.json();
        
        if (data.success) {
            admissionsData = data.admissions;
            displayAdmissions(admissionsData);
            updateStats(admissionsData);
            displayRecentAdmissions(admissionsData.slice(0, 5));
        } else {
            showError('Failed to load admissions');
        }
    } catch (error) {
        console.error('Error loading admissions:', error);
        // Show sample data for demonstration
        loadSampleData();
    }
}

// Load Sample Data (for demonstration)
function loadSampleData() {
    admissionsData = [
        {
            id: 1,
            student_name: 'Rahul Sharma',
            parent_name: 'Rajesh Sharma',
            class: 'Grade V',
            contact: '+91 98765 43210',
            email: 'rajesh@example.com',
            date_applied: '2024-12-01',
            status: 'pending'
        },
        {
            id: 2,
            student_name: 'Priya Patel',
            parent_name: 'Amit Patel',
            class: 'Grade III',
            contact: '+91 98765 43211',
            email: 'amit@example.com',
            date_applied: '2024-12-02',
            status: 'approved'
        },
        {
            id: 3,
            student_name: 'Arjun Kumar',
            parent_name: 'Suresh Kumar',
            class: 'Grade VII',
            contact: '+91 98765 43212',
            email: 'suresh@example.com',
            date_applied: '2024-12-03',
            status: 'pending'
        },
        {
            id: 4,
            student_name: 'Ananya Singh',
            parent_name: 'Vikram Singh',
            class: 'Grade II',
            contact: '+91 98765 43213',
            email: 'vikram@example.com',
            date_applied: '2024-12-04',
            status: 'rejected'
        },
        {
            id: 5,
            student_name: 'Rohan Mehta',
            parent_name: 'Nitin Mehta',
            class: 'Grade IV',
            contact: '+91 98765 43214',
            email: 'nitin@example.com',
            date_applied: '2024-12-05',
            status: 'pending'
        }
    ];
    
    displayAdmissions(admissionsData);
    updateStats(admissionsData);
    displayRecentAdmissions(admissionsData.slice(0, 5));
}

// Display Admissions in Table
function displayAdmissions(data) {
    const tbody = document.getElementById('admissionsTableBody');
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No applications found</td></tr>';
        return;
    }
    
    tbody.innerHTML = data.map(app => `
        <tr>
            <td>#${app.id}</td>
            <td><strong>${app.student_name}</strong></td>
            <td>${app.parent_name}</td>
            <td>${app.class}</td>
            <td>${app.contact}</td>
            <td>${formatDate(app.date_applied)}</td>
            <td><span class="status-badge ${app.status}">${capitalize(app.status)}</span></td>
            <td>
                <div class="action-buttons">
                    <button class="btn-action btn-view" onclick="viewApplication(${app.id})">View</button>
                    ${app.status === 'pending' ? `
                        <button class="btn-action btn-approve" onclick="quickUpdateStatus(${app.id}, 'approved')">Approve</button>
                        <button class="btn-action btn-reject" onclick="quickUpdateStatus(${app.id}, 'rejected')">Reject</button>
                    ` : ''}
                </div>
            </td>
        </tr>
    `).join('');
}

// Display Recent Admissions
function displayRecentAdmissions(data) {
    const tbody = document.getElementById('recentAdmissionsTable');
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No recent applications</td></tr>';
        return;
    }
    
    tbody.innerHTML = data.map(app => `
        <tr>
            <td><strong>${app.student_name}</strong></td>
            <td>${app.class}</td>
            <td>${formatDate(app.date_applied)}</td>
            <td><span class="status-badge ${app.status}">${capitalize(app.status)}</span></td>
        </tr>
    `).join('');
}

// Update Statistics
function updateStats(data) {
    const totalAdmissions = data.length;
    const pendingAdmissions = data.filter(app => app.status === 'pending').length;
    
    document.getElementById('totalAdmissions').textContent = totalAdmissions;
    document.getElementById('pendingAdmissions').textContent = pendingAdmissions;
}

// View Application Details
function viewApplication(id) {
    const application = admissionsData.find(app => app.id === id);
    if (!application) return;
    
    currentApplicationId = id;
    
    const modalBody = document.getElementById('applicationDetailsBody');
    modalBody.innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <h6 class="text-muted">Student Information</h6>
                <p><strong>Name:</strong> ${application.student_name}</p>
                <p><strong>Class Applying For:</strong> ${application.class}</p>
                <p><strong>Date of Birth:</strong> ${application.dob || 'N/A'}</p>
                <p><strong>Gender:</strong> ${application.gender || 'N/A'}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Parent Information</h6>
                <p><strong>Parent Name:</strong> ${application.parent_name}</p>
                <p><strong>Contact:</strong> ${application.contact}</p>
                <p><strong>Email:</strong> ${application.email}</p>
                <p><strong>Address:</strong> ${application.address || 'N/A'}</p>
            </div>
            <div class="col-12">
                <h6 class="text-muted">Application Details</h6>
                <p><strong>Application ID:</strong> #${application.id}</p>
                <p><strong>Date Applied:</strong> ${formatDate(application.date_applied)}</p>
                <p><strong>Previous School:</strong> ${application.previous_school || 'Not Applicable'}</p>
                <p><strong>Status:</strong> <span class="status-badge ${application.status}">${capitalize(application.status)}</span></p>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('viewApplicationModal'));
    modal.show();
}

// Quick Update Status
async function quickUpdateStatus(id, status) {
    if (!confirm(`Are you sure you want to ${status} this application?`)) {
        return;
    }
    
    try {
        const response = await fetch('update-admission-status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, status })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showSuccess(`Application ${status} successfully`);
            loadAdmissions();
        } else {
            showError('Failed to update status');
        }
    } catch (error) {
        console.error('Error updating status:', error);
        // For demonstration, update locally
        const appIndex = admissionsData.findIndex(app => app.id === id);
        if (appIndex !== -1) {
            admissionsData[appIndex].status = status;
            displayAdmissions(admissionsData);
            updateStats(admissionsData);
            displayRecentAdmissions(admissionsData.slice(0, 5));
            showSuccess(`Application ${status} successfully`);
        }
    }
}

// Update Status from Modal
function updateStatus(status) {
    if (!currentApplicationId) return;
    quickUpdateStatus(currentApplicationId, status);
    bootstrap.Modal.getInstance(document.getElementById('viewApplicationModal')).hide();
}

// Search Functionality
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const filtered = admissionsData.filter(app => 
        app.student_name.toLowerCase().includes(searchTerm) ||
        app.parent_name.toLowerCase().includes(searchTerm) ||
        app.contact.includes(searchTerm)
    );
    displayAdmissions(filtered);
});

// Filter by Status
document.getElementById('statusFilter')?.addEventListener('change', function(e) {
    const status = e.target.value;
    const filtered = status ? admissionsData.filter(app => app.status === status) : admissionsData;
    displayAdmissions(filtered);
});

// Utility Functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function showSuccess(message) {
    showNotification(message, 'success');
}

function showError(message) {
    showNotification(message, 'danger');
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}

// Initialize Dashboard
document.addEventListener('DOMContentLoaded', function() {
    loadAdmissions();
    
    // Animate stats on load
    setTimeout(() => {
        document.querySelectorAll('.stat-card').forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 100);
        });
    }, 100);
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    if (window.innerWidth <= 992) {
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        
        if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.remove('active');
        }
    }
});

console.log('%c Gurukul Academy Admin Dashboard ', 'background: #667eea; color: white; font-size: 16px; padding: 10px;');