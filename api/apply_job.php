<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header("Content-Type: application/json");

// --------------------------
// 1. USER MUST BE LOGGED IN
// --------------------------
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// --------------------------
// 2. JOB ID REQUIRED
// --------------------------
if (!isset($_POST['job_id'])) {
    echo json_encode(["error" => "Missing job_id"]);
    exit;
}

$job_id = intval($_POST['job_id']);

// --------------------------
// 3. CONNECT TO DATABASE
// --------------------------
require_once("../db/db_connect.php");
if ($conn->connect_error) {
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

// ---------------------------------------
// 4. CHECK IF USER ALREADY APPLIED
// ---------------------------------------
$check = $conn->prepare("SELECT id FROM job_applications WHERE user_id = ? AND job_id = ?");
$check->bind_param("ii", $user_id, $job_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "already_applied"]);
    exit;
}

// ---------------------------------------
// 5. INSERT APPLICATION
// ---------------------------------------
$insert = $conn->prepare("INSERT INTO job_applications (user_id, job_id) VALUES (?, ?)");
$insert->bind_param("ii", $user_id, $job_id);

if ($insert->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

$conn->close();
?>
