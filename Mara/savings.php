<?php
// savings.php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include 'navigation.php'; // Include the navigation bar
include 'db.php';
include 'functions.php';

$user_id = $_SESSION["user_id"];
$balance = get_account_balance($conn, $user_id);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Savings</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }
        .savings-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .savings-container h1 {
            text-align: center;
        }
        .savings-container p {
            margin-bottom: 10px;
            text-align: center;
        }
        .savings-container .savings-actions {
            text-align: center;
            margin-top: 20px;
        }
        .savings-container .savings-actions a {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }
        .savings-container .savings-actions a:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="savings-container">
        <h1>Savings</h1>
        <p>Your current account balance is: $<?php echo $balance; ?></p>

        <div class="savings-actions">
            <a href="deposit.php">Deposit</a>
            <a href="withdraw.php">Withdraw</a>
        </div>
    </div>
</body>
</html>