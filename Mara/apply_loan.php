<?php
// Start the session
session_start();

// Check if the user is logged in (assuming `user_id` is stored in session)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include the database connection file
include("db.php"); // Assuming `db.php` contains your database connection

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Initialize variables to hold form data
$amount = 0;
$loan_type = '';
$due_date = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the POST request
    $loan_type = $_POST['loantype'];
    
    // Ensure the due date is provided, if not set it to 6 months from the current date
    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : date('Y-m-d', strtotime('+6 months'));

    // Get the current savings amount of the user
    $savings_amount = isset($_SESSION['savings_amount']) ? $_SESSION['savings_amount'] : 0;

    // Set loan amount to six times the user's savings amount
    $amount = $savings_amount * 6;

    // Validate if the loan amount is greater than the user's savings
    if ($amount > $savings_amount) {
        echo "<p style='color: red;'>You cannot apply for a loan greater than six times your total savings.</p>";
        exit();
    }

    try {
        // Prepare SQL query to insert loan data into the loans table
        $sql = "INSERT INTO loans (user_id, amount, loan_type, due_date) VALUES (:user_id, :amount, :loan_type, :due_date)";
        
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters to the SQL query
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindParam(':loan_type', $loan_type, PDO::PARAM_STR);
        $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
        
        // Execute the query
        if ($stmt->execute()) {
            // Success message
            echo "<p>Your loan application has been submitted successfully. We will review it shortly.</p>";
            header("Location: loan_success.html"); // Redirect to a success page (loan_success.html)
            exit();
        } else {
            echo "<p style='color: red;'>There was an issue with your application. Please try again.</p>";
        }
    } catch (PDOException $e) {
        // If there's an error, display it
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>
