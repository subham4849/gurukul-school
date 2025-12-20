<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gurukul Public School | Admin Portal</title>
    <link rel="icon" type="image/png" href="..assets/images/icon.png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #2d6ae3;
            --accent-color: #00c9a7;
            --gradient-primary: linear-gradient(135deg, #1a365d 0%, #2d6ae3 100%);
            --gradient-secondary: linear-gradient(135deg, #2d6ae3 0%, #00c9a7 100%);
            --light-bg: #f8fafc;
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 25px 70px rgba(45, 106, 227, 0.15);
        }
        .alert-danger {
    text-align: center;
    font-size: 14px;
}

        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            position: relative;
        }
        
        /* Decorative Background Elements */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .shape-1 {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: var(--gradient-primary);
            opacity: 0.03;
            top: -300px;
            left: -200px;
        }
        
        .shape-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: var(--gradient-secondary);
            opacity: 0.03;
            bottom: -200px;
            right: -100px;
        }
        
        .shape-3 {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 30px;
            background: var(--gradient-primary);
            opacity: 0.02;
            transform: rotate(45deg);
            top: 40%;
            right: 10%;
        }
        
        .shape-4 {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: var(--gradient-secondary);
            opacity: 0.03;
            bottom: 10%;
            left: 10%;
        }
        
        /* Main Container */
        .container-fluid {
            display: flex;
            width: 100%;
            min-height: 100vh;
            padding: 0;
        }
        
        /* Left Panel */
        .left-panel {
            flex: 1;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .left-panel::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }
        
        .academy-logo {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .logo-icon i {
            font-size: 28px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .academy-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }
        
        .academy-tagline {
            font-size: 18px;
            font-weight: 300;
            margin-bottom: 40px;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .left-panel-content {
            max-width: 500px;
            position: relative;
            z-index: 2;
        }
        
        .feature-list {
            list-style: none;
            margin-top: 60px;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            font-size: 16px;
        }
        
        .feature-list i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
        }
        
        /* Right Panel */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        
        .login-container {
            max-width: 480px;
            width: 100%;
        }
        
        .login-card {
            background: white;
            border-radius: 24px;
            padding: 50px;
            box-shadow: var(--card-shadow);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-secondary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 15px 30px rgba(0, 201, 167, 0.3);
        }
        
        .login-icon i {
            font-size: 36px;
            color: white;
        }
        
        .login-title {
            font-family: 'Montserrat', sans-serif;
            color: var(--primary-color);
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .login-subtitle {
            color: #64748b;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.6;
        }
        
        /* Form Styling */
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }
        
        .form-label {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 15px;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 10px;
            color: var(--secondary-color);
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon input {
            padding: 16px 20px 16px 55px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            width: 100%;
            background-color: #f8fafc;
        }
        
        .input-with-icon input:focus {
            border-color: var(--secondary-color);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(45, 106, 227, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            transition: color 0.3s;
        }
        
        .input-with-icon input:focus + .input-icon {
            color: var(--secondary-color);
        }
        
        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: var(--secondary-color);
        }
        
        /* Login Button */
        .btn-login {
            background: var(--gradient-secondary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 18px;
            font-weight: 600;
            font-size: 18px;
            width: 100%;
            transition: all 0.3s;
            margin-top: 20px;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 20px rgba(0, 201, 167, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 201, 167, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }
        
        .btn-login:hover::after {
            left: 100%;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #64748b;
            font-size: 14px;
            padding-top: 25px;
            border-top: 1px solid #f1f5f9;
        }
        
        .footer-logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: var(--primary-color);
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .container-fluid {
                flex-direction: column;
            }
            
            .left-panel {
                padding: 40px;
                min-height: 40vh;
            }
            
            .right-panel {
                padding: 40px 20px;
                min-height: 60vh;
            }
            
            .login-card {
                padding: 40px 30px;
            }
        }
        
        @media (max-width: 576px) {
            .left-panel {
                padding: 30px 25px;
            }

            .logo-icon {
                margin-top: 20px;
            }

            .academy-name {
                font-size: 26px;
                margin-top: 20px;
            }
            
            .login-card {
                padding: 35px 25px;
            }
            
            .login-title {
                font-size: 26px;
            }
        }

        
        /* Animation for form inputs */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .form-group {
            animation: fadeInUp 0.5s ease forwards;
        }
        
        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }
        
        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .btn-login {
            animation: fadeInUp 0.5s ease 0.3s forwards;
            opacity: 0;
        }
        
        /* Loading Spinner */
        .spinner-border {
            width: 1.2rem;
            height: 1.2rem;
            border-width: 0.15em;
        }

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

    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shapes">
        <div class="shape-1"></div>
        <div class="shape-2"></div>
        <div class="shape-3"></div>
        <div class="shape-4"></div>
    </div>
    
    <div class="container-fluid">
        <!-- Left Panel -->
         <a href="../index.html" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        <div class="left-panel">
            <div class="left-panel-content">
                <div class="academy-logo">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="academy-name">Gurukul Public School Baru</div>
                </div>
                
                <div class="academy-tagline">Empowering Minds, Shaping Futures.</div>
                
                <p class="welcome-text" style="font-size: 17px; line-height: 1.7; opacity: 0.9;">
                    Welcome to the central hub for managing the academy's operations, where excellence meets innovation in education administration.
                </p>
                
                <ul class="feature-list">
                    <li>
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure & Encrypted Admin Access</span>
                    </li>
                    <li>
                        <i class="fas fa-chart-line"></i>
                        <span>Comprehensive Analytics Dashboard</span>
                    </li>
                    <li>
                        <i class="fas fa-users-cog"></i>
                        <span>Advanced User Management</span>
                    </li>
                    <li>
                        <i class="fas fa-database"></i>
                        <span>Real-time Data Synchronization</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Right Panel -->
        <div class="right-panel">
            <div class="login-container">
                <div class="login-card">
                    <div class="login-header">
                        <div class="login-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h2 class="login-title">Admin Panel Login</h2>
                        <p class="login-subtitle">Please enter your credentials to access the dashboard</p>
                    </div>
                    
              <form id="loginForm" action="../backend/login-process.php" method="POST">





    <div class="form-group">
        <label for="email" class="form-label">
            <i class="fas fa-envelope"></i> Email Address
        </label>
        <div class="input-with-icon">
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your admin email" required>
            <div class="input-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="form-label">
            <i class="fas fa-key"></i> Password
        </label>
        <div class="input-with-icon">
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            <div class="input-icon">
                <i class="fas fa-lock"></i>
            </div>
            <button type="button" class="password-toggle" id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>

    <button type="submit" name="login" class="btn btn-login" id="loginButton">

      

        <span id="buttonText">Login to Dashboard</span>
        <span id="buttonSpinner" style="display: none;">
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Authenticating...
        </span>
    </button>
      <?php if(isset($_GET['error'])) { ?>
<div class="alert alert-danger mt-3">
    <i class="fas fa-exclamation-circle"></i> Invalid Email or Password
</div>
<?php } ?>
</form>

                    <div class="footer">
                        <div class="footer-logo">Gurukul Public School</div>
                          <div class="mt-2" style="font-size: 12px; opacity: 0.7;">
                            <i class="fas fa-shield-alt me-1"></i> Secure SSL Connection
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
   <script>
document.addEventListener("DOMContentLoaded", function () {

    // Password show/hide button
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.type === "password" ? "text" : "password";
        passwordInput.type = type;

        eyeIcon.classList.toggle("fa-eye");
        eyeIcon.classList.toggle("fa-eye-slash");
    });

    // Login button animation when real form submits
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener("submit", function () {
        document.getElementById("buttonText").style.display = "none";
        document.getElementById("buttonSpinner").style.display = "inline-block";
    });

});
</script>
</body>
</html>