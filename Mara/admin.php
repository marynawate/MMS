<?php
// admin_panel.php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'navigation.php'; // Include the admin navigation bar
include 'db.php';
include 'functions.php';

// Fetch user count
$user_count = get_user_count($conn);

// Fetch pending loan applications count
$pending_loan_count = get_pending_loan_count($conn);

// Fetch total number of accounts
$account_count = get_account_count($conn);

// Fetch total number of transactions (optional, might be resource-intensive for large databases)
// $transaction_count = get_transaction_count($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body { font-family: sans-serif; padding-top: 80px; }
        .admin-panel-container { width: 90%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .admin-panel-container h1 { text-align: center; margin-bottom: 20px; }
        .dashboard-widgets { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; }
        .widget { background-color: #f9f9f9; border: 1px solid #eee; padding: 20px; border-radius: 5px; width: calc(33% - 20px); min-width: 200px; box-sizing: border-box; text-align: center; }
        .widget h2 { margin-top: 0; color: #0056b3; }
        .widget p { font-size: 1.2em; font-weight: bold; color: #333; }
        .admin-links { margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px; }
        .admin-links ul { list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; gap: 15px; }
        .admin-links ul li a { display: block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .admin-links ul li a:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="admin-panel-container">
        <h1>Admin Panel</h1>

        <div class="dashboard-widgets">
            <div class="widget">
                <h2>Total Users</h2>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="widget">
                <h2>Pending Loans</h2>
                <p><?php echo $pending_loan_count; ?></p>
            </div>
            <div class="widget">
                <h2>Total Accounts</h2>
                <p><?php echo $account_count; ?></p>
            </div>
            </div>

        <div class="admin-links">
            <h2>Quick Actions</h2>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="accounts.php">Manage Accounts</a></li>
                <li><a href="loans.php">Manage Loans</a></li>
                </ul>
        </div>
    </div>
</body>
</html>

<?php
// functions.php (Add these functions if they don't exist)

if (!function_exists('get_user_count')) {
    function get_user_count($conn) {
        $sql = "SELECT COUNT(*) AS count FROM Users";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'];
        } else {
            return 0;
        }
    }
}

if (!function_exists('get_pending_loan_count')) {
    function get_pending_loan_count($conn) {
        $sql = "SELECT COUNT(*) AS count FROM Loans WHERE status = 'pending'";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'];
        } else {
            return 0;
        }
    }
}

if (!function_exists('get_account_count')) {
    function get_account_count($conn) {
        $sql = "SELECT COUNT(*) AS count FROM Accounts";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'];
        } else {
            return 0;
        }
    }
}

// Optional function to get transaction count
/*
if (!function_exists('get_transaction_count')) {
    function get_transaction_count($conn) {
        $sql = "SELECT COUNT(*) AS count FROM transactions";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'];
        } else {
            return 0;
        }
    }
}
*/
?>