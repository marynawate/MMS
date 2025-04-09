<?php
// Database connection settings
$host = 'localhost';
$dbname = 'microsavings';  // Replace with your actual database name
$username = 'root';  // Replace with your actual database username
$password = '';  // Replace with your actual database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, show an error message
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}
?>