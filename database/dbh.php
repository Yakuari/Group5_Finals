<?php
class Dbh {
    // Database configuration properties
    private $host = 'localhost';
    private $dbname = 'itelec-finals';
    private $username = 'root';
    private $password = '';

    public function connect() {
        try {
            // Create a new PDO instance
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $dbh = new PDO($dsn, $this->username, $this->password);

            // Set PDO attributes
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Throw exceptions on errors
            $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch results as associative arrays

            return $dbh;
        } catch (PDOException $e) {
            // Log error to a file (useful for production)
            error_log("Database Connection Error: " . $e->getMessage(), 3, "../logs/db_errors.log");

            // Display a generic error message to the user
            die("Database connection failed. Please try again later.");
        }
    }
}
?>
