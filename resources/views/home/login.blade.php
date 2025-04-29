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
                  
                  <form id="signupForm">
                    <div class="mb-3">
                      <label for="email" class="form-label">Email Address</label>
                      <input type="email" class="form-control" id="email" required>
                    </div>
                    
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group">
                        <input type="password" class="form-control" id="password" required minlength="8">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                          <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                      </div>
                      <div class="form-text">Password must be at least 8 characters</div>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-danger w-100 py-2 mb-3">Login</button>
                    
                    <p class="text-center">
                      Don't have an account? <a href="{{ url('/register') }}" class="text-danger fw-medium">Register</a>
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
  <!-- Custom JavaScript -->
  <script>
    // Password visibility toggle functionality
document.addEventListener("DOMContentLoaded", () => {
  // For the main password field
  const passwordField = document.getElementById("password")
  const togglePassword = document.getElementById("togglePassword")
  const toggleIcon = document.getElementById("toggleIcon")

  // For the confirm password field
  const confirmPasswordField = document.getElementById("confirmPassword")
  const toggleConfirmPassword = document.getElementById("toggleConfirmPassword")
  const toggleConfirmIcon = document.getElementById("toggleConfirmIcon")

  // Toggle password visibility for main password
  togglePassword.addEventListener("click", () => {
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password"
    passwordField.setAttribute("type", type)

    // Toggle the eye icon
    toggleIcon.classList.toggle("fa-eye")
    toggleIcon.classList.toggle("fa-eye-slash")
  })

  // Toggle password visibility for confirm password
  toggleConfirmPassword.addEventListener("click", () => {
    const type = confirmPasswordField.getAttribute("type") === "password" ? "text" : "password"
    confirmPasswordField.setAttribute("type", type)

    // Toggle the eye icon
    toggleConfirmIcon.classList.toggle("fa-eye")
    toggleConfirmIcon.classList.toggle("fa-eye-slash")
  })
})

  </script>
</body>
</html>
