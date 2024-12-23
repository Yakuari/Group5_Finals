<?php

class signIn extends signInQuery
{
    private $email;
    private $pass;

    public function __construct($email, $pass)
    {
        $this->email = $email;
        $this->pass = $pass;
    }

    public function signInUser()
    {
        // Step 1: Check for empty input
        if (!$this->emptyInput()) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        // Step 2: Call parent method to authenticate and set session
        $this->getUser($this->email, $this->pass);

        // Step 3: After authentication, check user type and redirect accordingly
        if ($_SESSION["user_role"] === "manager") {
            // Redirect to Manager dashboard or page
            echo "<script>alert('Welcome'); window.location.href = '../manager.php';</script>";
            exit();
        } elseif ($_SESSION["user_role"] === "user") {
            // Redirect to User dashboard or page
            echo "<script>alert('Welcome User'); window.location.href = '../user.php';</script>";
            exit();
        } elseif ($_SESSION["user_role"] === "admin") {
            // Redirect to Admin dashboard or page
            echo "<script>alert('Welcome Admin'); window.location.href = '../database/admin-dashboard-class.php';</script>";
            exit();
        } else {
            // Redirect if the user type is unrecognized
            echo "<script>alert('error'); window.location.href = '../';</script>";
            exit();
        }
    }

    private function emptyInput()
    {
        // Return false if any field is empty
        if (empty($this->email) || empty($this->pass)) {
            return false;
        }
        return true;
    }
}
