<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="CSS/Login.css"> <!-- Your custom CSS -->
</head>
<body>

  <div class="login-card container mt-5 p-4 rounded shadow bg-white" style="max-width: 450px;">
    <h2 class="text-center mb-4">Login</h2>
    <form action="Login.php"method="post">
      <div class="mb-3">
        <label for="inputEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="inputEmail"name="email" placeholder="Enter email" required>
        <div class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="inputPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="inputPassword"name="password" placeholder="Enter password" required>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="rememberMe">
        <label class="form-check-label" for="rememberMe">Remember me</label>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>

      <!-- Signup Link -->
      <div class="mt-3 text-center">
        <span>Don't have an account? </span>
        <a href="Sign-up.php">Create New Account</a>
      </div>
    </form>
  </div>

</body>
</html>
