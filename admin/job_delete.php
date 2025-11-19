<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require '../db/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: jobs_list.php');
    exit;
}
$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    header('Location: jobs_list.php');
    exit;
}

// get title for log
$s = $conn->prepare("SELECT title, image FROM jobs WHERE id = ?");
$s->bind_param('i', $id);
$s->execute();
$s->bind_result($title, $image);
$s->fetch();
$s->close();

// delete row
$del = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$del->bind_param('i', $id);
if ($del->execute()) {
    // optionally delete image file
    if ($image) {
        $p = __DIR__ . '/../' . $image;
        if (file_exists($p)) @unlink($p);
    }
    $msg = "Job deleted: " . ($title ?: $id);
    $a = $conn->prepare("INSERT INTO activities (type, message, related_id) VALUES (?, ?, ?)");
    $type = 'job_delete';
    $a->bind_param('ssi', $type, $msg, $id);
    $a->execute();
    $a->close();
}
header('Location: jobs_list.php');
exit;
?>