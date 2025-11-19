<?php
include 'db/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... move your current insert logic here, using password_hash() instead of md5 ...
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - KM Services</title>
    <link rel="stylesheet" href="registerstyle.css">
</head>

<body>
    <div class="main-container">
        <!-- LEFT SIDE -->
        <div class="left-panel">
            <h1>Get Started</h1>
            <p>Already have an account?</p>
            <a href="login.php" class="login-btn">Log In</a>
        </div>

        <!-- RIGHT SIDE -->
        <div class="right-panel">
            <h2>Create Account</h2>
            <form action="register_process.php" method="POST">
                <input type="text" name="firstname" placeholder="First Name" required />
                <input type="text" name="lastname" placeholder="Last Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="confirm_password" placeholder="Confirm Password" required />
                <label class="terms">
                    <input type="checkbox" required />
                    I accept the <a href="#">terms of the agreement</a>
                </label>
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
</body>

</html>