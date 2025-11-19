<?php
session_start();
include('db/db_connect.php');

if (!isset($_SESSION['user_id'])) {
  echo "Please log in.";
  exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM work_experience WHERE user_id = $user_id ORDER BY user_id DESC");

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "
      <div style='margin-bottom:10px; padding:8px; background:#f5f5f5; border-radius:6px;'>
        <strong>{$row['job_title']}</strong> at {$row['company']} <br>
        <small>{$row['duration']}</small><br>
        <button onclick=\"editWork({$row['id']}, '{$row['job_title']}', '{$row['company']}', '{$row['duration']}')\">✏️</button>
        <button onclick=\"deleteWork({$row['id']})\">🗑️</button>
      </div>
    ";
  }
} else {
  echo "<p>No work experience yet</p>";
}
?>
