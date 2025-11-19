<?php
session_start();
include('db/db_connect.php');

// Correct session key
if (!isset($_SESSION['user_id'])) {
    echo "Please log in.";
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Check query and catch SQL errors
$sql = "SELECT * FROM education WHERE user_id = $user_id ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    echo "SQL Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        // Escape values to prevent broken HTML
        $school = htmlspecialchars($row['school']);
        $degree = htmlspecialchars($row['degree']);
        $year = htmlspecialchars($row['year']);

        echo "
        <div style='margin-bottom:10px; padding:8px; background:#f5f5f5; border-radius:6px;'>
            <strong>$degree</strong> at $school <br>
            <small>$year</small><br>

            <button onclick=\"editEducation({$row['id']}, '$school', '$degree', '$year')\">✏️</button>
            <button onclick=\"deleteEducation({$row['id']})\">🗑️</button>
        </div>
        ";
    }
} else {
    echo "<p>No Education added yet.</p>";
}
?>
