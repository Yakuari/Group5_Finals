<?php
session_start();
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<body>
    <div class="wrapper">
        <h1>Reset Password</h1>
        <form action="config/system_config_reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            <button type="submit" name="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>