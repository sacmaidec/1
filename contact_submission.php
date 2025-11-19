<?php
session_start();
include 'db/db_connect.php'; // connect to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Thank you! Your message has been sent successfully.');
                window.location.href = 'letsconnect.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: letsconnect.php");
    exit();
}
?>
