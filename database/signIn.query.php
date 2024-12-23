<?php 
class signInQuery extends Dbh {
    protected function getUser($email, $pass) {
        // Query to get user details by email, including user_type
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_email = ?;');
        
        if (!$stmt->execute([$email])) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        // Check if the user exists
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../index.php?error=usernotfound");
            exit();
        }

        // Fetch user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;

        // Verify password
        if (!password_verify($pass, $user['user_pass'])) {
            header("location: ../index.php?error=wrongpassword");
            exit();
        }

        // Start session and set session variables
        session_start();
        $_SESSION["userid"] = $user["id"];  // Update key if primary key is not `id`
        $_SESSION["useruid"] = $user["user_uid"];
        $_SESSION["user_role"] = $user["user_role"];  // Storing user_type in session
    }
}
?>