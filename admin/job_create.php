<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$_SESSION['role'] = $role; // or 'admin' if hardcoded

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Create Job</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body class="p-3">
    <h3>Create Job <a href="jobs_list.php" class="btn btn-sm btn-secondary">Back</a></h3>
    <form action="job_store.php" method="POST" enctype="multipart/form-data">
    <label>Company Name</label>
    <input type="text" name="company_name" class="form-control" required>

    <label>Job Title</label>
    <input type="text" name="title" class="form-control" required>

    <label>Job Description</label>
    <textarea name="description" class="form-control" required></textarea>

    <label>Requirements</label>
    <textarea name="requirements" class="form-control"></textarea>

    <label>Education</label>
    <textarea name="education" class="form-control"></textarea>

    <label>Skills</label>
    <textarea name="skills" class="form-control"></textarea>

    <label>Location</label>
    <textarea name="location" class="form-control"></textarea>

    <label>Job Image (optional)</label>
    <input type="file" name="image" class="form-control">

    <button class="btn btn-success mt-3">Post Job</button>


    </form>
</body>

</html>