<?php
session_start();
require 'db_connect.php';

// Correct session check
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$cert_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$certificate_name = trim($_POST['certificate_name'] ?? '');
$issued_by = trim($_POST['issued_by'] ?? '');

if ($certificate_name === '' || $issued_by === '') {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

if ($cert_id > 0) {
    // Update certificate
    $stmt = $conn->prepare("UPDATE certificates 
        SET certificate_name=?, issued_by=? 
        WHERE id=? AND user_id=?");
    $stmt->bind_param("ssii", $certificate_name, $issued_by, $cert_id, $user_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["status" => "success", "message" => "Certificate updated successfully!"]);
} else {
    // Insert certificate
    $stmt = $conn->prepare("INSERT INTO certificates (user_id, certificate_name, issued_by) 
        VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $certificate_name, $issued_by);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["status" => "success", "message" => "Certificate added successfully!"]);
}

$conn->close();
?>
