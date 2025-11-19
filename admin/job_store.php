<?php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require '../db/db_connect.php';  // <-- FIXED PATH


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: jobs_list.php');
    exit;
}

$company_name = trim($_POST['company_name'] ?? '');
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$education = trim($_POST['education'] ?? '');
$skills = trim($_POST['skills'] ?? '');
$location = trim($_POST['location'] ?? '');
$requirements = trim($_POST['requirements'] ?? '');

if ($company_name === '' || $title === '') { die('Company and title required.'); }


// find or create company
$stmt = $conn->prepare("SELECT id FROM companies WHERE name = ?");
$stmt->bind_param('s', $company_name);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 1) {
    $stmt->bind_result($company_id);
    $stmt->fetch();
    $stmt->close();
} else {
    $stmt->close();
    $ins = $conn->prepare("INSERT INTO companies (name) VALUES (?)");
    $ins->bind_param('s', $company_name);
    $ins->execute();
    $company_id = $ins->insert_id;
    $ins->close();
}

// handle image upload (optional)
$imagePath = '';
if (!empty($_FILES['image']['tmp_name'])) {
    $upDir = __DIR__ . '/../uploads/jobs/';
    if (!is_dir($upDir)) mkdir($upDir, 0755, true);
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fname = 'job_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target = $upDir . $fname;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $imagePath = 'uploads/jobs/' . $fname;
    }
}

// insert job
$insj = $conn->prepare("INSERT INTO jobs (company_id, title, description, requirements, image, status) VALUES (?, ?, ?, ?, ?, 'active')");
$insj->bind_param('issss', $company_id, $title, $description, $requirements, $imagePath);
if ($insj->execute()) {
    $job_id = $insj->insert_id;
    // log activity
    $msg = "Job posted: {$title}";
    $act = $conn->prepare("INSERT INTO activities (type, message, related_id) VALUES (?, ?, ?)");
    $type = 'job_post';
    $act->bind_param('ssi', $type, $msg, $job_id);
    $act->execute();
    $act->close();

    header('Location: jobs_list.php?created=1');
    exit;
} else {
    echo 'DB error: ' . $insj->error;
}
?>