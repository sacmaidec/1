<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require '../db/db_connect.php';

$id = (int)($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($id <= 0) header('Location: jobs_list.php');
    $s = $conn->prepare("SELECT j.*, COALESCE(c.name,'') AS company FROM jobs j LEFT JOIN companies c ON c.id = j.company_id WHERE j.id = ?");
    $s->bind_param('i', $id);
    $s->execute();
    $res = $s->get_result();
    $job = $res->fetch_assoc();
    if (!$job) {
        header('Location: jobs_list.php');
        exit;
    }
?>
    <!doctype html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Edit Job</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>

    <body class="p-3">
        <h3>Edit Job <a href="jobs_list.php" class="btn btn-sm btn-secondary">Back</a></h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($job['id']) ?>">
            <div><label>Company name</label><input name="company_name" class="form-control" value="<?= htmlspecialchars($job['company']) ?>" required></div>
            <div><label>Title</label><input name="title" class="form-control" value="<?= htmlspecialchars($job['title']) ?>" required></div>
            <div><label>Description</label><textarea name="description" class="form-control"><?= htmlspecialchars($job['description']) ?></textarea></div>
            <div><label>Requirements</label><textarea name="requirements" class="form-control"><?= htmlspecialchars($job['requirements']) ?></textarea></div>
            <div><label>Education</label><textarea name="education" class="form-control"><?= htmlspecialchars($job['education']) ?></textarea></div>
            <div><label>Skills</label><textarea name="skills" class="form-control"><?= htmlspecialchars($job['skills']) ?></textarea></div>
            <div><label>Location</label><textarea name="location" class="form-control"><?= htmlspecialchars($job['location']) ?></textarea></div>
    
            <div class="mt-2"><button class="btn btn-primary">Update</button></div>
        </form>
    </body>

    </html>
<?php
    exit;
}

// POST -> update
$id = (int)($_POST['id'] ?? 0);
$company_name = trim($_POST['company_name'] ?? '');
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$requirements = trim($_POST['requirements'] ?? '');
if ($id <= 0 || $company_name === '' || $title === '') {
    die('Invalid data');
}

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

// optional image replace
$imagePath = null;
if (!empty($_FILES['image']['tmp_name'])) {
    $upDir = __DIR__ . '/../uploads/jobs/';
    if (!is_dir($upDir)) mkdir($upDir, 0755, true);
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fname = 'job_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $upDir . $fname)) {
        $imagePath = 'uploads/jobs/' . $fname;
    }
}

// build update query
if ($imagePath !== null) {
    $u = $conn->prepare("UPDATE jobs SET company_id=?, title=?, description=?, requirements=?, image=?, updated_at=NOW() WHERE id=?");
    $u->bind_param('issssi', $company_id, $title, $description, $requirements, $imagePath, $id);
} else {
    $u = $conn->prepare("UPDATE jobs SET company_id=?, title=?, description=?, requirements=?, updated_at=NOW() WHERE id=?");
    $u->bind_param('isssi', $company_id, $title, $description, $requirements, $id);
}
$ok = $u->execute();
if ($ok) {
    $msg = "Job updated: {$title}";
    $act = $conn->prepare("INSERT INTO activities (type, message, related_id) VALUES (?, ?, ?)");
    $type = 'job_update';
    $act->bind_param('ssi', $type, $msg, $id);
    $act->execute();
    $act->close();
    header('Location: jobs_list.php?updated=1');
    exit;
} else {
    echo 'DB error: ' . $u->error;
}
?>