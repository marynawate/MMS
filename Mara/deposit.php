<?php
// deposit.php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include 'navigation.php'; // Include the navigation bar
include 'db.php';
include 'functions.php';

$user_id = $_SESSION["user_id"];

// Get the user's account details
$account = get_account($conn, $user_id);

if (!$account) {
    echo "<p style='color: red; text-align: center;'>Account not found.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];

    if ($amount <= 0) {
        $error = "Amount must be greater than zero.";
    } else {
        $conn->begin_transaction(); // Start transaction

        if (deposit($conn, $account['account_id'], $amount)) {
            if (recordTransaction($conn, $user_id, $account['account_id'], "deposit", $amount)) {
                $conn->commit(); // Commit transaction
                $success = "Deposit successful.";
                $account = get_account($conn, $user_id); // Refresh account info
            } else {
                $conn->rollback(); // Rollback if recording transaction fails
                $error = "Failed to record transaction.";
            }
        } else {
            $conn->rollback(); // Rollback if deposit fails
            $error = "Failed to deposit funds.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deposit Funds</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }

        .deposit-container {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .deposit-container h1 {
            text-align: center;
        }

        .deposit-container label {
            display: block;
            margin-bottom: 5px;
        }

        .deposit-container input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .deposit-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .deposit-container input[type="submit"]:hover {
            background-color: #3e8e41;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }

        .account-info {
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <div class="deposit-container">
        <h1>Deposit Funds</h1>

        <div class="account-info">
            <p>Account Balance: $<?php echo isset($account['balance']) ? number_format($account['balance'], 2) : 'N/A'; ?></p>
        </div>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="deposit.php" method="post">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" min="0.01" step="0.01" required><br>

            <input type="submit" value="Deposit">
        </form>
    </div>
</body>
</html>