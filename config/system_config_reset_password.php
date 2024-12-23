<?php
session_start();
require_once __DIR__ . '/../database/dbh.php'; // Database connection

if (isset($_POST['submit'])) {
    // Correctly assign the token from the POST request
    $dbh = (new Dbh())->connect();
    $token = $_POST['token'];
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']); // Get the confirm password

    // Check if new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        // Redirect back with an error message
        header("Location: ../reset-password.php?error=password_mismatch");
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // Validate the token
    // $stmt = $dbh->prepare("SELECT * FROM password_resets WHERE token = ? AND expiry > NOW()");
    // $stmt->execute([$token]);
    // $resetRequest = $stmt->fetch();

    // if ($resetRequest) {
        // Update the user's password
        $stmt = $dbh->prepare("UPDATE users SET user_pass = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $_POST['id']]);

        // Delete the token from the database
        // $stmt = $dbh->prepare("DELETE FROM password_resets WHERE token = ?");
        // $stmt->execute([$token]);

        // Redirect to index.php with a success message
        header("Location: ../index.php?message=password_reset_success");
        exit();
    // } else {
    //     echo "Invalid or expired token.";
    // }
}
?>