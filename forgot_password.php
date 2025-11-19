<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - KM Services</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div class="logo">KM Services</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="#">About Us</a>
    <a href="#">Contact</a>
  </nav>
</header>

<div class="login-container">
  <h1>Forgot Password</h1>
  <form action="send_reset.php" method="POST">
    <input type="email" name="email" placeholder="Enter your registered email" required>
    <button type="submit" class="login-btn">Send Reset Link</button>
    <p class="register-link"><a href="login.php">Back to Login</a></p>
  </form>
</div>
</body>
</html>
