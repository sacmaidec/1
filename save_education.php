<?php
// Clear any accidental whitespace or BOM
ob_clean();

header("Content-Type: application/json");
session_start();

include('db/db_connect.php');

// Validate session
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Not logged in"
    ]);
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Receive POST data
$school = $_POST['school'] ?? '';
$degree = $_POST['degree'] ?? '';
$year   = $_POST['year'] ?? '';
$id     = intval($_POST['id'] ?? 0);

// Prepare SQL
if ($id > 0) {
    // UPDATE
    $stmt = $conn->prepare("
        UPDATE education 
        SET school=?, degree=?, year=? 
        WHERE id=? AND user_id=?
    ");
    $stmt->bind_param("sssii", $school, $degree, $year, $id, $user_id);

} else {
    // INSERT
    $stmt = $conn->prepare("
        INSERT INTO education (user_id, school, degree, year) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("isss", $user_id, $school, $degree, $year);
}

// Execute query
if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Education saved successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

exit;
?>
