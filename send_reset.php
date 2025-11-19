<?php
require 'db_connect.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50)); // Secure random token
    $expires = date("U") + 3600; // 1 hour from now

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete old tokens
        $conn->query("DELETE FROM password_resets WHERE email='$email'");
        // Insert new token
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $email, $token, $expires);
        $stmt->execute();

        // Send Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'youremail@gmail.com'; // change this
            $mail->Password = 'your_app_password';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('youremail@gmail.com', 'KM Services');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $resetLink = "http://localhost/kmservices/reset_password.php?token=$token";
            $mail->Subject = "Password Reset Request";
            $mail->Body = "Click the link below to reset your password:<br><br>
                          <a href='$resetLink'>$resetLink</a><br><br>
                          This link will expire in 1 hour.";

            $mail->send();
            echo "<script>alert('Password reset link sent to your email.'); window.location='login.php';</script>";
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email not found!'); window.location='forgot_password.php';</script>";
    }
}
?>
