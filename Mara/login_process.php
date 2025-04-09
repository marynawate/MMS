<?php 
// login_process.php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST" || (isset($_SESSION['email']) && isset($_SESSION['password']))) { // Check for session data

    include 'db.php'; // Include the database connection settings
    include 'functions.php'; // Include functions for password verification

    // Check if session data exists
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        unset($_SESSION['email']);
        unset($_SESSION['password']);
    } else {
        $email = $_POST['email']; // Use email from POST data
        $password = $_POST["password"];
    }

    try {
        // Prepare SQL query using PDO to fetch user data based on email (case-insensitive)
        $sql = "SELECT id, password, role FROM Users WHERE LOWER(email) = LOWER(?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $email, PDO::PARAM_STR); // $email is the identifier
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user is found in the database
        if ($result) {
            // If the result is found, verify the password
            if (verify_password($password, $result["password"])) {
                $_SESSION["user_id"] = $result["id"]; // Use `id` as user identifier
                $_SESSION["role"] = $result["role"]; // Store role info

                // Redirect to the profile page after successful login
                header("Location: profile.html");
                exit();
            } else {
                // Incorrect password message
                echo "<p style='color: red; font-size: 20px; text-align: center;'>Incorrect password.</p>";
            }
        } else {
            // User not found
            echo "<p style='color: red; font-size: 20px; text-align: center;'>User not found .</p>";
        }

        // Close the statement
        $stmt->closeCursor();

    } catch (PDOException $e) {
        // Error handling
        echo "<p style='color: red; text-align: center;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>
