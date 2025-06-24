@include("home.header")
<!-- Register Section -->
<section class="auth-section py-5" style="margin-top: 100px; min-height: 80vh; display: flex; align-items: center;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class="row">
          <!-- Registration Form -->
          <div class="col-md-7">
            <div class="auth-card p-5"
              style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);">
              <div class="text-center mb-4">
                <h2 class="section-title mb-3">CREATE ACCOUNT</h2>
                <p style="color: #666;">Join the BIGGBRODA family and enjoy exclusive benefits</p>
              </div>

              <form id="registerForm">
                @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" required
                      value="{{ old('first_name') }}">
                    <div class="invalid-feedback" data-field="first_name"></div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" required
                      value="{{ old('last_name') }}">
                    <div class="invalid-feedback" data-field="last_name"></div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                  <div class="invalid-feedback" data-field="email"></div>
                </div>

                <div class="mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="tel" class="form-control" id="phone" name="phone" required value="{{ old('phone') }}">
                  <div class="invalid-feedback" data-field="phone"></div>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                      <i class="fas fa-eye" id="passwordToggle"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback" data-field="password"></div>
                  <div class="password-strength" id="passwordStrength">Password must be at least 8 characters long</div>
                </div>

                <div class="mb-3">
                  <label for="confirmPassword" class="form-label">Confirm Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="confirmPassword" name="password_confirmation"
                      required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                      <i class="fas fa-eye" id="confirmPasswordToggle"></i>
                    </button>
                  </div>
                </div>

                <div class="mb-4">
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms" required {{
                      old('agreeTerms') ? 'checked' : '' }}>
                    <label class="form-check-label" for="agreeTerms" style="color: var(--gray);">
                      I agree to the <a href="#" style="color: var(--primary-color);">Terms of Service</a> and
                      <a href="#" style="color: var(--primary-color);">Privacy Policy</a>
                    </label>
                    <div class="invalid-feedback" data-field="agreeTerms"></div>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" {{
                      old('newsletter') ? 'checked' : '' }}>
                    <label class="form-check-label" for="newsletter" style="color: var(--gray);">
                      Subscribe to our newsletter for exclusive offers and updates
                    </label>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3" id="submitBtn">
                  <span id="btnText">CREATE ACCOUNT</span>
                  <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>

                <div class="text-center">
                  <span style="color: #666;">Already have an account? </span>
                  <a href="{{ route('login') }}" class="text-decoration-none"
                    style="color: #0d6efd; font-weight: 500;">Sign In</a>
                </div>
              </form>
            </div>
          </div>

          <!-- Debug Panel -->
          <div class="col-md-5">
            <div class="debug-panel p-4" style="background: #f8f9fa; border-radius: 12px; height: 100%;">
              <h4 class="mb-3" style="color: #dc3545;">Debug Console</h4>
              <div class="alert alert-info">
                <strong>How to debug:</strong>
                <ol class="mt-2">
                  <li>Open browser console (F12)</li>
                  <li>Submit the registration form</li>
                  <li>Check console for detailed error messages</li>
                </ol>
              </div>

              <div class="mb-3">
                <h5>Form Submission Status</h5>
                <div class="status-card p-3 bg-white rounded mb-3">
                  <div id="debugStatus" class="text-muted">Waiting for form submission...</div>
                </div>
              </div>

              <div class="mb-3">
                <h5>Console Log Preview</h5>
                <div class="console-preview bg-dark text-light p-3 rounded"
                  style="height: 150px; overflow-y: auto; font-family: monospace; font-size: 14px;">
                  <div id="consoleOutput"></div>
                </div>
              </div>

              <div class="text-center mt-4">
                <button class="btn btn-sm btn-outline-secondary" onclick="clearConsole()">
                  <i class="fas fa-trash me-1"></i> Clear Console
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  // Initialize Toastr
  toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "timeOut": 5000
  };

  // Function to log messages to console and debug panel
  function debugLog(message, type = 'log') {
      console[type](message);
      
      const consoleOutput = document.getElementById('consoleOutput');
      const entry = document.createElement('div');
      entry.className = type === 'error' ? 'text-danger' : 'text-info';
      entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
      consoleOutput.appendChild(entry);
      
      // Auto-scroll to bottom
      consoleOutput.scrollTop = consoleOutput.scrollHeight;
  }

  // Clear console preview
  function clearConsole() {
      document.getElementById('consoleOutput').innerHTML = '';
      debugLog('Console cleared', 'log');
  }

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
  document.getElementById('password').addEventListener('input', function() {
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

  // AJAX form submission with debug logging
  document.addEventListener('DOMContentLoaded', function() {
      const registerForm = document.getElementById('registerForm');
      const debugStatus = document.getElementById('debugStatus');
      
      registerForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          // Reset validation states
          document.querySelectorAll('.invalid-feedback').forEach(el => {
              el.textContent = '';
              el.style.display = 'none';
          });
          document.querySelectorAll('.form-control').forEach(el => {
              el.classList.remove('is-invalid');
          });
          document.querySelectorAll('.form-check-input').forEach(el => {
              el.classList.remove('is-invalid');
          });
          
          const btn = document.getElementById('submitBtn');
          const spinner = document.getElementById('spinner');
          const btnText = document.getElementById('btnText');
          
          // Show spinner
          btn.disabled = true;
          spinner.classList.remove('d-none');
          btnText.textContent = 'Processing...';
          debugStatus.textContent = 'Form submission started...';
          debugStatus.className = 'text-primary';
          debugLog('Starting form submission...');
          
          // Get form data
          const formData = new FormData(this);
          
          // Log form data to console
          debugLog('Form data: ' + JSON.stringify(Object.fromEntries(formData)));
          
          fetch("/register", {
              method: 'POST',
              body: formData,
              headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
              }
          })
          .then(response => {
              debugLog(`Received response: ${response.status} ${response.statusText}`);
              debugStatus.textContent = `Server responded with: ${response.status}`;
              debugStatus.className = response.ok ? 'text-success' : 'text-warning';
              
              if (response.status === 422) {
                  return response.json().then(errors => { throw errors; });
              }
              return response.json();
          })
          .then(data => {
              debugLog('Response data: ' + JSON.stringify(data));
              
              if (data.success) {
                  debugLog('Registration successful! Redirecting to login...');
                  debugStatus.textContent = 'Success! Redirecting to login...';
                  debugStatus.className = 'text-success';
                  
                  toastr.success(data.message);
                  setTimeout(() => {
                      window.location.href = "/login";
                  }, 2000);
              } else {
                  throw new Error(data.message || 'Registration failed');
              }
          })
          .catch(error => {
              if (error.errors) {
                  debugLog('Validation errors: ' + JSON.stringify(error.errors), 'error');
                  debugStatus.textContent = 'Form validation errors detected';
                  debugStatus.className = 'text-danger';
                  
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
                  debugLog('Error: ' + errorMsg, 'error');
                  debugStatus.textContent = 'Error: ' + errorMsg;
                  debugStatus.className = 'text-danger';
                  toastr.error(errorMsg);
              }
          })
          .finally(() => {
              btn.disabled = false;
              spinner.classList.add('d-none');
              btnText.textContent = 'CREATE ACCOUNT';
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

  .password-strength {
    font-size: 0.875em;
    margin-top: 0.25rem;
  }

  .password-strength.short {
    color: #dc3545;
  }

  .password-strength.good {
    color: #ffc107;
  }

  .password-strength.strong {
    color: #28a745;
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

  .debug-panel {
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .console-preview {
    background: #1e1e1e;
  }

  .status-card {
    border-left: 4px solid #0d6efd;
  }
</style>

@include("home.footer")