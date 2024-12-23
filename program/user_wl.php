<?php
session_start(); // Start the session
require_once '../database/dbh.php'; // Database connection

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bodybuilding Program</title>
    <link rel="stylesheet" href="../src/css/weightloss.css">
    <link rel="stylesheet" href="../src/css/dropdown_menu2.css">
    
</head>

<body>
    <header>
        <nav>
        <div class="logo-container">
                <img src="../src/css/images/logo.png" alt="logo" class="logo">
                <span class="logo-name">Iron Forge Gym</span>
            </div>
            <div class="nav-container">
                <ul class="nav-links">
                    <li><a href="../user_landing_page.php#home">Home</a></li>
                    <li><a href="../user_landing_page.php#program">Program</a></li>
                    <li><a href="../user_landing_page.php#subscription">Subscription</a></li>
                    <li><a href="../user_landing_page.php#booking">Booking</a></li>
                    <li><a href="../user_landing_page.php#about-us">About Us</a></li>
                </ul>
                <div class="nav-buttons">
                    <div class="dropdown">
                        <span>Menu</span>
                        <div class="dropdown-menu">
                            <a href="../user.php ">User  Profile</a>
                            <a href="../user.php?logout=true">Logout</a>
                        </div>
                    </div>
                </div>
                <button class="menu-button" onclick="toggleSidebar()">☰</button>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <ul class="sidebar">
            <li><a href="../user_landing_page.php#home">Home</a></li>
            <li><a href="../user_landing_page.php#program">Program</a></li>
            <li><a href="../user_landing_page.php#subscription">Subscription</a></li>
            <li><a href="../user_landing_page.php#booking">Booking</a></li>
            <li><a href="../user_landing_page.php#about-us">About Us</a></li>
            <button class="sidebar-close-btn">&times;</button>
        </ul>

    <div class="body-title">
        <h1>WEIGHT LOSS PROGRAM</h1>
    </div>

    <!-- Exercise Sections -->
    <div class="weight-loss-choices">
        <img src="../src/css/images/calorie-deficit.jpg" alt="Calorie Deficit">
        <div>
            <h1>Calorie Deficit</h1>
            <p>A calorie deficit is a state where you consume fewer calories than your body burns, leading to weight loss by forcing the body to use stored energy (fat) for fuel.

To lose 1 pound of body weight, a deficit of approximately 3,500 calories is generally required, though individual metabolic factors can influence results.</p>
            <ul>
                <li><strong>Facilitates Weight Loss: </strong>Encourages the body to burn stored fat for energy.</li>
        </div>
    </div>

    <div class="weight-loss-choices">
        <img src="../src/css/images/intermittent-fasting.jpg" alt="Intermittent Fasting">
        <div>
            <h1>Intermittent Fasting</h1>
            <p>Intermittent fasting (IF) is an eating pattern that alternates between periods of fasting and eating. It doesn’t focus on what you eat but rather when you eat. Common methods include the 16/8 method, eat-stop-eat, and the 5:2 diet.
</p>
            <ul>
                <li><strong>Weight Loss: </strong>Helps reduce calorie intake, increase fat burning, and improve metabolic rate.</li>
            </ul>
        </div>
    </div>

    <div class="weight-loss-choices">
        <img src="../src/css/images/cardio.jpg" alt="cardio">
        <div>
            <h1>Cardio</h1>
            <p> Cardio, short for cardiovascular exercise, involves rhythmic activities that increase your heart rate and breathing. Examples include running, cycling, swimming, and brisk walking.

Targets Heart and Lungs: Strengthens the cardiovascular system by improving heart and lung efficiency</p>
            <ul>
                <li><strong>Heart Health:</strong>Reduces risk of heart disease by improving blood circulation and lowering blood pressure.</li>
            </ul>
        </div>
    </div>

    <div class="weight-loss-choices">
        <img src="../src/css/images/strenght-training.jpg" alt="Strenght Training">
        <div>
            <h1>Streght Training</h1>
            <p> Strength training, also known as resistance training, involves exercises designed to improve muscle strength, power, and endurance using resistance like weights, bands, or bodyweight.</p>
            <ul>
                <li><strong>Muscle Development: </strong>Builds and tones muscles for improved strength and appearance.</li>
            </ul>
        </div>
    </div>

    <script src="../src/js/script1.js"></script>
</body>

</html>
