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
            <form action="config/system_config_signIn.php" method="POST">
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
            <form action="config/system_config_signup.php" method="POST">
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
        <h1>BODY BUILDING PROGRAM</h1>
    </div>

    <!-- Exercise Sections -->
    <div class="body-building-choices">
        <img src="../src/css/images/incline.jpg" alt="Incline Bench Press">
        <div>
            <h1>Incline Bench Press</h1>
            <p>The incline bench press is a compound upper-body exercise that primarily targets the upper portion of the
                pectoral muscles (chest). It involves lying on a bench set at an incline (typically 15-45 degrees) and
                pressing a barbell or dumbbells upward.</p>
            <ul>
                <li><strong>Primary Muscles Worked:</strong> Upper pectorals, anterior deltoids, triceps brachii.</li>
                <li><strong>Benefit:</strong> Builds a well-rounded chest for a fuller, proportionate look.</li>
            </ul>
        </div>
    </div>

    <div class="body-building-choices">
        <img src="../src/css/images/latpulldown.jpg" alt="Lat Pulldown">
        <div>
            <h1>Lat Pulldown</h1>
            <p>The lat pulldown is a resistance training exercise that targets the latissimus dorsi muscles (large
                muscles of the back). Performed using a cable machine, it involves pulling a bar down towards your chest
                while keeping your torso upright.</p>
            <ul>
                <li><strong>Alternative:</strong> Mimics the motion of a pull-up for those who cannot yet perform them.</li>
            </ul>
        </div>
    </div>

    <div class="body-building-choices">
        <img src="../src/css/images/squat.jpg" alt="Squat">
        <div>
            <h1>Squat</h1>
            <p>The squat is a foundational compound exercise that involves lowering your body into a sitting position
                and then standing back up. It primarily targets the quadriceps, hamstrings, glutes, and core muscles.</p>
            <ul>
                <li><strong>Nickname:</strong> The "king of exercises."</li>
                <li><strong>Benefit:</strong> Builds lower body strength and improves functional strength for daily activities.</li>
            </ul>
        </div>
    </div>

    <div class="body-building-choices">
        <img src="../src/css/images/lateral-raise.jpg" alt="Lateral Raise">
        <div>
            <h1>Lateral Raise</h1>
            <p>The lateral raise is an isolation exercise that targets the deltoid muscles, particularly the lateral
                (side) head. It involves lifting dumbbells or other weights out to the sides until the arms are parallel
                to the ground.</p>
            <ul>
                <li><strong>Targets:</strong> Lateral deltoid muscles for shoulder width and a broader upper-body appearance.</li>
            </ul>
        </div>
    </div>

    <div class="body-building-choices">
        <img src="../src/css/images/deadlift.jpg" alt="Deadlift">
        <div>
            <h1>Deadlift</h1>
            <p>The deadlift is a compound strength exercise that involves lifting a barbell or other weight from the
                ground to hip level. It targets multiple muscle groups, including the lower back, glutes, hamstrings,
                quads, core, and grip.</p>
            <ul>
                <li><strong>Functional:</strong> Mimics real-life lifting movements, like picking objects off the ground.</li>
                <li><strong>Benefit:</strong> Builds full-body strength by engaging nearly every major muscle group.</li>
            </ul>
        </div>
    </div>

    <script src="../src/js/script1.js"></script>
</body>

</html>
