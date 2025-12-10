# Gurukul Public School Website

A comprehensive, responsive school management website built for Gurukul Public School. This project serves as the digital front for the institution, providing information to parents and students, while offering an administrative panel for dynamic content management.

## 📂 Directory Structure

```
gurukul-school/
├── assets/                 # Static assets
│   ├── css/               # Stylesheets (style.css)
│   ├── images/            # Logo, banners, facility images
│   └── js/                # Custom JavaScript files
├── admin/                  # Admin Dashboard & CMS
│   ├── login.php          # Admin authentication
│   ├── dashboard.php      # Main control panel
│   └── manage-*.php       # CRUD for achievements, gallery
├── backend/                # Server-side logic
│   ├── db.php             # Database connection
│   └── login-process.php  # Auth processing
├── uploads/                # Dynamic uploads (gallery/achievements)
├── index.html              # Homepage
├── about.html              # About Us page
├── transport.html          # Transport details
├── hostel.html             # Hostel facilities
├── contact.html            # Contact form
└── ...other static pages
```

## 🛠️ Technologies Used

### Frontend
- **HTML5**: Semantic markup for structure.
- **CSS3 & Bootstrap 5**: Responsive design, grid system, and styling.
- **JavaScript**: Client-side interactions and Bootstrap components.

### Backend
- **PHP**: Core server-side scripting language.
- **Session Management**: Secure admin sessions for the dashboard.
- **File Handling**: Upload functionality for gallery images and achievement documents.

### Database
- **MySQL**: Relational database management system.
- **Connection**: `backend/db.php` manages the connection using standard PHP MySQLi/PDO extensions.
- **Tables**: Stores data for:
    - User/Admin credentials
    - Contact inquiries
    - Achievements/News
    - Photo Gallery

## 🔄 Workflow

1.  **Public Access**:
    -   Visitors browse the fully responsive website to view school details, hostel/transport facilities, and admission info.
    -   **Dynamic Pages**: Pages like `achievements.php` and `gallery.php` fetch real-time data from the MySQL database to display the latest updates.

2.  **Inquiry System**:
    -   Parents use the Contact Form (`contact.html`).
    -   Data is posted to `submit.php`, sanitized, and stored in the database.

3.  **Administration**:
    -   Admins access the secure panel at `/admin`.
    -   **Login**: Authenticated via `backend/login-process.php`.
    -   **Dashboard**: Admins can:
        -   View and manage contact inquiries.
        -   Add/Edit/Delete Student Achievements.
        -   Upload photos to the School Gallery.
        -   Update News & Announcements.

## 🚀 Getting Started

1.  Import the database schema (if provided) into your MySQL server.
2.  Configure database credentials in `backend/db.php`.
3.  Deploy the folder to a PHP-enabled server (e.g., Apache/XAMPP).
