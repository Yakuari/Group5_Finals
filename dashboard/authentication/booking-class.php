<?php
require_once __DIR__ . '../../../database/booking-process.php';

class Booking extends BookingProcess
{
    private $name;
    private $phone;
    private $email;
    private $date;

    public function __construct($name, $phone, $email, $date)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->date = $date;
    }

    public function bookingOnline()
    {
        // Check for empty inputs
        if (!$this->emptyInput()) {
            header("location: ../../index.php?error=emptyinput");
            exit();
        }

        // Validate name
        if (!$this->invalidUid()) {
            header("location: ../../index.php?error=invalidname");
            exit();
        }

        // Validate email
        if (!$this->invalidEmail()) {
            header("location: ../../index.php?error=invalidemail");
            exit();
        }
        // Check if user ID or email is already taken
        if ($this->uidTakenChecker() == false) {
            header("location: ../../index.php?error=usertaken");
            exit();
        }

        // Proceed to insert booking into the database
        $this->setBooking($this->name, $this->phone, $this->email, $this->date);
        header("location: ../dashboard/booking_success.php");
        exit();
    }

    private function emptyInput()
    {
        // Returns false if any input is empty
        return !empty($this->name) && !empty($this->phone) && !empty($this->email) && !empty($this->date);
    }

    private function invalidUid()
    {
        // Check if the name contains only alphanumeric characters
        return preg_match("/^[a-zA-Z0-9]+$/", $this->name);
    }

    private function invalidEmail()
    {
        // Validate email format
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function uidTakenChecker()
    {
        return $this->checkBooking($this->name, $this->email);
    }
}
