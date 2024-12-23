<?php
session_start();
require_once __DIR__ . '/database/dbh.php';

class BookingManager extends Dbh
{
    // Method to fetch all bookings
    public function getBookings()
    {
        $sql = "SELECT id, name, phone, email, booking_date FROM bookings ORDER BY booking_date DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Method to delete a booking by ID
    public function deleteBooking($bookingId)
    {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$bookingId]);
    }

    // Method to fetch all users with user_role = 'user'
    public function getUsers()
    {
        $sql = "SELECT id, user_uid, user_email, subscription, coupon_active, created_at, expire_at, user_month, status FROM users WHERE user_role = 'user'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Check if a user is already processed
    public function isUserProcessed($userId)
    {
        $sql = "SELECT status FROM users WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        return $user && $user['status'] !== null; // Processed if status is not null
    }

    // Accept a user and calculate expiration date
    public function acceptUser($userId)
    {
        if ($this->isUserProcessed($userId)) {
            header("Location: manager.php?error=already_processed");
            exit();
        }

        $sql = "SELECT user_month FROM users WHERE id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch();

        if ($user) {
            $userMonth = (int)$user['user_month'];
            $daysToAdd = $userMonth * 30; // Each month corresponds to 30 days
            $expireAt = date('Y-m-d H:i:s', strtotime("+$daysToAdd days"));

            // Update user's expiration date and status
            $updateSql = "UPDATE users SET expire_at = :expire_at, status = 'accepted', created_at = NOW() WHERE id = :user_id";
            $updateStmt = $this->connect()->prepare($updateSql);
            $updateStmt->execute(['expire_at' => $expireAt, 'user_id' => $userId]);

            // Log the action
            $logSql = "INSERT INTO user_logs (user_id, action) VALUES (:user_id, 'accepted')";
            $logStmt = $this->connect()->prepare($logSql);
            $logStmt->execute(['user_id' => $userId]);
        } else {
            throw new Exception("User not found.");
        }
    }

    // Reject a user and update the status
    public function rejectUser($userId)
    {
        if ($this->isUserProcessed($userId)) {
            header("Location: manager.php?error=already_processed");
            exit();
        }

        try {
            // Log the rejection action
            $logSql = "INSERT INTO user_logs (user_id, action) VALUES (:user_id, 'rejected')";
            $logStmt = $this->connect()->prepare($logSql);
            $logStmt->execute(['user_id' => $userId]);

            // Update the user's status
            $sql = "UPDATE users SET status = 'rejected', expire_at = NULL WHERE id = :user_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
        } catch (PDOException $e) {
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }
}

// Instantiate the BookingManager
$bookingManager = new BookingManager();

// Handle booking deletion
if (isset($_GET['delete_booking'])) {
    $bookingId = $_GET['delete_booking'];
    $bookingManager->deleteBooking($bookingId);
    header("Location: manager.php?message=" . urlencode("Booking deleted successfully!"));
    exit();
}

// Handle accept or reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $userId = $_GET['id'];
    $action = $_GET['action'];

    try {
        if ($action === 'accept') {
            $bookingManager->acceptUser($userId);
            header("Location: manager.php?message=" . urlencode("User accepted!"));
            exit();
        } elseif ($action === 'reject') {
            $bookingManager->rejectUser($userId);
            header("Location: manager.php?message=" . urlencode("User rejected!"));
            exit();
        }
    } catch (Exception $e) {
        header("Location: manager.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Fetch all bookings
$bookings = $bookingManager->getBookings();

// Fetch all users
$users = $bookingManager->getUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="src/css/manager-dashboard.css">
</head>

<body>
    <header>
        <nav>
        <div class="logo-container">
            <img src="src/css/images/logo.png" alt="logo" class="logo">
            <span class="logo-name">Iron Forge Gym</span>
        </div>
        <div class="nav-button">
            <button><a href="index.php">Logout</a></button>
        </div>
    </nav>

    <h1>Manager Dashboard</h1>

    <main>
        <!-- Display success or error messages -->
        <?php if (isset($_GET['message'])): ?>
            <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <h2>Bookings List</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Booking Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['id']); ?></td>
                            <td><?php echo htmlspecialchars($booking['name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['phone']); ?></td>
                            <td><?php echo htmlspecialchars($booking['email']); ?></td>
                            <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                            <td>
                                <a href="manager.php?delete_booking=<?php echo $booking['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Member List</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Subscription</th>
                    <th>Coupon_Active</th>
                    <th>Created At</th>
                    <th>Expire At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_uid']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_email']); ?></td>
                            <td><?php echo htmlspecialchars($user['subscription']); ?></td>
                            <td><?php echo htmlspecialchars($user['coupon_active']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($user['expire_at']); ?></td>
                            <td><?php echo htmlspecialchars($user['status']); ?></td>
                            <td>
                                <?php if ($user['status'] === null): ?>
                                    <a href="manager.php?action=accept&id=<?php echo $user['id']; ?>">Accept</a> |
                                    <a href="manager.php?action=reject&id=<?php echo $user['id']; ?>">Reject</a>
                                <?php else: ?>
                                    Processed
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No members found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>

</html>