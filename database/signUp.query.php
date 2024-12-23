<?php
require_once __DIR__ . '/dbh.php';

class signUp extends Dbh {
    protected function setUser($uid, $pass, $email, $role, $amount, $month) {
        $stmt = $this->connect()->prepare(
            'INSERT INTO users (user_uid, user_pass, user_email, user_role, user_amount, user_month) 
            VALUES (?, ?, ?, ?, ?, ?)'
        );

        // Hash the password securely
        $hashedPwd = password_hash($pass, PASSWORD_DEFAULT);

        // Execute the statement with all required parameters
        if (!$stmt->execute([$uid, $hashedPwd, $email, $role, $amount, $month])) {
            $stmt = null; // Close the statement
            header("location: ../index.php?error=stmtfailed_setUser");
            exit();
        }

        $stmt = null; // Explicitly close the statement
    }

    protected function checkUser($uid, $email) {
        $stmt = $this->connect()->prepare(
            'SELECT user_uid FROM users WHERE user_uid = ? OR user_email = ?'
        );

        // Execute the statement
        if (!$stmt->execute([$uid, $email])) {
            $stmt = null; // Close the statement
            header("location: ../index.php?error=stmtfailed_checkUser");
            exit();
        }

        // Check if the user exists
        $userExists = $stmt->rowCount() > 0;
        $stmt = null; // Explicitly close the statement

        return !$userExists; // Return true if the user does not exist
    }
}