<?php
session_start();
include 'db.php'; // Include your database connection

$user_id = $_SESSION['user_id']; // Assuming the user is logged in

// Fetch all transactions for the logged-in user
$stmt = $pdo->prepare("SELECT action, amount, date FROM savings_transactions WHERE user_id = ?");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
echo json_encode($transactions);
?>
