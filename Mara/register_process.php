<?php
// Include the database connection settings
include 'db.php';  // This includes the PDO connection from db.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'functions.php';

    $memberName = $_POST["memberName"];
    $nationalID = $_POST["nationalID"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $role = $_POST["role"];
    $savings = $_POST["savings"];
    $amount = $_POST["amount"];

    $hashed_password = hash_password($password);

    try {
        // Start a transaction
        $pdo->beginTransaction();

        $created_at = date('Y-m-d H:i:s');

        // Insert into Users table
        $sql_user = "INSERT INTO Users (memberName, nationalID, email, password, dob, phone, role, savings, amount, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->bindParam(1, $memberName);
        $stmt_user->bindParam(2, $nationalID);
        $stmt_user->bindParam(3, $email);
        $stmt_user->bindParam(4, $hashed_password);
        $stmt_user->bindParam(5, $dob);
        $stmt_user->bindParam(6, $phone);
        $stmt_user->bindParam(7, $role);
        $stmt_user->bindParam(8, $savings);
        $stmt_user->bindParam(9, $amount);
        $stmt_user->bindParam(10, $created_at);
        $stmt_user->execute();

        $user_id = $pdo->lastInsertId(); // Get the user ID

        // Insert into Accounts table
        $sql_account = "INSERT INTO Accounts (user_id, balance, savings_plan) VALUES (?, ?, ?)";
        $stmt_account = $pdo->prepare($sql_account);
        $stmt_account->bindParam(1, $user_id);
        $stmt_account->bindParam(2, $amount);
        $stmt_account->bindParam(3, $savings);
        $stmt_account->execute();

        // Commit the transaction
        $pdo->commit();

        // Store email and password in session for immediate login (optional)
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        echo "<p style='text-align:center;'>Registration successful</a></p>";
        header("Location: login.html");

    } catch (PDOException $exception) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        echo "Error: " . $exception->getMessage();
    }
}
?>
