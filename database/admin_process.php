<?php
session_start();
require_once __DIR__ . '/dbh.php'; // Adjust the path to your Dbh class file

class AdminActions extends Dbh
{
    private function isUserProcessed($userId)
    {
        $sql = "SELECT status FROM users WHERE id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch();

        if (!$user) {
            throw new Exception("User not found.");
        }

        return in_array($user['status'], ['accepted', 'rejected']);
    }

    public function acceptUser($userId)
    {
        if ($this->isUserProcessed($userId)) {
            header("Location: admin-dashboard-class.php?error=already_processed");
            exit();
        }

        $sql = "SELECT user_month FROM users WHERE id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch();

        if ($user) {
            $userMonth = (int)$user['user_month'];
            $daysToAdd = $userMonth * 30;
            $expireAt = date('Y-m-d H:i:s', strtotime("+$daysToAdd days"));

            $updateSql = "UPDATE users SET expire_at = :expire_at, status = 'accepted' WHERE id = :user_id";
            $updateStmt = $this->connect()->prepare($updateSql);
            $updateStmt->execute(['expire_at' => $expireAt, 'user_id' => $userId]);

            $logSql = "INSERT INTO user_logs (user_id, action) VALUES (:user_id, 'accepted')";
            $logStmt = $this->connect()->prepare($logSql);
            $logStmt->execute(['user_id' => $userId]);
        } else {
            throw new Exception("User not found.");
        }
    }

    public function rejectUser($userId)
    {
        if ($this->isUserProcessed($userId)) {
            header("Location: admin-dashboard-class.php?error=already_processed");
            exit();
        }

        $logSql = "INSERT INTO user_logs (user_id, action) VALUES (:user_id, 'rejected')";
        $logStmt = $this->connect()->prepare($logSql);
        $logStmt->execute(['user_id' => $userId]);

        $sql = "UPDATE users SET status = 'rejected' WHERE id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
    }

    public function changeUserRole($userId, $newRole)
    {
        if (!in_array($newRole, ['user', 'manager'])) {
            throw new Exception("Invalid role specified.");
        }

        $stmt = $this->connect()->prepare("SELECT user_role FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        $targetUser = $stmt->fetch();

        if (!$targetUser) {
            throw new Exception("User not found.");
        }

        if ($targetUser['user_role'] === 'admin') {
            throw new Exception("Cannot change the role of an admin.");
        }

        $sql = "UPDATE users SET user_role = :newRole WHERE id = :userId";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['newRole' => $newRole, 'userId' => $userId]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $action = $_POST['action'] ?? null;
    $newRole = $_POST['new_role'] ?? null;

    // Validate input
    if (!$userId || !$action) {
        header("Location: admin-dashboard-class.php?error=missing_data");
        exit();
    }

    $adminActions = new AdminActions();

    try {
        if ($action === 'accept') {
            $adminActions->acceptUser($userId);
            header("Location: admin-dashboard-class.php?message=User accepted.");
        } elseif ($action === 'reject') {
            $adminActions->rejectUser($userId);
            header("Location: admin-dashboard-class.php?message=User rejected.");
        } elseif ($action === 'change_role') {
            if (!$newRole) {
                throw new Exception("Missing role data.");
            }
            $adminActions->changeUserRole($userId, $newRole);
            header("Location: admin-dashboard-class.php?message=Role updated successfully.");
        } else {
            throw new Exception("Invalid action specified.");
        }
    } catch (Exception $e) {
        // Log the error (optional)
        error_log($e->getMessage());
        header("Location: admin-dashboard-class.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

