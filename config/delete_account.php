<?php
session_start();
require_once '../database/dbh.php'; // Database connection

if (isset($_POST['delete_account'])) {
    $userId = $_SESSION["userid"];

 $database = new Dbh();
    $dbh = $database->connect();

    // Delete user from the database
    $stmt = $dbh->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$userId])) {
        session_destroy(); // Destroy session after account deletion
        header("Location: ../index.php?message=Account deleted successfully.");
        exit();
    } else {
        header("Location: ../user.php?error=Failed to delete account.");
        exit();
    }
}