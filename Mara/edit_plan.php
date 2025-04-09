<?php
// edit_plan.php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Database connection
    $host = 'localhost';
    $db = 'microsavings';
    $user = 'root';
    $pass = '';

    try {
        // Create PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch savings plan by ID
        $stmt = $pdo->prepare('SELECT * FROM savings WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $plan = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$plan) {
            echo "Savings plan not found!";
            exit;
        }

        // Pre-fill the form with the plan data
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Savings Plan</title>
</head>
<body>
    <h1>Edit Savings Plan</h1>
    <form action="update_plan.php" method="POST">
        <input type="hidden" name="id" value="<?= $plan['id'] ?>">

        <label for="name">Plan Name:</label>
        <input type="text" id="name" name="name" value="<?= $plan['name'] ?>" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= $plan['description'] ?></textarea><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" value="<?= $plan['amount'] ?>" required><br>

        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <option value="weekly" <?= $plan['type'] == 'weekly' ? 'selected' : '' ?>>Weekly</option>
            <option value="monthly" <?= $plan['type'] == 'monthly' ? 'selected' : '' ?>>Monthly</option>
            <option value="daily" <?= $plan['type'] == 'daily' ? 'selected' : '' ?>>Daily</option>
        </select><br>

        <button type="submit">Update Plan</button>
    </form>
</body>
</html>
