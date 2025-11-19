<?php
session_start();
require_once __DIR__ . '/db/db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        die('Please fill in all fields.');
    }

    // Get all needed fields from database
    $stmt = $conn->prepare("
        SELECT id, firstname, lastname, email, password, status, role 
        FROM users 
        WHERE email = ?
    ");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
    die("Email not found: $email");
}

  $stmt->bind_result($id, $firstname, $lastname, $emailFromDB, $hashed_password, $status, $role);

    $stmt->fetch();

    if (!password_verify($password, $hashed_password)) {
    die('Wrong password. Hashed in DB: ' . $hashed_password . '<br> Password you typed: ' . $password);
}

    if ($status !== 'active') {
        die('Your account is inactive.');
    }
$_SESSION['role'] = 'admin';

$_SESSION['user_id'] = $id;
$_SESSION['firstname'] = $firstname;
$_SESSION['lastname'] = $lastname;
$_SESSION['email'] = $emailFromDB;


    // Redirect
    if ($role === 'admin') {
        header("Location: admin/adminhome.php");
    } else {
        header("Location: newsfeed.php");
    }
    exit;
}
?>

