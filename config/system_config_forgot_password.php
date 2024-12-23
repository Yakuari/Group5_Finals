<?php
session_start();
require_once __DIR__ . '/../database/dbh.php'; // Database connection

if (isset($_POST['submit'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $dbh = (new Dbh())->connect();
    // Check if the email exists in the database
    $stmt = $dbh->prepare("SELECT * FROM users WHERE user_email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token valid for 1 hour

        // Store the token in the database
        // $stmt = $dbh->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)");
        // $stmt->execute([$email, $token, $expiry]);

        // Send the reset link via email
        $resetLink = "https://ironforgegym.site/reset-password.php?id=".$user["id"]."token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the link to reset your password: " . $resetLink;

        // Use PHPMailer to send the email
        require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require '../vendor/phpmailer/phpmailer/src/SMTP.php';
        require '../vendor/phpmailer/phpmailer/src/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dominguezstephen01@gmail.com'; // Your email
        $mail->Password = 'dbjt hnsz vpzo zvei'; // Your email password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('dominguezstephen01@gmail.com', 'Iron Forge Gym');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
            echo "Reset link sent to your email.";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "Email not found.";
    }
}
?>