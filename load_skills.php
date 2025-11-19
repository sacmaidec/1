<?php
session_start();
include('db/db_connect.php');

if (!isset($_SESSION['user_id'])) {
  echo "Please log in.";
  exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM skills WHERE user_id = $user_id ORDER BY user_id DESC");

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "
      <div style='margin-bottom:10px; padding:8px; background:#f5f5f5; border-radius:6px;'>
        <strong>{$row['skill_name']}</strong> 
        <button onclick=\"editSkill({$row['id']}, '{$row['skill_name']}')\">✏️</button>
        <button onclick=\"deleteSkill({$row['id']})\">🗑️</button>
      </div>
    ";
  }
} else {
  echo "<p>No work experience yet</p>";
}
?>
