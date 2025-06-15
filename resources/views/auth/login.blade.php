<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biggbroda Clothing - Login</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style>
    :root {
      --primary-color: #cca264;
      --text-color: #101320;
      --light-gray: #e0e0e0;
      --gray: #666;
      --white: #ffffff;
    }

    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .auth-section {
      margin-top: 100px;
      min-height: 80vh;
      display: flex;
      align-items: center;
    }

    .auth-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);
    }

    .section-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text-color);
    }

    .form-label {
      color: var(--text-color);
      font-weight: 500;
    }

    .form-control,
    .form-select {
      border-color: var(--light-gray);
      padding: 0.75rem;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(204, 162, 100, 0.25);
    }

    .form-check-input:checked {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .form-check-input:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(204, 162, 100, 0.25);
    }

    .btn-outline-light {
      background-color: var(--primary-color);
      color: var(--white);
      border: none;
      padding: 0.75rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
      background-color: #b38d4d;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-light:disabled {
      background-color: #d9c8a4;
      cursor: not-allowed;
    }

    .password-strength {
      font-size: 0.85rem;
      margin-top: 0.25rem;
    }

    .password-strength.short {
      color: #dc3545;
    }

    .password-strength.good {
      color: #ffc107;
    }

    .password-strength.strong {
      color: #198754;
    }

    .spinner-border {
      margin-left: 10px;
    }

    .footer {
      background-color: var(--text-color);
      color: var(--white);
    }

    .social-icons a {
      color: var(--white);
      margin-left: 15px;
      font-size: 1.2rem;
      transition: color 0.3s;
    }

    .social-icons a:hover {
      color: var(--primary-color);
    }
  </style>
</head>

<body>
  <!-- Login Section -->
  <section class="auth-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="auth-card p-4 p-md-5">
            <div class="text-center mb-4">
              <h2 class="section-title mb-3">SIGN IN</h2>
              <p style="color: var(--gray);">Welcome back to BIGGBRODA</p>
            </div>

            <form id="loginForm">
              @csrf
              <div class="mb-3">
                <label for="loginEmail" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="loginEmail" name="email" required
                  value="{{ old('email') }}">
              </div>

              <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="loginPassword" name="password" required>
                  <button class="btn btn-outline-secondary" type="button" onclick="toggleLoginPassword()">
                    <i class="fas fa-eye" id="loginPasswordToggle"></i>
                  </button>
                </div>
              </div>

              <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" {{ old('remember')
                    ? 'checked' : '' }}>
                  <label class="form-check-label" for="rememberMe" style="color: var(--gray);">
                    Remember me
                  </label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none"
                  style="color: var(--primary-color); font-weight: 500;">
                  Forgot Password?
                </a>
              </div>

              <button type="submit" class="btn btn-outline-light w-100 mb-3" id="loginBtn">
                <span id="loginBtnText">SIGN IN</span>
                <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
              </button>

              <div class="text-center">
                <span style="color: var(--gray);">Don't have an account? </span>
                <a href="{{ route('register') }}" class="text-decoration-none"
                  style="color: var(--primary-color); font-weight: 500;">Create Account</a>
              </div>
            </form>

            <div class="divider my-4">
              <div class="d-flex align-items-center">
                <hr class="flex-grow-1" style="border-color: #e0e0e0;">
                <span class="px-3 text-muted">OR</span>
                <hr class="flex-grow-1" style="border-color: #e0e0e0;">
              </div>
            </div>

            <!-- Social Login -->
            <div class="social-login">
              <button class="btn btn-outline-secondary w-100 mb-2" style="border-color: #e0e0e0; color: #101320;">
                <i class="fab fa-google me-2" style="color: #db4437;"></i>Sign in with Google
              </button>
              <button class="btn btn-outline-secondary w-100" style="border-color: #e0e0e0; color: #101320;">
                <i class="fab fa-facebook-f me-2" style="color: #3b5998;"></i>Sign in with Facebook
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer py-4">
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
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    // Initialize Toastr
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "timeOut": 5000
    };

    function toggleLoginPassword() {
      const passwordInput = document.getElementById('loginPassword');
      const passwordToggle = document.getElementById('loginPasswordToggle');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.classList.remove('fa-eye');
        passwordToggle.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        passwordToggle.classList.remove('fa-eye-slash');
        passwordToggle.classList.add('fa-eye');
      }
    }

    // AJAX form submission for login
    $(document).ready(function() {
      $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        const btn = $('#loginBtn');
        const spinner = $('#loginSpinner');
        const btnText = $('#loginBtnText');
        
        // Show spinner
        btn.prop('disabled', true);
        spinner.removeClass('d-none');
        btnText.text('Signing in...');
        
        $.ajax({
          url: "{{ route('login.submit') }}",
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
            if (response.success) {
              toastr.success(response.message);
              // Redirect to dashboard or home page
              setTimeout(() => {
                window.location.href = "{{ route('home') }}";
              }, 1500);
            }
          },
          error: function(xhr) {
            if (xhr.status === 422) {
              const errors = xhr.responseJSON.errors;
              $.each(errors, function(key, item) {
                toastr.error(item[0]);
              });
            } else if (xhr.status === 401) {
              toastr.error(xhr.responseJSON.message || 'Invalid credentials');
            } else {
              toastr.error('An error occurred. Please try again.');
            }
          },
          complete: function() {
            btn.prop('disabled', false);
            spinner.addClass('d-none');
            btnText.text('SIGN IN');
          }
        });
      });
    });
  </script>
</body>

</html>