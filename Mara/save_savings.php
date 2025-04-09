<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $action = $_POST['action']; // deposit or withdraw
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in

    // Ensure the amount is a positive number
    if ($amount <= 0) {
        echo "Amount must be greater than 0.";
        exit();
    }

    // Fetch the current savings balance from the database
    $stmt = $pdo->prepare("SELECT amount FROM savings_transactions WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $current_savings = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($current_savings === false) {
        // If no record found, we can insert a new record with the action
        $new_savings = $action === 'deposit' ? $amount : 0;
        $stmt = $pdo->prepare("INSERT INTO savings_transactions (user_id, amount) VALUES (?, ?)");
        $stmt->execute([$user_id, $new_savings]);
    } else {
        $current_amount = $current_savings['amount'];
        if ($action === 'deposit') {
            $new_amount = $current_amount + $amount;
        } elseif ($action === 'withdraw') {
            // Ensure there's enough balance to withdraw
            if ($current_amount < $amount) {
                echo "Insufficient funds to withdraw.";
                exit();
            }
            $new_amount = $current_amount - $amount;
        }

        // Update the savings tracker with the new amount
        $update_stmt = $pdo->prepare("UPDATE savings_transactions SET amount = ? WHERE user_id = ?");
        $update_stmt->execute([$new_amount, $user_id]);
    }

    // Insert the action into the savings transaction log
    $log_stmt = $pdo->prepare("INSERT INTO savings_transactions (user_id, action, amount, date) VALUES (?, ?, ?, ?)");
    $log_stmt->execute([$user_id, $action, $amount, $date]);

    // Redirect or show a success message
    echo "Transaction successful! Your new balance is: " . $new_amount;
    // Optionally, you can redirect or display more details
    exit();
}
?>
