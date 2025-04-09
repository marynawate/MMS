<?php
// withdraw.php
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
include 'functions.php';
include 'navigation.php'; // Include the navigation bar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    if (withdraw($conn, $_SESSION["user_id"], $amount)) {
        echo "<p style='color: green; text-align: center;'>Withdrawal successful!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Withdrawal failed. Insufficient funds or error.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Withdraw</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }
        .withdraw-container {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .withdraw-container h1 {
            text-align: center;
        }
        .withdraw-container label {
            display: block;
            margin-bottom: 5px;
        }
        .withdraw-container input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .withdraw-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .withdraw-container input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="withdraw-container">
        <h1>Withdraw</h1>
        <form action="withdraw.php" method="post">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" min="0" step="0.01" required><br>
            <input type="submit" value="Withdraw">
        </form>
    </div>
</body>
</html>