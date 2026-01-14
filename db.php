<?php
// db.php - Database connection using mysqli
// Edit the credentials below for your environment (XAMPP default: root with empty password).

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'tcc_db';

// Create connection
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($mysqli->connect_errno) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// Ensure proper character set for text content
$mysqli->set_charset('utf8mb4');
?>
