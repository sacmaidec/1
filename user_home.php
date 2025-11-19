<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>User Home</title></head>
<body>
    <h1>Welcome user <?php echo $_SESSION['name']; ?></h1>
    <p>You are now logged in as a regular user.</p>
</body>
</html>
