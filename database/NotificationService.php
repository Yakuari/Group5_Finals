<?php
require_once '/dbh.php'; // Adjust the path to your Dbh class file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'path_to/PHPMailer/src/Exception.php';
require_once 'path_to/PHPMailer/src/PHPMailer.php';
require_once 'path_to/PHPMailer/src/SMTP.php';

class NotificationService extends Dbh
{
    public function sendExpirationNotifications()
    {
        try {
            // Define the notification window (e.g., 7 days before expiration)
            $currentDate = date('Y-m-d H:i:s');
            $notificationWindowStart = date('Y-m-d H:i:s', strtotime('+1 day')); // Notify 1 day before expiration
            $notificationWindowEnd = date('Y-m-d H:i:s', strtotime('+7 days')); // Notify up to 7 days before expiration

            // Fetch users with expiring subscriptions
            $sql = "SELECT id, user_email, expire_at FROM users 
                    WHERE expire_at BETWEEN :start AND :end";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['start' => $notificationWindowStart, 'end' => $notificationWindowEnd]);

            $users = $stmt->fetchAll();

            // Send notifications
            foreach ($users as $user) {
                $this->sendEmailNotification($user['user_email'], $user['expire_at']);
                $this->logNotification($user['id']);
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage(), 3, "../logs/db_errors.log");
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage(), 3, "../logs/general_errors.log");
        }
    }

    private function sendEmailNotification($email, $expireAt)
    {
        $mail = new PHPMailer(true);

        try {
            // Format the expiration date and time
            $formattedExpireAt = date('F j, Y, g:i A', strtotime($expireAt)); // Example: "March 3, 2024, 12:00 PM"

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'dominguezstephen01@gmail.com'; // Your email
            $mail->Password = 'dbjt hnsz vpzo zvei'; // Your password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('dominguezstephen01@gmail.com', 'serbisyong totoo');
            $mail->addAddress($email);

            // Email content
            $mail->Subject = 'Subscription Expiration Notice';
            $mail->Body = "Hello,\n\nYour subscription is set to expire on $formattedExpireAt. Please renew to continue enjoying our services.\n\nThank you.";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email Error: " . $mail->ErrorInfo, 3, "../logs/email_errors.log");
        }
    }

    private function logNotification($userId)
    {
        try {
            $sql = "INSERT INTO user_logs (user_id, action) VALUES (:user_id, 'notified')";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
        } catch (PDOException $e) {
            error_log("Log Error: " . $e->getMessage(), 3, "../logs/db_errors.log");
        }
    }
}

// To run the notification service
$notificationService = new NotificationService();
$notificationService->sendExpirationNotifications();
