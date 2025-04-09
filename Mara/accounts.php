<?php
// accounts.php

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'navigation.php'; // Include the admin navigation bar
include 'db.php';
include 'functions.php';

// Fetch all accounts
$accounts = get_all_accounts($conn);

// Handle account deletion
if (isset($_POST['delete_account']) && isset($_POST['account_id'])) {
    $account_id_to_delete = $_POST['account_id'];
    if (delete_account($conn, $account_id_to_delete)) {
        $delete_message = "Account deleted successfully.";
        $accounts = get_all_accounts($conn); // Refresh accounts list
    } else {
        $delete_error = "Error deleting account.";
    }
}

// Handle account creation
if (isset($_POST['create_account'])) {
    $user_id = $_POST['user_id'];
    $balance = $_POST['balance'];
    $savings_plan = $_POST['savings_plan'];

    if (create_account($conn, $user_id, $balance, $savings_plan)) {
        $create_message = "Account created successfully.";
        $accounts = get_all_accounts($conn); // Refresh accounts list
    } else {
        $create_error = "Error creating account.";
    }
}

// Fetch all users for account creation dropdown
$users = get_all_users($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Accounts</title>
    <style>
        body { font-family: sans-serif; padding-top: 80px; }
        .accounts-container { width: 90%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .accounts-container h1, .accounts-container h2 { text-align: center; }
        .accounts-container table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .accounts-container th, .accounts-container td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .accounts-container th { background-color: #f2f2f2; }
        .accounts-container form { display: inline; margin-right: 10px; }
        .accounts-container .message { color: green; text-align: center; margin-top: 10px; }
        .accounts-container .error { color: red; text-align: center; margin-top: 10px; }
        .accounts-container select, .accounts-container input[type="number"], .accounts-container input[type="text"] {
            width: 200px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .accounts-container input[type="submit"]{
          padding:10px;
          cursor:pointer;
        }

    </style>
</head>
<body>
    <div class="accounts-container">
        <h1>Manage Accounts</h1>

        <?php if (isset($delete_message)): ?>
            <p class="message"><?php echo $delete_message; ?></p>
        <?php endif; ?>
        <?php if (isset($delete_error)): ?>
            <p class="error"><?php echo $delete_error; ?></p>
        <?php endif; ?>

        <h2>Account List</h2>
        <?php if (!empty($accounts)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>User ID</th>
                        <th>Balance</th>
                        <th>Savings Plan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?php echo $account['account_id']; ?></td>
                            <td><?php echo $account['user_id']; ?></td>
                            <td>$<?php echo $account['balance']; ?></td>
                            <td><?php echo $account['savings_plan']; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="account_id" value="<?php echo $account['account_id']; ?>">
                                    <input type="hidden" name="delete_account" value="1">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No accounts found.</p>
        <?php endif; ?>

        <hr>

        <?php if (isset($create_message)): ?>
            <p class="message"><?php echo $create_message; ?></p>
        <?php endif; ?>
        <?php if (isset($create_error)): ?>
            <p class="error"><?php echo $create_error; ?></p>
        <?php endif; ?>

        <h2>Create New Account</h2>
        <form method="post">
            <label for="user_id">User:</label>
            <select name="user_id" id="user_id" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name'] . " (" . $user['user_id'] . ")"; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="balance">Initial Balance:</label>
            <input type="number" name="balance" id="balance" min="0" step="0.01" required><br>

            <label for="savings_plan">Savings Plan:</label>
            <input type="text" name="savings_plan" id="savings_plan" required><br>

            <input type="hidden" name="create_account" value="1">
            <input type="submit" value="Create Account">
        </form>
    </div>
</body>
</html>