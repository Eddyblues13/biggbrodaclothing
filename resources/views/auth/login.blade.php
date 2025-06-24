<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Biggbroda Clothing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #101320;
      --secondary: #cca264;
      --light: #f8f9fa;
      --gray: #e0e0e0;
      --dark-gray: #666;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
      color: var(--primary);
      min-height: 100vh;
      background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ec 100%);
      position: relative;
      overflow-x: hidden;
    }

    .bg-pattern {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23cca264' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
      z-index: -1;
    }

    .navbar {
      background-color: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      padding: 15px 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }

    .logo {
      height: 40px;
    }

    .nav-link {
      font-weight: 500;
      color: var(--primary);
      margin: 0 10px;
      transition: all 0.3s;
    }

    .nav-link:hover {
      color: var(--secondary);
    }

    .mobile-icons .nav-link {
      margin: 0 5px;
      font-size: 18px;
    }

    .auth-section {
      margin-top: 100px;
      min-height: 80vh;
      display: flex;
      align-items: center;
    }

    .auth-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      padding: 40px;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(204, 162, 100, 0.15);
    }

    .section-title {
      font-weight: 700;
      color: var(--primary);
      position: relative;
      padding-bottom: 15px;
      font-size: 28px;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background: var(--secondary);
      border-radius: 10px;
    }

    .form-control {
      border: 1px solid var(--gray);
      padding: 12px 15px;
      border-radius: 10px;
      transition: all 0.3s;
      font-size: 15px;
    }

    .form-control:focus {
      border-color: var(--secondary);
      box-shadow: 0 0 0 0.25rem rgba(204, 162, 100, 0.25);
    }

    .form-label {
      font-weight: 500;
      color: var(--primary);
      margin-bottom: 8px;
      font-size: 15px;
    }

    .btn-primary {
      background-color: var(--primary);
      border: none;
      padding: 14px;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s;
      font-size: 16px;
    }

    .btn-primary:hover {
      background-color: #0a0d15;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(16, 19, 32, 0.2);
    }

    .btn-outline-secondary {
      border-color: var(--gray);
      color: var(--primary);
      border-radius: 10px;
    }

    .divider span {
      color: var(--dark-gray);
      font-size: 14px;
    }

    .social-login .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 12px;
      border-radius: 10px;
      font-weight: 500;
      transition: all 0.3s;
      font-size: 15px;
    }

    .social-login .btn:hover {
      transform: translateY(-2px);
    }

    .google-btn {
      background: white;
      border: 1px solid var(--gray);
    }

    .google-btn:hover {
      border-color: #db4437;
      background: rgba(219, 68, 55, 0.05);
    }

    .fab {
      margin-right: 10px;
      font-size: 18px;
    }

    .footer {
      background: var(--primary);
      color: white;
      padding: 30px 0;
      margin-top: 50px;
    }

    .social-icons a {
      color: white;
      margin-left: 15px;
      font-size: 18px;
      transition: all 0.3s;
    }

    .social-icons a:hover {
      color: var(--secondary);
      transform: translateY(-3px);
    }

    .forgot-link {
      color: var(--secondary);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s;
      font-size: 14px;
    }

    .forgot-link:hover {
      color: #b38d4a;
      text-decoration: underline;
    }

    .create-account {
      color: var(--secondary);
      font-weight: 600;
      text-decoration: none;
    }

    .create-account:hover {
      text-decoration: underline;
    }

    .brand-decoration {
      position: absolute;
      top: 0;
      right: 0;
      height: 100%;
      width: 30%;
      background: linear-gradient(135deg, rgba(204, 162, 100, 0.1) 0%, rgba(204, 162, 100, 0) 100%);
      clip-path: polygon(100% 0, 100% 100%, 0 0);
      z-index: 0;
    }

    .form-check-input:checked {
      background-color: var(--secondary);
      border-color: var(--secondary);
    }

    .form-check-input:focus {
      box-shadow: 0 0 0 0.25rem rgba(204, 162, 100, 0.25);
    }

    .password-toggle {
      cursor: pointer;
      border-radius: 0 10px 10px 0 !important;
    }

    .fashion-model {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 300px;
      height: 300px;
      background: url('https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=500&auto=format&fit=crop') center/cover;
      border-radius: 20px 0 16px 0;
      opacity: 0.9;
    }

    .input-group .form-control {
      border-radius: 10px 0 0 10px !important;
    }

    .toast {
      border-radius: 10px !important;
      font-family: 'Poppins', sans-serif;
    }

    .toast-success {
      background-color: #4CAF50 !important;
    }

    .toast-error {
      background-color: #f44336 !important;
    }

    .toast-info {
      background-color: #2196F3 !important;
    }

    .toast-warning {
      background-color: #ff9800 !important;
    }

    @media (max-width: 768px) {
      .auth-card {
        padding: 30px 20px;
      }

      .auth-section {
        margin-top: 80px;
      }

      .brand-decoration {
        width: 40%;
      }

      .fashion-model {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="bg-pattern"></div>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <!-- Mobile Layout -->
      <div class="d-lg-none d-flex justify-content-between align-items-center w-100 mobile-navbar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <div class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </button>

        <a class="navbar-brand" href="#">
          <div class="logo-placeholder" style="font-weight: 700; font-size: 24px; color: var(--primary);">BIGGBRODA
          </div>
        </a>

        <div class="mobile-icons">
          <a class="nav-link" href="#"><i class="fas fa-shopping-bag"></i></a>
        </div>
      </div>

      <!-- Desktop Layout -->
      <div class="d-none d-lg-flex justify-content-between align-items-center w-100 desktop-navbar">
        <div class="navbar-nav nav-left">
          <a class="nav-link" href="#">SHOP</a>
          <a class="nav-link" href="#">ABOUT</a>
          <a class="nav-link" href="#">OUR STORE</a>
        </div>

        <a class="navbar-brand mx-auto" href="#">
          <div class="logo-placeholder"
            style="font-weight: 700; font-size: 28px; color: var(--primary); letter-spacing: 1px;">BIGGBRODA</div>
        </a>

        <div class="navbar-nav nav-right">
          <a class="nav-link" href="#">NGN</a>
          <a class="nav-link" href="#">LOGIN</a>
          <a class="nav-link" href="#"><i class="fas fa-heart"></i></a>
          <a class="nav-link" href="#"><i class="fas fa-shopping-bag"></i></a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Login Section -->
  <section class="auth-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="auth-card">
            <div class="brand-decoration"></div>
            <div class="text-center mb-4 position-relative">
              <h2 class="section-title mb-3">WELCOME BACK</h2>
              <p style="color: #666;">Sign in to your BIGGBRODA account</p>
            </div>

            <form id="loginForm">
              <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required
                  placeholder="Enter your email">
              </div>

              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password" required
                    placeholder="Enter your password">
                  <button class="btn btn-outline-secondary password-toggle" type="button" id="passwordToggle">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember" name="remember">
                  <label class="form-check-label" for="remember" style="color: #666;">
                    Remember me
                  </label>
                </div>
                <a href="#" class="forgot-link">Forgot Password?</a>
              </div>

              <button type="submit" class="btn btn-primary w-100 mb-3" id="loginBtn">
                SIGN IN
              </button>

              <div class="text-center mt-3">
                <span style="color: #666;">Don't have an account? </span>
                <a href="register.html" class="create-account">Create Account</a>
              </div>
            </form>

            <div class="divider my-4">
              <div class="d-flex align-items-center">
                <hr class="flex-grow-1">
                <span class="px-3">OR</span>
                <hr class="flex-grow-1">
              </div>
            </div>

            <!-- Social Login -->
            <div class="social-login">
              <button class="btn google-btn w-100 mb-3">
                <i class="fab fa-google" style="color: #db4437;"></i> Continue with Google
              </button>
              <button class="btn btn-outline-secondary w-100">
                <i class="fab fa-facebook-f" style="color: #4267B2;"></i> Continue with Facebook
              </button>
            </div>

            <div class="fashion-model"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2023 Biggbroda Clothing. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap 5 JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    $(document).ready(function() {
            // Configure Toastr
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            
            // Password visibility toggle
            $('#passwordToggle').click(function() {
                const passwordInput = $('#password');
                const icon = $(this).find('i');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
            
            // Form submission
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                
                const email = $('#email').val();
                const password = $('#password').val();
                const remember = $('#remember').is(':checked');
                
                // Basic client-side validation
                if (!email || !password) {
                    toastr.error('Please fill in all fields', 'Validation Error');
                    return;
                }
                
                // Show loading state
                const loginBtn = $('#loginBtn');
                const originalText = loginBtn.html();
                loginBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> SIGNING IN...');
                loginBtn.prop('disabled', true);
                
                // Simulate API call to Laravel backend
                setTimeout(() => {
                    // Simulate different responses for demonstration
                    const random = Math.random();
                    
                    if (random < 0.7) {
                        // Simulate successful login
                        toastr.success('Login successful! Redirecting...', 'Welcome Back');
                        
                        // Redirect after delay
                        setTimeout(() => {
                            window.location.href = '/';
                        }, 2000);
                    } else if (random < 0.85) {
                        // Simulate validation errors
                        toastr.error('The email field must be a valid email address', 'Validation Error');
                        loginBtn.html(originalText);
                        loginBtn.prop('disabled', false);
                    } else {
                        // Simulate authentication failure
                        toastr.error('The provided credentials do not match our records', 'Authentication Failed');
                        loginBtn.html(originalText);
                        loginBtn.prop('disabled', false);
                    }
                }, 1500);
            });
            
            // Demo buttons for showing notifications
            $('.demo-btn').click(function() {
                const type = $(this).data('type');
                
                if (type === 'success') {
                    toastr.success('This is a success notification', 'Operation Successful');
                } else if (type === 'error') {
                    toastr.error('This is an error notification', 'Operation Failed');
                } else if (type === 'warning') {
                    toastr.warning('This is a warning notification', 'Please Note');
                } else {
                    toastr.info('This is an info notification', 'Information');
                }
            });
        });
  </script>
</body>

</html>