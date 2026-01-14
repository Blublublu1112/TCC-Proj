<?php
// db.php - Database connection using mysqli
// Edit the credentials below for your environment (XAMPP default: root with empty password).

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'tcc_db';

// Create connection using error suppression to handle it gracefully
$mysqli = @new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($mysqli->connect_errno) {
    // We do NOT die here to allow the UI to load and show a friendly error
    // die('Database connection failed: ' . $mysqli->connect_error);
    $db_error = "Connection failed: " . $mysqli->connect_error;
} else {
    // Ensure proper character set for text content
    if (!$mysqli->set_charset('utf8mb4')) {
        $db_error = "Error loading character set utf8mb4: " . $mysqli->error;
    }
}
?>

