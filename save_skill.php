<?php  
session_start();
header('Content-Type: application/json');
include('db/db_connect.php');

// Correct session variable
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$id = intval($_POST['id'] ?? 0);
$skill_name = trim($_POST['skill_name'] ?? '');

if ($skill_name === '') {
    echo json_encode(['status' => 'error', 'message' => 'Skill name is required.']);
    exit;
}

if ($id > 0) {
    // Update skill
    $stmt = $conn->prepare("UPDATE skills SET skill_name=? WHERE id=? AND user_id=?");
    $stmt->bind_param('sii', $skill_name, $id, $user_id);
    $ok = $stmt->execute();
    $stmt->close();
    $msg = $ok ? 'Skill updated successfully.' : 'Update failed.';
} else {
    // Add new skill
    $stmt = $conn->prepare("INSERT INTO skills (user_id, skill_name) VALUES (?, ?)");
    $stmt->bind_param('is', $user_id, $skill_name);
    $ok = $stmt->execute();
    $stmt->close();
    $msg = $ok ? 'Skill added successfully.' : 'Save failed.';
}

echo json_encode(['status' => $ok ? 'success' : 'error', 'message' => $msg]);
exit;
?>
