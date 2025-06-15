@include("home.header")
<!-- Register Section -->
<section class="auth-section py-5" style="margin-top: 100px; min-height: 80vh; display: flex; align-items: center;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
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
                <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
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
                <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" {{ old('newsletter')
                  ? 'checked' : '' }}>
                <label class="form-check-label" for="newsletter" style="color: var(--gray);">
                  Subscribe to our newsletter for exclusive offers and updates
                </label>
              </div>
            </div>

            <button type="submit" class="btn btn-outline-light w-100 mb-3" id="submitBtn">
              <span id="btnText">CREATE ACCOUNT</span>
              <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>

            <div class="text-center">
              <span style="color: var(--gray);">Already have an account? </span>
              <a href="{{ route('login') }}" class="text-decoration-none"
                style="color: var(--primary-color); font-weight: 500;">Sign In</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

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

  // AJAX form submission
  $(document).ready(function() {
    $('#registerForm').submit(function(e) {
      e.preventDefault();
      
      // Reset validation states
      $('.invalid-feedback').text('').hide();
      $('.form-control').removeClass('is-invalid');
      $('.form-check-input').removeClass('is-invalid');
      
      const btn = $('#submitBtn');
      const spinner = $('#spinner');
      const btnText = $('#btnText');
      
      // Show spinner
      btn.prop('disabled', true);
      spinner.removeClass('d-none');
      btnText.text('Processing...');
      
      $.ajax({
        url: "{{ route('register.submit') }}",
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            // Redirect after a short delay
            setTimeout(() => {
              window.location.href = "{{ route('login') }}";
            }, 2000);
          }
        },
        error: function(xhr) {
          if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            const formData = xhr.responseJSON.formData;
            
            // Repopulate form with old values
            if (formData) {
              // Text, email, tel inputs
              $('input[type="text"], input[type="email"], input[type="tel"]').each(function() {
                const name = $(this).attr('name');
                if (formData[name] !== undefined) {
                  $(this).val(formData[name]);
                }
              });
              
              // Checkboxes
              $('input[type="checkbox"]').each(function() {
                const name = $(this).attr('name');
                if (formData[name] !== undefined) {
                  $(this).prop('checked', formData[name] === 'on' || formData[name] === true);
                }
              });
            }
            
            // Show errors using Toastr and field highlights
            $.each(errors, function(field, messages) {
              // Show field-specific error
              const errorContainer = $(`.invalid-feedback[data-field="${field}"]`);
              const inputElement = $(`[name="${field}"]`);
              
              if (errorContainer.length) {
                inputElement.addClass('is-invalid');
                errorContainer.text(messages[0]).show();
              }
              
              // Show first error in Toastr
              if (messages.length > 0) {
                toastr.error(messages[0]);
              }
            });
          } else {
            toastr.error('An unexpected error occurred. Please try again.');
          }
        },
        complete: function() {
          btn.prop('disabled', false);
          spinner.addClass('d-none');
          btnText.text('CREATE ACCOUNT');
        }
      });
    });
  });
</script>

<style>
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
</style>

@include("home.footer")