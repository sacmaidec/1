<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require '../db/db_connect.php';


$res = $conn->query("
    SELECT 
        j.id,
        j.title,
        COALESCE(c.name,'-') AS company,
        j.status,
        j.created_at,
        j.education,
        j.skills,
        j.location
    FROM jobs j
    LEFT JOIN companies c ON c.id = j.company_id
    ORDER BY j.created_at DESC
");

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body class="p-3">
    <h3>Jobs <a href="adminhome.php" class="btn btn-sm btn-secondary">Back</a> <a href="job_create.php" class="btn btn-sm btn-success">Add Job</a></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Company</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['company']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td><?= htmlspecialchars($row['education']) ?></td>
                    <td><?= htmlspecialchars($row['skills']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td>
                        <a href="job_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <form action="job_delete.php" method="POST" style="display:inline" onsubmit="return confirm('Delete this job?')">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>