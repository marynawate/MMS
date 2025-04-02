<?php
@include 'db.php';

session_start();
if(isset($_SESSION['submit'])){
  header("location.dashboard.php");
  exit;
}

//define variables and set to empty values
$user_id ="";
$loan_amount ="";
$interest_rate = "";
$loan_term ="";
$loan_id ="";
$loan_status ="";



$user_id = $_SESSION['user_id'];
$loan_amount = $conn->real_escape_string(trim($_POST['loan_amount']));
$interest_rate = $conn->real_escape_string(trim($_POST['interest_rate']));

// For simplicity, we assume the outstanding balance initially equals the loan amount plus calculated interest.
// Simple interest calculation (for a fixed period, e.g., 12 months):
$loan_term = 12; // months
$total_interest = ($loan_amount * $interest_rate * $loan_term) / (100 * 12);
$total_due = $loan_amount + $total_interest;

$sql = "INSERT INTO loans (user_id, loan_amount, interest_rate, outstanding_balance, applied_date) 
        VALUES ($user_id, $loan_amount, $interest_rate, $total_due, CURDATE())";

if ($conn->query($sql) === TRUE) {
    echo "Loan application submitted successfully! Total due: KES " . number_format($total_due, 2);
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apply for Loan</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="main">
    <header>
    
            <div class="icon">
    <h1>Mara </h1>
</div>
</div>
<div class="topnav">
    <a href="index.html">Home </a>
    <a href="dashboard.html">Dashboard</a>
<a href="http://localhost/MMS/Mara/register.php"target="_blank">Register</a>
<a href="login.html">Log in</a>
<a href="http://localhost/MMS/Mara/loan.php">Loan</a>
<a href="savings">Savings</a>
<a href="aboutus.html">About Us</a>
<a href="contact.html">Contact Us</a>
<a href="profile.html">
    <img src="Images/user.png" class="user-pic">
</a>
<div class="sub-menu-wrap">
    <div class="sub-menu">
        <div class="user-info">
            <img src="" alt="">
            <h3>User Name:</h3>
        </div>
    </div>
</div>
  </div>
    </header>
    <h1>Apply for Loan</h1>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  
  <div class="form-container">
    <form id="loanForm" action="submitLoan.php" method="post">
      <label for="loanAmount">Loan Amount:</label><br>
      <input type="number" id="loanAmount" name="loan_amount" placeholder="Enter loan amount" required><br>
      
      <label for="interestRate">Interest Rate (% per annum):</label><br>
      <input type="number" step="0.01" id="interestRate" name="interest_rate" placeholder="Enter interest rate" required><br>
      
      <button type="submit">Apply for Loan</button>
    </form>
  </div>
</body>
</html>
