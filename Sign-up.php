<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up | Shopterra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/Signup.css">
</head>
<body>

  <div class="signup-card">
    <h2>Create Your Account</h2>
    <form action="Signup.php" method="POST" onsubmit="return validateCheckbox()">
      <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
      </div>
      <div class="mb-3">
        <input type="text" name="contact" class="form-control" placeholder="Contact Number" maxlength="15">
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="mb-3">
        <input type="password" name="c-password" class="form-control" placeholder="Confirm Password" required>
      </div>

      <!-- Terms & Conditions Checkbox -->
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="termsCheck">
        <label class="form-check-label" for="termsCheck">
          I agree to the <a href="#">Terms and Conditions</a>
        </label>
      </div>

      <button type="submit" name="sign-up" class="btn btn-success">Sign Up</button>
    </form>

    <div class="login-link">
      Already have an account? <a href="Log-in.php">Login here</a>
    </div>
  </div>

  <script>
    function validateCheckbox() {
      const termsCheck = document.getElementById('termsCheck');
      if (!termsCheck.checked) {
        alert("Please agree to the Terms and Conditions before submitting.");
        return false;
      }
      return true;
    }
  </script>

</body>
</html>
