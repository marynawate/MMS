<?php
// services.php

include 'db.php'; // Include your database connection file
include 'functions.php'; // Include your functions file

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include 'navigation.php'; // Include the navigation bar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Services</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }
        .services-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .services-container h1 {
            text-align: center;
        }
        .services-container select, .services-container a {
            display: block;
            margin: 10px auto;
            width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            text-align: center;
            text-decoration: none;
            background-color: #f9f9f9;
            color: #333;
        }
        .services-container a:hover {
            background-color: #eee;
        }
        .services-container .service-options {
            display: none;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="services-container">
        <h1>Services</h1>
        <select id="serviceDropdown">
            <option value="">Select a service</option>
            <option value="savings">Savings</option>
            <option value="loans">Loans</option>
        </select>

        <div id="savingsOptions" class="service-options">
            <a href="deposit.php">Deposit</a>
            <a href="withdraw.php">Withdraw</a>
        </div>

        <div id="loansOptions" class="service-options">
            <a href="apply_loan.php">Apply for Loan</a>
            <a href="view_loans.php">View Loans</a>
        </div>
    </div>

    <script>
        document.getElementById('serviceDropdown').addEventListener('change', function() {
            var selectedService = this.value;
            document.getElementById('savingsOptions').style.display = selectedService === 'savings' ? 'block': 'none';
            document.getElementById('loansOptions').style.display = selectedService === 'loans' ? 'block': 'none';
        });
    </script>
</body>
</html>

<?php
// Close the database connection if needed
mysqli_close($conn); // Uncomment if you want to close the connection here
?>
<?php   
