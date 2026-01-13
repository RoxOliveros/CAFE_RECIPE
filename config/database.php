<?php
// Database configuration
$DBHost = 'localhost';
$DBUser = 'root';
$DBPass = '';
$DBName = 'sweet_creation';


// Create connection
$conn = new mysqli($DBHost, $DBUser, $DBPass, $DBName);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Set charset
$conn->set_charset("utf8mb4");
?>