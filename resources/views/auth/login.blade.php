<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ESSENCE - Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- Toastr for notifications -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Custom CSS -->
  <style>
    /* Custom styles for ESSENCE signup page */
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    /* Form styling */
    .form-control {
      padding: 0.75rem 1rem;
      border-radius: 0.25rem;
    }

    .form-control:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
      transition: all 0.3s ease;
    }

    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }

    /* Image section styling */
    .signup-image-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.3) 100%);
    }

    /* Header styling */
    header {
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Card styling */
    .card {
      border-radius: 0.5rem;
      overflow: hidden;
    }

    /* Links styling */
    a {
      text-decoration: none;
      color: #dc3545;
      transition: color 0.3s ease;
    }

    a:hover {
      color: #c82333;
    }

    /* Custom button styling */
    .btn-outline-secondary {
      border-color: #ced4da;
    }

    .btn-outline-secondary:hover {
      background-color: #f8f9fa;
      color: #212529;
      border-color: #ced4da;
    }

    /* Footer styling */
    footer {
      background-color: #212529;
    }

    footer a:hover {
      color: #fff !important;
    }

    /* Responsive adjustments */
    @media (max-width: 767.98px) {
      .card-body {
        padding: 1.5rem;
      }
    }

    /* Loading spinner */
    .spinner-border {
      display: none;
      width: 1.5rem;
      height: 1.5rem;
      border-width: 0.2em;
    }
  </style>
</head>

<body>

  <!-- Main Content -->
  <main class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card border-0 shadow overflow-hidden">
            <div class="row g-0">
              <!-- Form Section -->
              <div class="col-md-6">
                <div class="card-body p-4 p-lg-5">
                  <h2 class="fw-bold mb-4">Sign In</h2>

                  <form id="loginForm">
                    @csrf
                    <div class="mb-3">
                      <label for="email" class="form-label">Email Address</label>
                      <input type="email" class="form-control" id="login_email" name="email" required>
                    </div>

                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group">
                        <input type="password" class="form-control" id="login_password" name="password" required
                          minlength="8">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                          <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                      </div>
                    </div>

                    <div class="mb-3 form-check">
                      <input type="checkbox" class="form-check-input" id="remember" name="remember">
                      <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2 mb-3" id="loginBtn">
                      <span id="loginText">Login</span>
                      <span class="spinner-border spinner-border-sm" id="loginSpinner" role="status"
                        aria-hidden="true"></span>
                    </button>

                    <p class="text-center">
                      Don't have an account? <a href="{{ url('/register') }}" class="text-danger fw-medium">Register</a>
                    </p>
                    <p class="text-center">
                      <a href="" class="text-danger fw-medium">Forgot password?</a>
                    </p>
                  </form>
                </div>
              </div>

              <!-- Image Section -->
              <div class="col-md-6 d-none d-md-block bg-light position-relative">
                <div class="signup-image-overlay"></div>
                <div class="position-absolute top-50 start-50 translate-middle text-center p-4">
                  <h3 class="fw-bold mb-3">Login into your dashboard</h3>
                  <p class="mb-4">Discover the latest fashion trends and exclusive offers.</p>
                  <div class="bg-white bg-opacity-75 p-3 rounded shadow-sm">
                    <p class="mb-0">
                      Use code <span class="fw-bold text-danger">WELCOME15</span> for 15% off your first order
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    // Configure Toastr
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000"
    };

    // Password visibility toggle functionality
    document.addEventListener("DOMContentLoaded", () => {
      const passwordField = document.getElementById("login_password");
      const togglePassword = document.getElementById("togglePassword");
      const toggleIcon = document.getElementById("toggleIcon");

      togglePassword.addEventListener("click", () => {
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        toggleIcon.classList.toggle("fa-eye");
        toggleIcon.classList.toggle("fa-eye-slash");
      });
    });

    // AJAX Login Form Submission
    $(document).ready(function() {
      $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading spinner
        $('#loginText').hide();
        $('#loginSpinner').show();
        $('#loginBtn').prop('disabled', true);
        
        $.ajax({
          url: "{{ route('login') }}",
          method: "POST",
          data: $(this).serialize(),
          success: function(response) {
            if (response.success) {
              toastr.success(response.message);
              // Redirect to intended URL or home
              window.location.href = "{{ session('url.intended') ? session('url.intended') : route('home') }}";
            } else {
              toastr.error(response.message);
              $('#loginText').show();
              $('#loginSpinner').hide();
              $('#loginBtn').prop('disabled', false);
            }
          },
          error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            if (errors) {
              $.each(errors, function(key, value) {
                toastr.error(value[0]);
              });
            } else {
              toastr.error(xhr.responseJSON.message || 'Login failed. Please try again.');
            }
            $('#loginText').show();
            $('#loginSpinner').hide();
            $('#loginBtn').prop('disabled', false);
          }
        });
      });
    });
  </script>
</body>

</html>