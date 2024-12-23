<?php
session_start();
require_once '../database/dbh.php'; // Database connection

if (isset($_POST['redeem_coupon'])) {
    $userId = $_SESSION["userid"];
    $couponCode = $_POST['coupon_code'];

    $database = new Dbh();
    $dbh = $database->connect();

    // Check if the coupon exists and is not redeemed
    $stmt = $dbh->prepare("SELECT * FROM coupons WHERE coupon_code = ? AND is_redeemed = 0");
    $stmt->execute([$couponCode]);
    $coupon = $stmt->fetch();

    if ($coupon) {
        // Update user with the coupon
        $updateStmt = $dbh->prepare("UPDATE users SET coupon = ?, coupon_active = 1 WHERE id = ?");
        if ($updateStmt->execute([$couponCode, $userId])) {
            // Mark the coupon as redeemed
            $redeemStmt = $dbh->prepare("UPDATE coupons SET is_redeemed = 1 WHERE id = ?");
            $redeemStmt->execute([$coupon['id']]);
            header("Location: ../user.php?message=Coupon redeemed successfully.");
            exit();
        } else {
            header("Location: ../user.php?error=Failed to redeem coupon.");
            exit();
        }
    } else {
        header("Location: ../user.php?error=Invalid or already redeemed coupon.");
        exit();
    }
}
?>