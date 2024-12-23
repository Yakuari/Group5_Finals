<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking</title>
</head>
<body>
    <h1>Create a Booking</h1>
    <form action="config/system_config_booking.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>
