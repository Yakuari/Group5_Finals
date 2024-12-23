<?php
require_once __DIR__ . '/dbh.php';

class BookingProcess extends Dbh
{
    // Method to insert a new booking
    protected function setBooking($name, $phone, $email, $date)
    {
        $stmt = $this->connect()->prepare(
            'INSERT INTO bookings (name, phone, email, booking_date) 
            VALUES (?, ?, ?, ?)'
        );

        // Execute the statement with all required parameters
        if (!$stmt->execute([$name, $phone, $email, $date])) {
            $stmt = null; // Close the statement
            header("location: ../index.php?error=stmtfailed_setBooking");
            exit();
        }

        $stmt = null; // Explicitly close the statement
    }

    // Method to check if a booking already exists
    protected function checkBooking($email, $date)
    {
        $stmt = $this->connect()->prepare(
            'SELECT * FROM bookings WHERE email = ? AND booking_date = ?'
        );

        // Execute the statement
        if (!$stmt->execute([$email, $date])) {
            $stmt = null; // Close the statement
            header("location: ../index.php?error=stmtfailed_checkBooking");
            exit();
        }

        // Check if the booking exists
        $bookingExists = $stmt->rowCount() > 0;
        $stmt = null; // Explicitly close the statement

        return !$bookingExists; // Return true if no conflict
    }
}
