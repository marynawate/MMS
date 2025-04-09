<?php
// update_plan.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];

    // Database connection
    $host = 'localhost';
    $db = 'microsavings';
    $user = 'root';
    $pass = '';

    try {
        // Create PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare update query
        $sql = "UPDATE savings SET name = :name, description = :description, amount = :amount, type = :type WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':type', $type);

        // Execute the query
        $stmt->execute();

        echo "Savings plan updated successfully!";
        header('Location: savings.html'); // Redirect to savings plans page
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
