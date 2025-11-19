<?php
session_start();
include("db/db_connect.php");

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

if (!empty($_FILES['resume_file']['name'])) {

    $targetDir = "uploads/resumes/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["resume_file"]["name"]);
    $targetFile = $targetDir . $fileName;

    $allowed = ['pdf','doc','docx'];
    $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        echo "<script>alert('Invalid file type.'); window.history.back();</script>";
        exit;
    }

    if (move_uploaded_file($_FILES["resume_file"]["tmp_name"], $targetFile)) {

        // Save file path in session (and optionally database)
        $_SESSION['resume_doc'] = $targetFile;

        echo "<script>
                alert('Resume uploaded successfully.');
                window.location.href='profile.php';
              </script>";
    } else {
        echo "<script>alert('Upload failed.'); window.history.back();</script>";
    }
}
?>
