<?php
// home.php
include 'navigation.php'; // Include the navigation bar
?>

<!DOCTYPE html>
<html>
<head>
    <title> Home</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding-top: 120px; /* Adjust for navigation bar height */
            background-image:
        }

        h1 {
            color: #333;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .a-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            margin: 5px;
        }
        .a-button:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    
    <h1>Welcome to the Mara</h1>
    <p>Manage your savings and loans with ease.</p>
    <div>
        <a href="login.php" class="a-button">Login</a>
        <a href="register.php" class="a-button">Register</a>
    </div>
</body>
</html>