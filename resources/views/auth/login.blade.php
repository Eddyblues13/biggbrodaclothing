@include("home.header")
<!-- Login Section -->
<section class="auth-section py-5" style="margin-top: 100px; min-height: 80vh; display: flex; align-items: center;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="auth-card p-5"
          style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);">
          <div class="text-center mb-4">
            <h2 class="section-title mb-3">WELCOME BACK</h2>
            <p style="color: #666;">Sign in to your BIGGBRODA account</p>
          </div>

          <form id="loginForm" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label for="loginEmail" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="loginEmail" name="email" required>
              <div class="invalid-feedback" data-field="email"></div>
            </div>

            <div class="mb-3">
              <label for="loginPassword" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="loginPassword" name="password" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn">
                  <i class="fas fa-eye" id="passwordToggleIcon"></i>
                </button>
              </div>
              <div class="invalid-feedback" data-field="password"></div>
            </div>

            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                  <label class="form-check-label" for="rememberMe" style="color: var(--gray);">
                    Remember me
                  </label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none"
                  style="color: var(--primary-color);">
                  Forgot Password?
                </a>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3" id="loginBtn">
              <span id="loginBtnText">SIGN IN</span>
              <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>

            <div class="text-center">
              <span style="color: #666;">Don't have an account? </span>
              <a href="{{ route('register') }}" class="text-decoration-none"
                style="color: #0d6efd; font-weight: 500;">Create Account</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  // Initialize Toastr
  toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "timeOut": 5000
  };

  // Password toggle functionality
  document.getElementById('togglePasswordBtn').addEventListener('click', function() {
    const passwordInput = document.getElementById('loginPassword');
    const icon = document.getElementById('passwordToggleIcon');
    
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  });

  // AJAX form submission for login
  document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Reset validation states
      document.querySelectorAll('.invalid-feedback').forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
      });
      document.querySelectorAll('.form-control').forEach(el => {
        el.classList.remove('is-invalid');
      });
      
      const btn = document.getElementById('loginBtn');
      const spinner = document.getElementById('loginSpinner');
      const btnText = document.getElementById('loginBtnText');
      
      // Show spinner
      btn.disabled = true;
      spinner.classList.remove('d-none');
      btnText.textContent = 'Authenticating...';
      
      // Get form data
      const formData = new FormData(this);
      
      fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
      })
      .then(response => {
        if (response.status === 422) {
          return response.json().then(errors => { throw errors; });
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          toastr.success(data.message);
          setTimeout(() => {
            // Redirect to dashboard or intended URL
            window.location.href = data.redirect || "/dashboard";
          }, 1500);
        } else {
          throw new Error(data.message || 'Authentication failed');
        }
      })
      .catch(error => {
        if (error.errors) {
          Object.entries(error.errors).forEach(([field, messages]) => {
            const errorContainer = document.querySelector(`.invalid-feedback[data-field="${field}"]`);
            const inputElement = document.querySelector(`[name="${field}"]`);
            
            if (errorContainer && inputElement) {
              inputElement.classList.add('is-invalid');
              errorContainer.textContent = messages[0];
              errorContainer.style.display = 'block';
            }
            
            // Show first error in Toastr
            if (messages.length > 0) {
              toastr.error(messages[0]);
            }
          });
        } else {
          const errorMsg = error.message || 'An unexpected error occurred';
          toastr.error(errorMsg);
        }
      })
      .finally(() => {
        btn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'SIGN IN';
      });
    });
  });
</script>

<style>
  :root {
    --primary-color: #0d6efd;
    --gray: #666;
  }

  .auth-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  }

  .auth-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .auth-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(16, 19, 32, 0.15);
  }

  .section-title {
    font-weight: 700;
    color: #212529;
    position: relative;
    display: inline-block;
  }

  .section-title:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: var(--primary-color);
    border-radius: 3px;
  }

  .invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
  }

  .is-invalid {
    border-color: #dc3545 !important;
  }

  .btn-primary {
    background: var(--primary-color);
    border: none;
    padding: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    background: #0b5ed7;
    transform: translateY(-2px);
  }
</style>

@include("home.footer")