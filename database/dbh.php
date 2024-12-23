<?php
class Dbh {
    // Database configuration properties
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;
    public function __construct()
    {
        if($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === '192.168.1.72'){
            $this->host = "localhost";
            $this->db_name = "itelec-finals";
            $this->username = "root";
            $this->password = "";
        }
        else{
            $this->host = "localhost";
            $this->db_name = "u175342239_itelec_finals";
            $this->username = "u175342239_Yurit";
            $this->password = "Itelec123";
        }
    }

    public function connect() {
        try {
            // Create a new PDO instance
            $dsn = "mysql:host={$this->host};dbname={$this->db_name}";
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
