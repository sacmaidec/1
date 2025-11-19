<?php
require 'db/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$firstname = trim($_POST['firstname'] ?? '');
$lastname  = trim($_POST['lastname'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$confirm   = $_POST['confirm_password'] ?? '';

if ($firstname === '' || $lastname === '' || $email === '' || $password === '' || $confirm === '') {
    die('All fields are required.');
}

if ($password !== $confirm) {
    die('Passwords do not match.');
}

// Check if email already exists
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    die('Email already registered.');
}
$check->close();

// Hash password securely
$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, 'user')");
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed);

if ($stmt->execute()) {
    header("Location: login.php?registered=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>