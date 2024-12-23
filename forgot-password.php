<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<body>
    <div class="wrapper">
        <h1>Forgot Password</h1>
        <form action="config/system_config_forgot_password.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="submit">Send Reset Link</button>
        </form>
    </div>
</body>
</html>