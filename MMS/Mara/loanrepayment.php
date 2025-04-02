<?php
// repayLoan.php - form to repay a loan
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "mms_system";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loan_id = $conn->real_escape_string(trim($_POST['loan_id']));
$repayment_amount = $conn->real_escape_string(trim($_POST['repayment_amount']));

// Retrieve current outstanding balance
$sql = "SELECT outstanding_balance FROM loans WHERE loan_id = $loan_id AND user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_balance = $row['outstanding_balance'];
    
    $new_balance = $current_balance - $repayment_amount;
    if ($new_balance < 0) { $new_balance = 0; }
    
    // Update the loan outstanding balance
    $sqlUpdate = "UPDATE loans SET outstanding_balance = $new_balance WHERE loan_id = $loan_id AND user_id = " . $_SESSION['user_id'];
    if ($conn->query($sqlUpdate) === TRUE) {
        // Record the repayment in the repayments table
        $sqlInsert = "INSERT INTO repayments (loan_id, amount_paid, repayment_date) VALUES ($loan_id, $repayment_amount, CURDATE())";
        $conn->query($sqlInsert);
        echo "Repayment successful! New outstanding balance: KES " . number_format($new_balance, 2);
    } else {
        echo "Error updating loan: " . $conn->error;
    }
} else {
    echo "Loan not found.";
}
$conn->close();
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Repay Loan</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Repay Loan</h1>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  
  <div class="form-container">
    <form id="repayForm" action="submitRepayment.php" method="post">
      <label for="loanID">Loan ID:</label><br>
      <input type="number" id="loanID" name="loan_id" placeholder="Enter loan ID" required><br>
      
      <label for="repaymentAmount">Repayment Amount:</label><br>
      <input type="number" id="repaymentAmount" name="repayment_amount" placeholder="Enter repayment amount" required><br>
      
      <button type="submit">Repay Loan</button>
    </form>
  </div>
</body>
</html>
