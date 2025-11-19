<?php
header("Content-Type: application/json");
require_once("../db/db_connect.php");

$sql = "SELECT * FROM jobs ORDER BY id DESC";
$result = $conn->query($sql);

$response = [];

if (!$result) {
    echo json_encode(["error" => "Query failed"]);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $response[] = $row;
}

echo json_encode($response);
