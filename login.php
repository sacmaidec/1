<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - KM Services</title>
    <link rel="stylesheet" href="loginstyle.css" />
</head>

<body>
    <div class="main-container">
        <div class="logo">KM Services</div>

        <div class="login-container">
            <h1>Log In</h1>
            <p>Welcome back! Please enter your details</p>
            <form action="login_process.php" method="POST">
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="register">
                Don’t have an account? <a href="register.php">Sign up</a>
            </div>
        </div>

        <div class="image-container">
            <img src="img/380442424_743323984305644_6175663148792212035_n.jpg" alt="Login illustration" />
        </div>
    </div>
</body>

</html>