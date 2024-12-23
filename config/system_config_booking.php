<?php
session_start(); // Start the session
require_once __DIR__ . '/../database/booking-process.php';

// Check if the user is logged in
if (!isset($_SESSION["useruid"])) {
    echo "<script>
            alert('You need to login first!');
            window.location.href = '../index.php'; // Redirect to login page
          </script>";
    exit();
}

class BookingHandler extends BookingProcess
{
    public function handleBooking($name, $phone, $email, $date)
    {
        // Check if booking already exists
        if (!$this->checkBooking($email, $date)) {
            echo "<script>
                    alert('Booking Already Exists!');
                    window.location.href = '../booking_online.php?error=bookingexists';
                  </script>";
            exit();
        }

        // Proceed to create a new booking
        $this->setBooking($name, $phone, $email, $date);
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];

    $handler = new BookingHandler();
    $handler->handleBooking($name, $phone, $email, $date);

    // Redirect to a confirmation page or back to the booking page
    echo "<script>
            alert('Booking successful!');
            window.location.href = '../user_landing_page.php#booking'; // Redirect back to the booking section
          </script>";
    exit();
}