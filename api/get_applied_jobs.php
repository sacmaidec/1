<?php
header('Content-Type: application/json');
require '../db/db_connect.php';

$user_id = $_GET['user_id'] ?? 0;

$sql = "SELECT job_id FROM job_applications WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$appliedJobs = [];
while ($row = $result->fetch_assoc()) {
    $appliedJobs[] = $row;
}

echo json_encode($appliedJobs);
?>
