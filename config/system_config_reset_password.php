<?php
session_start();
require_once __DIR__ . '/../database/dbh.php'; // Database connection

if (isset($_POST['submit'])) {
    // Correctly assign the token from the POST request
    $dbh = (new Dbh())->connect();
    $token = $_POST['token'];
    $newPassword = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);
    
    // Validate the token
    // $stmt = $dbh->prepare("SELECT * FROM password_resets WHERE token = ? AND expiry > NOW()");
    // $stmt->execute([$token]);
    // $resetRequest = $stmt->fetch();

    // if ($resetRequest) {
        // Update the user's password
        $stmt = $dbh->prepare("UPDATE users SET user_pass = ? WHERE id = ?");
        $stmt->execute([$newPassword, $_POST['id']]);

        // Delete the token from the database
        // $stmt = $dbh->prepare("DELETE FROM password_resets WHERE token = ?");
        // $stmt->execute([$token]);

        echo "Password has been reset successfully.";
    // } else {
    //     echo "Invalid or expired token.";
    // }
}
?>