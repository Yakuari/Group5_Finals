<?php
session_start(); // Start the session
require_once 'database/dbh.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION["useruid"])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

// Fetch user data
$userId = $_SESSION["userid"];
$database = new Dbh();
$dbh = $database->connect();

// Fetch user details
$stmt = $dbh->prepare("SELECT * FROM users WHERE id = ? AND status = 'accepted'");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    echo "Account not found or not accepted.";
    exit();
}

// Calculate remaining time until subscription expires
$remainingTime = ($user['user_month'] * 30) - (time() - strtotime($user['created_at'])) / (60 * 60 * 24);
$remainingTime = max(0, $remainingTime); // Ensure it doesn't go negative

// Calculate total spent after coupon discount
$totalSpent = $user['user_amount'];
if ($user['coupon_active']) {
    $totalSpent *= 0.7; // Apply 30% discount
}

// Determine coupon status
$couponStatus = $user['coupon_active'] ? "Yes" : "No";
$couponCode = $user['coupon'] ?: "N/A";

// Check if the user is eligible for a new coupon
$stmt = $dbh->prepare("SELECT coupon_code FROM coupons WHERE user_id = ? AND is_redeemed = 0");
$stmt->execute([$userId]);
$newCoupon = $stmt->fetch();

if (!$newCoupon) {
    // Generate a new coupon if the user does not have one
    $newCouponCode = generateCoupon($userId, $dbh);

    // Show the coupon in a popup without assigning it to the user yet
    echo "<script>
        window.onload = function() {
            alert('Here is your coupon code: $newCouponCode. Use it to get a 30% discount when you redeem it!');
        };
    </script>";
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to login page
    exit();
}

// Subscription purchase logic
if (isset($_POST['buy_subscription'])) {
    if ($user['subscription'] !== null) {
        echo "<script>alert('You already have a subscription.');</script>";
    } else {
        $subscriptionType = $_POST['subscription_type'];
        $stmt = $dbh->prepare("UPDATE users SET subscription = ?, user_month = 4 WHERE id = ?");
        $amountSpent = ($subscriptionType === 'bronze') ? 500 : (($subscriptionType === 'silver') ? 1400 : 2500);
        $stmt->execute([$subscriptionType, $userId]);
        echo "<script>alert('You have bought the subscription.');</script>";
        header("Refresh:0"); // Refresh the page to update the displayed information
    }
}

// Function to generate a coupon
function generateCoupon($userId, $dbh) {
    $couponCode = "WELCOME" . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)); // Example coupon code
    $stmt = $dbh->prepare("INSERT INTO coupons (coupon_code, user_id, is_redeemed) VALUES (?, ?, 0)");
    $stmt->execute([$couponCode, $userId]);
    return $couponCode;
}

// Redemption logic
if (isset($_POST['redeem_coupon'])) {
    $enteredCouponCode = $_POST['coupon_code'];

    // Check if the coupon exists and is not redeemed
    $stmt = $dbh->prepare("SELECT * FROM coupons WHERE coupon_code = ? AND user_id = ? AND is_redeemed = 0");
    $stmt->execute([$enteredCouponCode, $userId]);
    $coupon = $stmt->fetch();

    if ($coupon) {
        // Mark the coupon as redeemed
        $redeemStmt = $dbh->prepare("UPDATE coupons SET is_redeemed = 1 WHERE id = ?");
        $redeemStmt->execute([$coupon['id']]);

        // Update user record to activate the coupon
        $updateUserStmt = $dbh->prepare("UPDATE users SET coupon = ?, coupon_active = 1 WHERE id = ?");
        $updateUserStmt->execute([$enteredCouponCode, $userId]);

        header("Location: user.php?message=Coupon redeemed successfully.");
        exit();
    } else {
        header("Location: user.php?error=Invalid or already redeemed coupon.");
        exit();
    }
}
?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Dashboard</title>
            <link rel="stylesheet" href="src/css/styles.css">
            <link rel="stylesheet" href="src/css/nav.css">
            <link rel="stylesheet" href="src/css/user-dashboard.css"> <!-- Link to the new CSS file -->
            <script>
                window.onbeforeunload = function() {
                    return "Are you sure you want to logout?";
                };
        
                window.onpopstate = function(event) {
                    if (confirm("Are you sure you want to logout?")) {
                        window.location.href = "user.php?logout=true"; // Log out the user
                    } else {
                        history.pushState(null, null, location.href); // Prevent going back
                    }
                };
        
                // Prevent going back to the previous page
                history.pushState(null, null, location.href);
            </script>
        </head>
        <body>
            <header>
                <nav>
                    <div class="logo-container">
                        <img src="src/css/images/logo.png" alt="logo" class="logo">
                        <span class="logo-name">Iron Forge Gym</span>
                    </div>
                    <ul class="nav-links">
                        <li><a href="user_landing_page.php#home">Home</a></li>
                        <li><a href="user_landing_page.php#program">Program</a></li>
                        <li><a href="user_landing_page.php#subscription">Subscription</a></li>
                        <li><a href="user_landing_page.php#booking">Booking</a></li>
                        <li><a href="user_landing_page.php#about-us">About Us</a></li>
                    </ul>
                    <div class="nav-buttons">
                        <div class="dropdown">
                            <span>Menu</span>
                            <div class="dropdown-menu">
                                <a href="user.php">User  Profile</a>
                                <a href="user.php?logout=true">Logout</a>
                            </div>
                        </div>
                    </div>
                    <button class="menu-button" onclick="toggleSidebar()">☰</button>
                </nav>
            </header>
        
            <!-- Sidebar -->
            <ul class="sidebar">
                <li><a href="user_landing_page.php#home">Home</a></li>
                <li><a href="user_landing_page.php#program">Program</a></li>
                <li><a href="user_landing_page.php#subscription">Subscription</a></li>
                <li><a href="user_landing_page.php#booking">Booking</a></li>
                <button class="sidebar-close-btn">&times;</button>
            </ul>
        
            <div class="wrapper">
                <h1>Welcome, <?= htmlspecialchars($_SESSION["useruid"]); ?>!</h1>
                
                <!-- User Details Table -->
                <table class="dashboard-table">
                    <caption>User Details</caption>
                    <tr>
                        <th>Joined On</th>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                    <tr>
                        <th>Subscription Class</th>
                        <td><?= $user['subscription'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <th>Coupon Active</th>
                        <td><?= $couponStatus ?></td>
                    </tr>
                    <tr>
                        <th>Coupon Code</th>
                        <td><?= $couponCode ?></td>
                    </tr>
                    <tr>
                        <th>Remaining Time (days)</th>
                        <td><?= $remainingTime ?></td>
                    </tr>
                    <tr>
                        <th>Total Amount Spent</th>
                        <td>₱<?= number_format($totalSpent, 2) ?></td>
                    </tr>
                </table>
        
                        <!-- Other Forms and Actions -->
        <form action="config/delete_account.php" method="POST">
            <button type="submit" name="delete_account">Delete Account</button>
        </form>

        <form method="POST">
            <h2>Buy Subscription</h2>
            <select name="subscription_type" required>
                <option value="">Select Subscription</option>
                <option value="bronze">Bronze</option>
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
            </select>
            <button type="submit" name="buy_subscription">Buy Subscription</button>
        </form>

        <!-- Message Display -->
        <?php if (isset($_GET['message'])): ?>
            <div class="message success"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="message error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <!-- Coupon Section -->
        <div class="coupon-section">
            <h2>Redeem Your Coupon</h2>
            <form action="user.php" method="POST">
                <input type="text" name="coupon_code" placeholder="Enter your coupon code" required>
                <button type="submit" name="redeem_coupon">Redeem Coupon</button>
            </form>
        </div>
    </div>

    <script src="src/js/script.js"></script>
</body>
</html>