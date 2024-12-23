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

// Subscription purchase logic
if (isset($_POST['buy_subscription'])) {
    if ($user['subscription'] !== null) {
        echo "<script>alert('You already have a subscription.');</script>";
    } else {
        // Update subscription in the database
        $subscriptionType = $_POST['subscription_type'];
        $stmt = $dbh->prepare("UPDATE users SET subscription = ?, user_month = 4 WHERE id = ?"); // Assuming 4 months for simplicity
        $stmt->execute([$subscriptionType, $userId]);
        echo "<script>alert('You have bought the subscription.');</script>";
        header("Refresh:0"); // Refresh the page to update the displayed information
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Landing Page</title>
    <link rel="stylesheet" href="src/css/styles.css">
    <link rel="stylesheet" href="src/css/nav.css">
    <link rel="stylesheet" href="src/css/booking.css">
    <link rel="stylesheet" href="src/css/about_us.css">
    <link rel="stylesheet" href="src/css/dropdown_menu2.css"> <!-- Link to the user dashboard CSS -->
</head>
<body>
    <header>
        <nav>
            <div class="logo-container">
                <img src="src/css/images/logo.png" alt="logo" class="logo">
                <span class="logo-name">Iron Forge Gym</span>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#program">Program</a></li>
                <li><a href="#subscription">Subscription</a></li>
                <li><a href="#booking">Booking</a></li>
                <li><a href="#about-us">About Us</a></li>
            </ul>
            <div class="nav-buttons">
                <div class="dropdown">
                    <span>Menu</span>
                    <div class="dropdown-menu">
                        <a href="user.php">User Profile</a>
                        <a href="user.php?logout=true">Logout</a>
                    </div>
                </div>
            </div>
            <button class="menu-button" onclick="toggleSidebar()">☰</button>
        </nav>
    </header>

    <!-- Sidebar -->
    <ul class="sidebar">
        <li><a href="#home">Home</a></li>
        <li><a href="#program">Program</a></li>
        <li><a href="#subscription">Subscription</a></li>
        <li><a href="#booking">Booking</a></li>
        <li><a href="#about-us">About Us</a></li>
        <button class="sidebar-close-btn">&times;</button>
    </ul>

    <main id="home">
        <section class="content">
            <h1>Welcome to Iron Forge Gym,</h1>
            <p>Your fitness journey starts here. From effortless class bookings to personalized progress tracking,
                we've got everything you need to stay on top of your game.
                Explore, engage, and unlock your full potential.
                Remember, strong today, stronger tomorrow!</p>
        </section>
    </main>

    <!-- Program Titles -->
<div class="program-title" id="program">
    <h1>Iron Forge Gym Programs</h1>
</div>

<section class="program-section">
        <div class="program-link">
            <a href="program/user_bb.php" class="link">
                <h1> Bodybuilding Programs</h1>
                <p>Designed to help you build muscle, improve strength, and sculpt your physique with tailored workouts and expert guidance.</p>
            </a>

            <a href="program/user_fit.php" class="link">
                <h1>Fitness Challenges</h1>
                <p>Engaging and fun competitions that motivate you to break barriers, improve performance, and achieve milestones.</p>
            </a>

            <a href="program/user_wl.php" class="link">
                <h1>Weight Loss Programs</h1>
                <p>Focused on shedding pounds and boosting confidence through customized training, balanced nutrition, and ongoing support.</p>
            </a>
        </div>
    </section>

    <!-- Subscription Link -->
    <div class="subscription-link" id="subscription">
        <h1>Subscription Plan and Pricing</h1>

        <!-- Slider container for subscription plans -->
        <div class ="slider">
            <!-- Slider Content (All Subscription Plans) -->
            <div class="slider-content">
                <!-- Bronze Subscription -->
                <div class="subscription">
                    <h2>Bronze Subscription</h2>
                    <h3>Core Power Membership</h3>
                    <p>Includes:</p>
                    <ul>
                        <li>Cardio Machines</li>
                        <li>Weights</li>
                        <li>Basic Equipment</li>
                    </ul>
                    <p>Additional Charges</p>
                    <ul>
                        <li>None or small fee for classes</li>
                    </ul>
                    <div class="price">
                        <p>Total Discount: 500</p>
                        <p>Original Price: 1000</p>
                        <p>Discount Price: 500</p>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="subscription_type" value="bronze">
                        <button type="submit" name="buy_subscription">Buy Subscription</button>
                    </form>
                </div>

                <!-- Silver Subscription -->
                <div class="subscription">
                    <h2>Silver Subscription</h2>
                    <h3>Strength & Stamina Pass</h3>
                    <p>Includes:</p>
                    <ul>
                        <li>All Gym Access</li>
                        <li>Unlimited classes (e.g., yoga, spinning)</li>
                    </ul>
                    <p>Additional Charges</p>
                    <ul>
                        <li>Personal training, massage, or specialty services may cost extra</li>
                    </ul>
                    <div class="price">
                        <p>Total Discount: 1400</p>
                        <p>Original Price: 2700</p>
                        <p>Discount Price: 1400</p>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="subscription_type" value="silver">
                        <button type="submit" name="buy_subscription">Buy Subscription</button>
                    </form>
                </div>

                <!-- Gold Subscription -->
                <div class="subscription">
                    <h2>Gold Subscription</h2>
                    <h3>Empowerment Essentials Package</h3>
                    <p>Includes:</p>
                    <ul>
                        <li>VIP access to events</li>
                        <li>Priority booking for classes</li>
                        <li>All services (classes, personal training, amenities)</li>
                    </ul>
                    <p>Additional Charges</p>
                    <ul>
                        <li>Sometimes still applies for very exclusive services</li>
                    </ul>
                    <div class="price">
                        <p>Total Discount: 2500</p>
                        <p>Original Price: 5000</p>
                        <p>Discount Price: 2500</p>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="subscription_type" value="gold">
                        <button type="submit" name="buy_subscription">Buy Subscription</button>
                    </form>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button class="arrow left" onclick="moveSlide(-1)">&#10094;</button>
            <button class="arrow right" onclick="moveSlide(1)">&#10095;</button>
        </div>
    </div>

    <script>
        // JavaScript to control slider movement
        let currentIndex = 0;

        function moveSlide(direction) {
            const sliderContent = document.querySelector('.slider-content');
            const totalSlides = document.querySelectorAll('.subscription').length;

            currentIndex += direction;

            // Loop back to the first or last slide when reaching the end
            if (currentIndex < 0) {
                currentIndex = totalSlides - 1;
            } else if (currentIndex >= totalSlides) {
                currentIndex = 0;
            }

            const newTransformValue = -currentIndex * 100; // Move to the next slide
            sliderContent.style.transform = `translateX(${newTransformValue}%)`;
        }
    </script>

    <!-- Booking Section -->
    <div class="booking_section" id="booking">
        <div class="booking_top">
            <h1>Make a Booking</h1>
            <p>Unlock Your Full Potential and Transform Your Fitness Journey – Book Your Spot at Our Gym Today and Start Achieving Your Goals!</p>
        </div>

        <div class="booking_form">
            <form action="config/system_config_booking.php" method="POST">
                <div class="booking-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="booking-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="booking-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="booking-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="booking-group">
                    <button type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- About Us Section -->
    <div class="about-us-title" id="about-us">
        <h1>ABOUT US</h1>
    </div>

    <section class="about-us-container">
        <!-- Our Story Section -->
        <div class="about-us-story">
            <h2>OUR STORY</h2>
            <p>
                Established in 2024, Iron Forge Gym started as a small community gym with a big dream:
                to make high-quality fitness accessible to everyone.
                Today, we’ve grown into a vibrant hub for fitness enthusiasts of all levels,
                offering state-of-the-art facilities and a supportive environment.
            </p>
        </div>

        <!-- What Drives Us Forward Section -->
        <div class="about-us-mission">
            <h2>What Drives Us Forward</h2>
            <p>
                At Iron Forge Gym, we are passionate about promoting health, fitness, and overall well-being.
                Our journey began with the belief that everyone deserves a supportive environment
                to achieve their fitness goals and lead a healthier lifestyle.
            </p>
        </div>

        <!-- Join Our Community Section -->
        <div class="about-us-join">
            <h2>JOIN OUR COMMUNITY</h2>
            <p>
                At Iron Forge Gym, you’re not just a member; you’re part of a family.
                We’re here to guide, motivate, and celebrate your progress every step of the way.
                Whether you're a beginner or a seasoned athlete, we have something for everyone.
            </p>
        </div>

        <!-- Contact Us Section -->
        <div class="about-us-contacts">
            <h2>CONTACT US</h2>
            <p><strong>Phone:</strong> +1 800 123 4567</p>
            <p><strong>Email:</strong> contact@ironforgegym.com</p>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank" aria-label="Facebook">
                    <img src="src/css/images/fb_logo.png" alt="Logo" width="30">
                </a>
                <a href="https://www.youtube.com" target="_blank" aria-label="YouTube">
                    <img src="src/css/images/yt_logoo.png" alt="Logo" width="30">
                </a>
                <a href="https://www.instagram.com" target="_blank" aria-label="Instagram">
                    <img src="src/css/images/ig_logo.png" alt="Logo" width="30">
                </a>
                <a href="https://twitter.com" target="_blank" aria-label="Twitter">
                    <img src="src/css/images/tt_logo.png" alt="Logo" width="30">
                </a>
            </div>
        </div>
    </section>

</body>

    <script src="src/js/script.js"></script>

</html>