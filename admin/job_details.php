<?php
header("Content-Type: application/json");

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Job ID missing"]);
    exit;
}

$job_id = intval($_GET['id']);

$pdo = new PDO("mysql:host=localhost;dbname=call_center_jobs", "root", "");

// Fetch job with full details
$stmt = $pdo->prepare("
    SELECT 
        id, 
        title, 
        description, 
        education, 
        skills, 
        location, 
        status, 
        created_at
    FROM jobs 
    WHERE id = ?
");
$stmt->execute([$job_id]);

$job = $stmt->fetch(PDO::FETCH_ASSOC);

if ($job) {
    echo json_encode($job);
} else {
    echo json_encode(["error" => "Job not found"]);
}
