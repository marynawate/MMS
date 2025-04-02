<?php
include('db.php');
 
if(isset($_POST['submit'])){
  $fullName   = mysqli_real_escape_string($conn,$_POST['memberName']);
  $nationalID = mysqli_real_escape_string($conn,$_POST['nationalID']);
  $email      = mysqli_real_escape_string($conn,$_POST['email']);
  $password   = md5($conn,$_POST['password']);
    $cpassword=md5($conn,$_POST['cpassword']);
    $dob        =mysqli_real_escape_string($conn,$_POST['dob']);
    $phone      = mysqli_real_escape_string($conn,$_POST['phone']);
    $role       =mysqli_real_escape_string($_POST['role']);
    
    $select="SELECT *FROM users WHERE email='$email'&&password='$password'";
 
    $result=mysqli_query($conn,$select);
    if(mysqli_num_rows($result)>0){

        $row=mysqli_fetch_array($result);
        if($row['role']=='admin'){
            $_SESSION['admin_name']=$row['full_name'];
            header('location:admin.php');
        }elseif($row['role']=='user'){

                $_SESSION['user_name']=$row['full_name'];
                header('location:user.php');
        
        }
    }else{
        $error[]="Incorrect email or password!";
    }
    };
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
  <a href="dashboard.php">Dashboard</a>
<a href="registration.php"target="_blank">Register</a>
<a href="login.html">Log in</a>
<a href="loan.php">Loan</a>
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
    <div class="login-container">
        <h2>Login</h2>
        <p class="tagline">Manage your savings smartly</p>
              
            <div class="form1">
                <form method="post"action="">

              <label for="username">Email:</label>
              <input type="email" id="username" name="username" placeholder="Username" required>
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" placeholder="Password" required>
              <button type="submit">Login</button>
    
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
            <p>Don't have an account? <a href="registration.html">Register now</a></p>
          </div>
          <p id="loginError" style="color: red;"></p>
    </div> 
        <footer>
            <p >&copy; 2024 Awesome Web Academy. All rights reserved.</p>
            <div>
            <a href="#" >Privacy Policy</a>
            <a href="#" >Terms of Service</a>
            <a href="#" >Contact Info</a>
            </div>
        </footer>
        <script src="script.js"></script>
    
</body>
</html>
