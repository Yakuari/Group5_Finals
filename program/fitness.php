<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bodybuilding Program</title>
    <link rel="stylesheet" href="../src/css/bodybuilding.css">
    
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
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../index.php#program">Program</a></li>
                    <li><a href="../index.php#subscription">Subscription</a></li>
                    <li><a href="../index.php#booking">Booking</a></li>
                    <li><a href="../index.php#about-us">About Us</a></li>
                </ul>
                <div class="nav-buttons">
                    <button id="show-login">Sign in</button>
                    <button id="show-signup">Sign Up</button>
                </div>
                <button class="menu-button" onclick="toggleSidebar()">☰</button>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <ul class="sidebar">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../index.php#program">Program</a></li>
            <li><a href="../index.php#subscription">Subscription</a></li>
            <li><a href="../index.php#booking">Booking</a></li>
            <li><a href="../index.php#about-us">About Us</a></li>
            <button class="sidebar-close-btn">&times;</button>
        </ul>

    <!-- Login Popup -->
    <div class="popup login-popup">
        <div class="close-btn">&times;</div>
        <div class="form">
            <form action="../config/system_config_signIn.php" method="POST">
                <h2>Sign In</h2>
                <div class="form-element">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-element">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="submit">Sign In</button>
                <div class="form-element">
                    <a href="forgot-password.php">FORGOT PASSWORD?</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Signup Popup -->
    <div class="popup signup-popup">
        <div class="close-btn">&times;</div>
        <div class="form">
            <form action="../config/system_config_signup.php" method="POST">
                <h2>Register Here</h2>
                <div class="form-element">
                    <input type="text" name="uid" placeholder="Username" required>
                </div>
                <div class="form-element">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-element">
                    <input type="password" name="password" placeholder="Password" required>
                    <select name="type">
                        <option value="user">User</option>
                    </select><br>
                </div>
                <div class="form-element">
                    <label for="months">How many Months:</label>
                    <input type="number" name="months" placeholder="Enter how many months" min="1" required>
                </div>
                <button type="submit" name="submit">Sign Up</button>
            </form>
        </div>
    </div>

    <div class="body-title">
        <h1>FITNESS CHALLENGE</h1>
    </div>

    <!-- Exercise Sections -->
    <div class="body-building-choices">
        <img src="../src/css/images/pushup.jpg" alt="Incline Bench Press">
        <div>
            <h1>Push Up</h1>
            <p>The push-up is a bodyweight exercise that involves lowering and raising your body while maintaining a straight line from head to heels. It primarily targets the chest, shoulders, triceps, and core.

Push-ups are one of the most versatile and widely performed exercises, requiring no equipment and offering variations for all fitness levels.</p>
            <ul>
                <li><strong>Strengthens Upper Body: Targets the chest, shoulders, and triceps.</li>

            </ul>
        </div>
    </div>

    <div class="body-building-choices">
    <img src="../src/css/images/squat1.jpg" alt="Lat Pulldown">
    <div>
        <h1>Squat</h1>
        <p>The squat is a foundational compound exercise that involves lowering your body into a sitting position and then standing back up. It primarily targets the quadriceps, hamstrings, glutes, and core muscles.</p>
        <p>Squats are often referred to as the "king of exercises" because they engage multiple muscle groups and improve functional strength for daily activities.</p>
        <ul>
            <li><strong>Builds Lower Body Strength:</strong> Strengthens the quads, hamstrings, and glutes.</li>
            <li><strong>Improves Functional Strength:</strong> Helps in performing daily activities efficiently.</li>
        </ul>
    </div>
</div>


    <div class="body-building-choices">
        <img src="../src/css/images/planks.jpg" alt="Squat">
        <div>
            <h1>Planks</h1>
            <p>The plank is a core-strengthening isometric exercise where you hold your body in a straight line, supported by your forearms (or hands) and toes. It primarily targets the abdominal muscles, back, and shoulders.

Planks are more effective than traditional sit-ups for building core strength and reducing the risk of back injuries.</p>
            <ul>
                <li><strong>Strengthens the Core</strong></li>
                <li><strong>Targets the abs, obliques, and lower back.</strong></li>
            </ul>
        </div>
    </div>

    <div class="body-building-choices">
        <img src="../src/css/images/jumping-jacks.jpg" alt="Lateral Raise">
        <div>
            <h1>Jumping Jacks</h1>
            <p>Jumping jacks are a full-body aerobic exercise that involves jumping to a position with legs spread wide and hands touching overhead, then returning to a standing position.

Jumping jacks are a classic cardio workout that can be done anywhere without equipment, making them a staple in fitness routines worldwide.</p>
            <ul>
                <li><strong>Boosts Cardiovascular</strong></li>
                <li><strong>Health:</strong>Increases heart rate and improves endurance.</li>
            </ul>
        </div>
    </div>

    <div class="body-building-choices">
        <img src="../src/css/images/pull-ups.jpg" alt="Deadlift">
        <div>
            <h1>Pull-Ups</h1>
            <p>Pull-ups are a compound upper-body exercise where you lift your body by pulling yourself up on a horizontal bar until your chin is above the bar. They primarily target the back, shoulders, and biceps.

Pull-ups are a benchmark for upper-body strength and require significant grip and core engagement to perform effectively.
</p>
            <ul>
                <li><strong>Strengthens Upper Body:</strong> Targets the latissimus dorsi, biceps, and traps</li>
            </ul>
        </div>
    </div>

    <script src="../src/js/script1.js"></script>
</body>

</html>
