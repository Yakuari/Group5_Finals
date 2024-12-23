<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $uid = $_POST['uid'];
    $type = $_POST['type'];
    $pass = $_POST['password'];
    $months = $_POST['months'];

    // Include required files
    include_once "../database/dbh.php";
    include_once "../database/signUp.query.php";
    include_once "../dashboard/authentication/admin-class.php";

    // Instantiate the Admin class
    $signup = new Admin($email, $uid, $type, $pass, $months, $amount);

    // Call the signupUser method to process the signup
    $signup->signupUser();
} else {
    // Redirect or handle cases where the form is not submitted
    header("location: ../index.php?error=formnotsubmitted");
    exit();
}

?>
