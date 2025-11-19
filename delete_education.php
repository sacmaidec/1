<?php
session_start();
header('Content-Type: application/json');
include('db/db_connect.php');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
  exit;
}

$user_id = intval($_SESSION['user_id']);
$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
  echo json_encode(['status' => 'error', 'message' => 'Invalid record ID']);
  exit;
}

$stmt = $conn->prepare("DELETE FROM education WHERE id = ? AND user_id = ?");
$stmt->bind_param('ii', $id, $user_id);
$ok = $stmt->execute();
$stmt->close();

echo json_encode([
  'status' => $ok ? 'success' : 'error',
  'message' => $ok ? 'Education deleted.' : 'Delete failed.'
]);
?>
