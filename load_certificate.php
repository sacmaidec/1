<?php
session_start();
include('db/db_connect.php');

// Correct session key
if (!isset($_SESSION['user_id'])) {
    echo "Please log in.";
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Use a simple query (or prepared if you need filters)
$sql = "SELECT * FROM certificates WHERE user_id = $user_id ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    echo "SQL Error: " . htmlspecialchars($conn->error);
    exit;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        // Use the correct column name (no trailing space)
        $certificate_name = htmlspecialchars($row['certificate_name']);
        $issued_by = htmlspecialchars($row['issued_by']);

        // Use json_encode to safely embed JS string literals (handles quotes, newlines, etc.)
        $jsCertName = json_encode($row['certificate_name']);
        $jsIssuedBy = json_encode($row['issued_by']);
        $id = intval($row['id']);

        echo "
        <div style='margin-bottom:10px; padding:8px; background:#f5f5f5; border-radius:6px;'>
            <strong>{$certificate_name}</strong> — {$issued_by} <br>
            <button onclick=\"editCertificate({$id}, {$jsCertName}, {$jsIssuedBy})\">✏️</button>
            <button onclick=\"deleteCertificate({$id})\">🗑️</button>
        </div>
        ";
    }
} else {
    echo "<p>No certificates added yet.</p>";
}
?>
