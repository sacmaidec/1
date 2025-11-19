<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit;
}

include('db/db_connect.php');

$user_id = intval($_SESSION['user_id']);

$id = intval($_POST['id']);
$job_title = $_POST['job_title'];
$company = $_POST['company'];
$duration = $_POST['duration'];

if ($id > 0) {
    // UPDATE
    $stmt = $conn->prepare("UPDATE work_experience SET job_title=?, company=?, duration=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sssii", $job_title, $company, $duration, $id, $user_id);
    $stmt->execute();
} else {
    // INSERT
    $stmt = $conn->prepare("INSERT INTO work_experience (user_id, job_title, company, duration) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $job_title, $company, $duration);
    $stmt->execute();
}

echo json_encode([
    "status" => "success",
    "message" => "Work experience saved!"
]);
