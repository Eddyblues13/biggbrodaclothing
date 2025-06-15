<!-- resources/views/auth/passwords/reset.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biggbroda Clothing - Reset Password</title>
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
            max-width: 500px;
            margin: 0 auto;
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

        .form-control {
            border-color: var(--light-gray);
            padding: 0.75rem;
        }

        .form-control:focus {
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
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <section class="auth-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="auth-card p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="section-title mb-3">RESET YOUR PASSWORD</h2>
                            <p style="color: var(--gray);">Create a new password for your account</p>
                        </div>

                        <form id="resetPasswordForm">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="resetEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="resetEmail" name="email" required
                                    value="{{ $email ?? old('email') }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="resetPassword" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="resetPassword" name="password"
                                        required>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('resetPassword')">
                                        <i class="fas fa-eye" id="resetPasswordToggle"></i>
                                    </button>
                                </div>
                                <div class="password-strength" id="passwordStrength">Password must be at least 8
                                    characters long</div>
                            </div>

                            <div class="mb-4">
                                <label for="resetPasswordConfirm" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="resetPasswordConfirm"
                                        name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('resetPasswordConfirm')">
                                        <i class="fas fa-eye" id="resetPasswordConfirmToggle"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-light w-100 mb-3" id="submitBtn">
                                <span id="btnText">RESET PASSWORD</span>
                                <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>

                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="text-decoration-none"
                                    style="color: var(--primary-color); font-weight: 500;">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Login
                                </a>
                            </div>
                        </form>
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

    function togglePassword(fieldId) {
      const passwordInput = document.getElementById(fieldId);
      const passwordToggle = document.getElementById(fieldId + 'Toggle');
      
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

    // Password strength indicator
    document.getElementById('resetPassword').addEventListener('input', function() {
      const password = this.value;
      const strengthIndicator = document.getElementById('passwordStrength');
      
      if (password.length === 0) {
        strengthIndicator.textContent = 'Password must be at least 8 characters long';
        strengthIndicator.className = 'password-strength';
      } else if (password.length < 8) {
        strengthIndicator.textContent = 'Password too short';
        strengthIndicator.className = 'password-strength short';
      } else if (password.length >= 8 && password.length < 12) {
        strengthIndicator.textContent = 'Password strength: Good';
        strengthIndicator.className = 'password-strength good';
      } else {
        strengthIndicator.textContent = 'Password strength: Strong';
        strengthIndicator.className = 'password-strength strong';
      }
    });

    // AJAX form submission for password reset
    $(document).ready(function() {
      $('#resetPasswordForm').submit(function(e) {
        e.preventDefault();
        
        const btn = $('#submitBtn');
        const spinner = $('#spinner');
        const btnText = $('#btnText');
        
        // Show spinner
        btn.prop('disabled', true);
        spinner.removeClass('d-none');
        btnText.text('Resetting...');
        
        $.ajax({
          url: "{{ route('password.update') }}",
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
            if (response.success) {
              toastr.success(response.message);
              // Redirect to login after a delay
              setTimeout(() => {
                window.location.href = "{{ route('login') }}";
              }, 2000);
            }
          },
          error: function(xhr) {
            if (xhr.status === 422) {
              const errors = xhr.responseJSON.errors;
              $.each(errors, function(key, item) {
                toastr.error(item[0]);
              });
            } else {
              toastr.error(xhr.responseJSON.message || 'An error occurred. Please try again.');
            }
          },
          complete: function() {
            btn.prop('disabled', false);
            spinner.addClass('d-none');
            btnText.text('RESET PASSWORD');
          }
        });
      });
    });
    </script>
</body>

</html>