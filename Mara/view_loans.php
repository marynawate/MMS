<?php
// view_loans.php

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include 'navigation.php'; // Include the navigation bar
include 'db.php';
include 'functions.php';

$user_id = $_SESSION["user_id"];
$loans = get_loans($conn, $user_id);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Loans</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }
        .loans-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .loans-container h1 {
            text-align: center;
        }
        .loans-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .loans-container th, .loans-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .loans-container th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="loans-container">
        <h1>View Loans</h1>

        <?php if (!empty($loans)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Loan ID</th>
                        <th>Amount</th>
                        <th>Outstanding Balance</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?php echo $loan['loan_id']; ?></td>
                            <td>$<?php echo $loan['amount']; ?></td>
                            <td>$<?php echo $loan['outstanding_balance']; ?></td>
                            <td><?php echo $loan['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No loans found.</p>
        <?php endif; ?>
    </div>
</body>
</html>