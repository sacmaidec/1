<?php
session_start();
header("Content-Type: application/json");
include('db/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(["status" => "error", "message" => "Missing or invalid ID"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM work_experience WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $user_id);
$ok = $stmt->execute();
$stmt->close();

echo json_encode([
    "status" => $ok ? "success" : "error",
    "message" => $ok ? "Deleted successfully" : "Delete failed"
]);
exit;
?>
