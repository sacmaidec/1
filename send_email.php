<?php
// send_email.php
// Usage: include 'send_email.php'; $res = sendRegistrationEmail($email, $firstname);
// returns ['ok' => true] or ['ok' => false, 'error' => '...']

// --- CONFIGURATION ---
// Change these to your sending Gmail account and the app password you created.
const SMTP_USER = 'katrinaricafort8@gmail.com';
const SMTP_APP_PASSWORD = 'ponq elxi wqez zbbl'; // 16-char app password from Google
const SMTP_FROM_NAME = 'KM Services';

// where email debug will be written (make sure web server can write here)
const DEBUG_LOG = __DIR__ . '/email_debug.log';

date_default_timezone_set('Asia/Manila');


// Try Composer autoload first (preferred)
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
    // PHPMailer classes will be autoloaded
} else {
    // Fallback to manual includes if you downloaded phpmailer into phpmailer/src
    if (file_exists(__DIR__ . '/phpmailer/src/Exception.php')) {
        require __DIR__ . '/phpmailer/src/Exception.php';
        require __DIR__ . '/phpmailer/src/PHPMailer.php';
        require __DIR__ . '/phpmailer/src/SMTP.php';
    } else {
        file_put_contents(DEBUG_LOG, "[".date('Y-m-d H:i:s')."] PHPMailer not found. Put composer autoload or phpmailer/src in project.\n", FILE_APPEND);
        return function($email, $firstname = '') {
            return ['ok' => false, 'error' => 'PHPMailer not found on server.'];
        };
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendRegistrationEmail($email, $firstname = '') {
    // Basic validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid recipient email: " . var_export($email, true);
        file_put_contents(DEBUG_LOG, "[".date('Y-m-d H:i:s')."] $msg\n", FILE_APPEND);
        return ['ok' => false, 'error' => $msg];
    }

    $mail = new PHPMailer(true);

    // Turn on debug into file (so page doesn't break for users)
    $mail->SMTPDebug = 2;                 // 0 = off, 2 = client+server
    $mail->Debugoutput = function($str, $level) {
        file_put_contents(DEBUG_LOG, "[".date('Y-m-d H:i:s')."] DEBUG($level): $str\n", FILE_APPEND);
    };

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_APP_PASSWORD;
        // use STARTTLS on 587 — better for localhost
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => false,
            ],
        ];

        // From / To
        $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to KM Services';
        $body = "Hi " . htmlspecialchars($firstname) . ",<br><br>";
        $body .= "Thank you for registering at KM Services.<br><br>";
        $body .= "Regards,<br>KM Services Team";
        $mail->Body = $body;

        // send
        if ($mail->send()) {
            file_put_contents(DEBUG_LOG, "[".date('Y-m-d H:i:s')."] Email sent to $email\n", FILE_APPEND);
            return ['ok' => true];
        } else {
            $err = $mail->ErrorInfo;
            file_put_contents(DEBUG_LOG, "[".date('Y-m-d H:i:s')."] Email NOT sent to $email — ErrorInfo: $err\n", FILE_APPEND);
            return ['ok' => false, 'error' => $err];
        }
    } catch (Exception $e) {
        $err = $mail->ErrorInfo ?? $e->getMessage();
        file_put_contents(DEBUG_LOG, "[".date('Y-m-d H:i:s')."] Exception sending to $email — $err\n", FILE_APPEND);
        return ['ok' => false, 'error' => $err];
    }
}
?>