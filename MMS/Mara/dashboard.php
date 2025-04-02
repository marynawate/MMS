<?php

session_start();
session_destroy(); // Clears old session data
setcookie("PHPSESSID", "", time() - 3600, "/"); 

include 'db.php';
// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: dashboard.html");
    exit;
}
//identify the user
$user_id = $_SESSION['user_id'];

// Calculate monthly savings (sum of deposits for current month)
$user_id = $_SESSION['user_id'];
$sqlMonthlySavings = "SELECT IFNULL(SUM(amount), 0) AS monthly_savings 
                      FROM deposits 
                      WHERE user_id = $user_id AND MONTH(deposit_date) = MONTH(CURDATE()) 
                      AND YEAR(deposit_date) = YEAR(CURDATE())";
$resultSavings = $conn->query($sqlMonthlySavings);
$rowSavings = $resultSavings->fetch_assoc();
$monthlySavings = $rowSavings['monthly_savings'];

// Retrieve user details for display
$sqlUser = "SELECT full_name, email, national_id, phone, dob FROM users WHERE user_id = $user_id";
$resultUser = $conn->query($sqlUser);
$user = $resultUser->fetch_assoc();

// Retrieve total deposits (FOSA) for user
$sqlTotalDeposits = "SELECT IFNULL(SUM(amount), 0) AS total_deposits 
                     FROM deposits 
                     WHERE user_id = $user_id";
$resultDeposits = $conn->query($sqlTotalDeposits);
$rowDeposits = $resultDeposits->fetch_assoc();
$totalDeposits = $rowDeposits['total_deposits'];

// Retrieve outstanding loan (if any)
$sqlLoan = "SELECT loan_id, loan_amount, outstanding_balance, interest_rate, status 
            FROM loans 
            WHERE user_id = $user_id AND status = 'approved'";
$resultLoan = $conn->query($sqlLoan);
$loan = $resultLoan->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <style>
      .dashboard { max-width: 800px; margin: auto; padding: 20px; background: #fff; }
      .card { padding: 15px; border: 1px solid #ccc; margin-bottom: 15px; border-radius: 5px; }
      
    </style>
</head>
<body class="main">
    <header>
    
            <div class="icon">
    <h1>Mara </h1>
</div>
</div>
<div class="topnav">
    <a href="index.html">Home </a>
    <a href="http://localhost/MMS/Mara/dashboard.php">Dashboard</a>
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

<div class="nav">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </nav>
</div>

  <div class="dashboard">
    <div class="cards">
    <div class="card">
      <h2>Monthly Savings</h2>
      <p>KES <?php echo number_format($monthlySavings, 2); ?></p>
    </div>

    <div class="card">
      <h2>Total Deposits </h2>
      <p>KES <?php echo number_format($totalDeposits, 2); ?></p>
    </div>

    <div class="card">
      <h2>Loan Details</h2>
      <?php if($loan): ?>
        <p>Loan Amount: KES <?php echo number_format($loan['loan_amount'], 2); ?></p>
        <p>Outstanding Balance: KES <?php echo number_format($loan['outstanding_balance'], 2); ?></p>
        <p>Interest Rate: <?php echo $loan['interest_rate']; ?>% per annum</p>
      <?php else: ?>
        <p>No active loans.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
  <footer>
    <p >&copy; 2024 MMS System. All rights reserved.</p>
        <div>
        <a href="#" >Privacy Policy</a>
        <a href="#" >Terms of Service</a>
        <a href="#" >Contact Info</a>
        </div>
  </footer>
</body>
</html>
