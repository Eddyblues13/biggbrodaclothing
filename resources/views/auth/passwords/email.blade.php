<!-- resources/views/auth/passwords/email.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biggbroda Clothing - Forgot Password</title>
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
                            <p style="color: var(--gray);">Enter your email to receive a password reset link</p>
                        </div>

                        <form id="forgotPasswordForm">
                            @csrf
                            <div class="mb-4">
                                <label for="forgotEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="forgotEmail" name="email" required
                                    placeholder="your.email@example.com">
                            </div>

                            <button type="submit" class="btn btn-outline-light w-100 mb-3" id="submitBtn">
                                <span id="btnText">SEND RESET LINK</span>
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

    // AJAX form submission for forgot password
    $(document).ready(function() {
      $('#forgotPasswordForm').submit(function(e) {
        e.preventDefault();
        
        const btn = $('#submitBtn');
        const spinner = $('#spinner');
        const btnText = $('#btnText');
        
        // Show spinner
        btn.prop('disabled', true);
        spinner.removeClass('d-none');
        btnText.text('Sending...');
        
        $.ajax({
          url: "{{ route('password.email') }}",
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
            if (response.success) {
              toastr.success(response.message);
              // Clear form
              $('#forgotPasswordForm')[0].reset();
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
            btnText.text('SEND RESET LINK');
          }
        });
      });
    });
    </script>
</body>

</html>