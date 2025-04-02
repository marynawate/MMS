<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $memberName = $_POST['memberName'];
    $nationalID = $_POST['nationalID'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $savings = $_POST['savings'];
    $amount = $_POST['amount'];

    // Error handling
    $error = [];

    // Password validation
    if ($password !== $confirmPassword) {
        $error[] = "Passwords do not match!";
    }

    // Check if email or National ID already exists
    $checkQuery = "SELECT * FROM users WHERE email='$email' OR nationalID='$nationalID'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        $error[] = "Email or National ID already registered. Use different credentials.";
    }

    // If no errors, insert data
    if (empty($error)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Encrypt password

        $query = "INSERT INTO users (memberName, nationalID, email, password, dob, phone, role, savings, amount)
                  VALUES ('$memberName', '$nationalID', '$email', '$hashedPassword', '$dob', '$phone', '$role', '$savings', '$amount')";

        if ($conn->query($query) === TRUE) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="signup-container">
        <h2>Registration Form</h2>
        <div class="form-container">
            <form id="signup" action="register.php" method="post">
                <?php
                if (!empty($error)) {
                    foreach ($error as $err) {
                        echo '<span class="error-msg">'.$err.'</span><br>';
                    }
                }
                ?>
                <label for="memberName">Full Names:</label><br>
                <input type="text" id="memberName" name="memberName" placeholder="Enter member name" required><br>

                <label for="id-no">National ID:</label><br>
                <input type="number" id="id-no" name="nationalID" placeholder="National ID" required><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" placeholder="Enter your email" required><br>

                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your password" required><br>

                <label for="confirmpassword">Confirm Password:</label><br>
                <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password"><br>

                <label for="dob">Date of Birth:</label><br>
                <input type="date" id="dob" name="dob" required><br>

                <label for="phone">Phone Number:</label><br>
                <input type="text" id="phone" name="phone" placeholder="Enter phone number"><br>

                <label for="role">Role:</label><br>
                <select name="role" required>
                    <option value="">-----</option>
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select><br>

                <label for="savings">Savings Plan:</label><br>
                <select name="savings" required>
                    <option value="">-----</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="daily">Daily</option>
                </select><br>

                <label for="amount">Amount:</label><br>
                <input type="number" id="amount" name="amount" placeholder="Enter amount"><br>

                <button type="submit">Register</button>
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="btn-signin">Sign In</button>
            </form>
        </div>
        <div class="signup">
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="styles.css">
  <script src="script.js" defer></script>
</head>
<body class="main">
    <header>
    
            <div class="icon">
    <h1>Mara </h1>
</div>
</div>
<div class="topnav">
    <a href="index.html">Home </a>
    <a href="dashboard.php">Dashboard</a>
<a href="registration.php"target="_blank">Register</a>
<a href="login.html">Log in</a>
<a href="loan.php">Loan</a>
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
    <div id="signup-container">
  <h2>Registration Form</h2>
  <div class="form-container">
    <form id="signup" action="register.php" method="post">
      <?php
      if(isset($error)){
        foreach($error as $error){
          echo '<span class="error-msg">'.$error.'</span>';
        }
      }
      ?>
      <label for="memberName">Full Names:</label><br>
      <input type="text" id="memberName" name="memberName" placeholder="Enter member name" required><br>
      
      <label for="id-no">National ID:</label><br>
      <input type="number" id="id-no" name="nationalID" placeholder="National ID" required><br>
      
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
      
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" placeholder="Enter your password" required><br>
      
      <label for="confirmpassword">Confirm Password</label>
      <input type="password"id="confirmpassword"name="confirmpassword"placeholder="Confirm Password"><br>

    
      <label for="dob">Date of Birth:</label><br>
      <input type="date" id="dob" name="dob" required><br>
      
      <label for="phone">Phone Number:</label><br>
      <input type="text" id="phone" name="phone" placeholder="Enter phone number"><br>
      
      <label for="role">Role</label><br>
      <select name="role" id="">
        <option value="">-----</option>
        <option value="member">Member</option>
        <option value="admin">Admin</option>
      </select>
      <label for="savings">Savings</label>
      <select name="savings" id="">
        <option value="">-----</option>
        <option value="weekly">Weekly</option>
        <option value="monthly">Monthly</option>
        <option value="daily">Daily</option>
     <br>
      </select>
      <label for="amount">Amount</label>
      <input type="number" id="amount" name="amount" placeholder="Enter amount"><br>

      <button type="submit">Register</button>
      <div class="remember-forgot">
        <label>
          <input type="checkbox" name="remember" /> Remember me
        </label>
        <a href="#">Forgot password?</a>
      </div>

      <button type="submit" class="btn-signin">Sign In</button>
    </form>
    
    </div>
    <div class="signup">
        <p>Already have an account? <a href="login.html">Register now</a></p>
      </div>
      <p id="signupError"style="color:red;"></p>
    </form>
  
  </div>
</div> 
 <!-- <footer>
  <p >&copy; 2024 MMS System. All rights reserved.</p>
        <div>
        <a href="#" >Privacy Policy</a>
        <a href="#" >Terms of Service</a>
        <a href="#" >Contact Info</a>
        </div>
    </footer>
    -->
  <script src="script.js"></script>
</body>
</html>

