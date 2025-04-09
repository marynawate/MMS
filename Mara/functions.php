<?php
// functions.php

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

function get_account_balance($conn, $user_id) {
    $sql = "SELECT balance FROM Accounts WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['balance'];
    } else {
        return 0.0;
    }
}

function get_loans($conn, $user_id) {
    $sql = "SELECT loan_id, amount, outstanding_balance, status FROM Loans WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function apply_loan($conn, $user_id, $amount, $interest_rate, $due_date) {
    $sql = "INSERT INTO Loans (user_id, amount, outstanding_balance, interest_rate, start_date, due_date, status) VALUES (?, ?, ?, ?, NOW(), ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idds", $user_id, $amount, $amount, $interest_rate, $due_date);
    return $stmt->execute();
}

function deposit($conn, $user_id, $amount) {
    $sql_check = "SELECT account_id FROM Accounts WHERE user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $account_id = $row['account_id'];
        $sql = "UPDATE Accounts SET balance = balance + ? WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $amount, $account_id);
        if ($stmt->execute()) {
            $sql_trans = "INSERT INTO Transactions (account_id, transaction_type, amount, transaction_date, description) VALUES (?, 'deposit', ?, NOW(), 'Deposit')";
            $stmt_trans = $conn->prepare($sql_trans);
            $stmt_trans->bind_param("id", $account_id, $amount);
            $stmt_trans->execute();
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function withdraw($conn, $user_id, $amount) {
    $balance = get_account_balance($conn, $user_id);
    if ($balance >= $amount) {
        $sql_check = "SELECT account_id FROM Accounts WHERE user_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $user_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $account_id = $row['account_id'];
            $sql = "UPDATE Accounts SET balance = balance - ? WHERE account_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $amount, $account_id);
            if ($stmt->execute()) {
                $sql_trans = "INSERT INTO Transactions (account_id, transaction_type, amount, transaction_date, description) VALUES (?, 'withdrawal', ?, NOW(), 'Withdrawal')";
                $stmt_trans = $conn->prepare($sql_trans);
                $stmt_trans->bind_param("id", $account_id, $amount);
                $stmt_trans->execute();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_user_role($conn, $user_id) {
    $sql = "SELECT role FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['role'];
    } else {
        return null;
    }
}

function get_savings_plan($conn, $user_id){
    $sql="SELECT savings_plan FROM Accounts WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['savings_plan'];
    } else {
        return null;
    }
}
?>