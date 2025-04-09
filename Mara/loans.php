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

// Fetch the loans for the logged-in user
try {
    $sql = "SELECT * FROM loans WHERE user_id = :user_id ORDER BY due_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error fetching loans: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Loan Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .loan-status {
            padding: 5px 10px;
            border-radius: 5px;
        }

        .approved {
            background-color: #4CAF50;
            color: white;
        }

        .pending {
            background-color: #ff9800;
            color: white;
        }

        .rejected {
            background-color: #f44336;
            color: white;
        }

        .cta-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .cta-buttons a {
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1.1em;
            text-align: center;
            transition: background-color 0.3s;
        }

        .cta-buttons a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Your Loan Applications</h1>

        <?php if (count($loans) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Loan Type</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($loan['loan_type']); ?></td>
                            <td><?php echo htmlspecialchars($loan['amount']); ?></td>
                            <td><?php echo htmlspecialchars($loan['due_date']); ?></td>
                            <td>
                                <span class="loan-status <?php echo strtolower($loan['status']); ?>">
                                    <?php echo ucfirst($loan['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not applied for any loans yet.</p>
        <?php endif; ?>

        <div class="cta-buttons">
            <a href="applyloan.html">Apply for a New Loan</a>
        </div>
    </div>

</body>
</html>
