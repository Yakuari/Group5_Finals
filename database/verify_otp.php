<?php
session_start();
require_once __DIR__ . '/../dashboard/authentication/admin-class.php';

// Check if temp_user exists in the session
if (!isset($_SESSION['temp_user'])) {
    echo "<script>alert('Session expired or invalid access. Please register again.'); window.location.href = '../index.php';</script>";
    exit();
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get OTP input
    $inputOtp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING);

    // Initialize Admin object with correct parameters
    $tempUser = $_SESSION['temp_user'];
    $admin = new Admin(
        $tempUser['email'],
        $tempUser['uid'],
        $tempUser['role'],
        $tempUser['pass'],
        $tempUser['months'] ?? 0, // Default months if not set
        $tempUser['total'] ?? 0  // Default total if not set
    );

    // Verify OTP
    if ($admin->verifyOtp($inputOtp)) {
        // Success: Redirect to index page
        echo "<script>alert('Registration successful! Redirecting...'); window.location.href = '../index.php';</script>";
    } else {
        // Failure: Redirect back to OTP verification page
        echo "<script>alert('Invalid or expired OTP. Try again.'); window.location.href = 'verify_otp.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="../src/css/otp.css">
</head>

<body>
    <h1>Verify OTP</h1>
    <form method="POST">
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" id="otp" required>
        <button type="submit">Verify</button>
    </form>
</body>

</html>