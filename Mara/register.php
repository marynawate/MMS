<?php
// register.php
include 'navigation.php'; // Include the navigation bar
include 'db.php'; // Uncomment this line if you need to connect to the database   
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }
        form {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"], input[type="email"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #3e8e41;
        }
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .signup {
            text-align: center;
        }
        #signupError {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Register</h1>
    <form action="register_process.php" method="post">
    <h2>Welcome to the Mara</h2>
        <p class="tagline">Join us today and start saving!</p>
        
        <label for="memberName">Full Names:</label><br>
        <input type="text" id="memberName" name="memberName" placeholder="Enter member name" required><br>

        <label for="id-no">National ID:</label><br>
        <input type="number" id="id-no" name="nationalID" placeholder="National ID" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" placeholder="Enter your email" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Enter your password" required><br>

        <label for="confirmpassword">Confirm Password:</label><br>
        <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" placeholder="Enter phone number"><br>

        <label for="role">Role:</label><br>
        <select name="role" id="role">
            <option value="">-----</option>
            <option value="member">Member</option>
            <option value="admin">Admin</option>
        </select><br>

        <label for="savings">Savings:</label><br>
        <select name="savings" id="savings">
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
                <input type="checkbox" name="remember" /> Remember me
            </label>
            <a href="#">Forgot password?</a>
        </div>
    </form>

    <div class="signup">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </div>
    <p id="signupError"></p>
    <script>
        //add javascript to ensure passwords match.
        const password = document.getElementById('password');
        const confirm_password = document.getElementById('confirmpassword');

        function validatePassword(){
            if(password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
</body>
</html>