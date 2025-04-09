<?php
// get_plans.php

$host = 'localhost';
$db = 'microsavings';
$user = 'root';
$pass = '';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch savings plans
    $stmt = $pdo->query('SELECT * FROM savings');
    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return JSON response
    echo json_encode($plans);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
