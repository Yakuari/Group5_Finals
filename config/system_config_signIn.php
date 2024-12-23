<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Include required files
    include_once "../database/dbh.php";
    include_once "../database/signIn.query.php";
    include_once "../dashboard/authentication/signIn.php";

    // Instantiate the Admin class
    $signin = new signIn($email, $pass);

    // Call the signupUser method to process the signup
    $signin->signInUser();
} else {
    // Redirect or handle cases where the form is not submitted
    header("location: ../index.php?error=formnotsubmitted");
    exit();
}
?>
