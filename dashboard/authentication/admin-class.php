<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // PHPMailer autoload
require_once __DIR__ . '/../../database/signUp.query.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Admin extends signUp
{
    private $email;
    private $uid;
    private $type;
    private $pass;
    private $month;
    private $monthLimit = 12; // Define the month limit
    private $amount;


    public function __construct($email, $uid, $type, $pass, $month, $amount)
    {
        $this->email = $email;
        $this->uid = $uid;
        $this->type = $type;
        $this->pass = $pass;
        $this->month = $month;
        $this->amount = $amount;
    }

    public function signupUser()
    {
        // Check for empty input
        if ($this->emptyInput() == false) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        // Validate username
        if ($this->invalidUid() == false) {
            header("location: ../index.php?error=username");
            exit();
        }

        // Validate email
        if ($this->invalidEmail() == false) {
            header("location: ../index.php?error=email");
            exit();
        }

        // Check if user ID or email is already taken
        if ($this->uidTakenChecker() == false) {
            header("location: ../index.php?error=usertaken");
            exit();
        }

        // Check the month limit
        if ($this->monthLimit() == false) {
            header("location: ../index.php?error=monthexceeded");
            exit();
        }


        // Handle user authority based on type
        switch ($this->type) {
            
            case 'user':
                $role = "user";
                break;

            default:
                header("location: ../index.php?error=invalidtype");
                exit();
        }
        switch ($this->month) {
            case '1':
                $month = 1;
                $amount = 1500;
                break;
            case '2':
                $month = 2;
                $amount = 3000;
                break;
            case '3':
                $month = 3;
                $amount = 4000;
                break;
            case '4':
                $month = 4;
                $amount = 6000;
                break;
            case '5':
                $month = 5;
                $amount = 7500;
                break;
            case '6':
                $month = 6;
                $amount = 8000;
                break;
            case '7':
                $month = 7;
                $amount = 10500;
                break;
            case '8':
                $month = 8;
                $amount = 12000;
                break;
            case '9':
                $month = 9;
                $amount = 12000;
                break;
            case '10':
                $month = 10;
                $amount = 15000;
                break;
            case '11':
                $month = 11;
                $amount = 16500;
                break;
            case '12':
                $month = 12;
                $amount = 16000;
                break;
            default:
                header("location: ../index.php?error=invalidmonth");
                exit();
        }

        // Generate and send OTP
        if ($this->sendOtp()) {
            $_SESSION['temp_user'] = [
                'uid' => $this->uid,
                'email' => $this->email,
                'role' => $role,
                'pass' => $this->pass,
                'amount' => $amount,
                'month' => $month
            ];
            header("location: ../database/verify_otp.php"); // Redirect to OTP verification page
            exit();
        } else {
            header("location: ../../index.php?error=otpfail");
            exit();
        }
    }

    private function emptyInput()
    {
        return !(empty($this->email) || empty($this->uid) || empty($this->type) || empty($this->month) || empty($this->pass));
    }

    private function invalidUid()
    {
        return preg_match("/^[a-zA-Z0-9]+$/", $this->uid);
    }

    private function invalidEmail()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function uidTakenChecker()
    {
        return $this->checkUser($this->uid, $this->email);
    }

    private function monthLimit()
    {
        // Check if the month value exceeds the allowed limit
        return $this->month > 0 && $this->month <= $this->monthLimit;
    }

    private function sendOtp()
    {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp; // Store OTP in session
        $_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes

        // Send OTP via email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'dominguezstephen01@gmail.com'; // Your email
            $mail->Password = 'dbjt hnsz vpzo zvei'; // Your password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email content
            $mail->setFrom('dominguezstephen01@gmail.com', 'Iron Forge Gym');
            $mail->addAddress($this->email); // Send to the user's email
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Hello,\n\nYour OTP code is: $otp\n\nThis code is valid for 5 minutes.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false; // Handle failure
        }
    }

    public function verifyOtp($inputOtp)
    {
        // Check if OTP exists in session and is valid
        if (isset($_SESSION['otp']) && $_SESSION['otp'] == $inputOtp) {
            if (time() <= $_SESSION['otp_expiry']) {
                unset($_SESSION['otp'], $_SESSION['otp_expiry']); // Clear OTP after successful verification

                // Register user after OTP verification
                $tempUser = $_SESSION['temp_user'];
                $this->setUser($tempUser['uid'], $tempUser['pass'], $tempUser['email'], $tempUser['role'], $tempUser['amount'], $tempUser['month']);
                unset($_SESSION['temp_user']); // Clear temporary user data

                return true;
            } else {
                unset($_SESSION['otp'], $_SESSION['otp_expiry']); // Clear expired OTP
                return false; // OTP expired
            }
        }
        return false; // OTP invalid
    }
}
