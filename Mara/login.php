<?php
// login.php
include 'navigation.php'; 
// Include the navigation bar
if (isset($_SESSION["user_id"])) {
    header("Location: services.php"); // Redirect to services if already logged in
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <form action="login_process.php" method="post">
        <label for="username">Username/Email:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="Login">
    
    <p>Don't have an account? <a href="register.html">Register here</a></p>
    </form>
</body>
</html>

<?php
// login_process.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';
    include 'functions.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username is an email address
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT user_id, password_hash, role FROM Users WHERE email = ?";
    } else {
        $sql = "SELECT user_id, password_hash, role FROM Users WHERE username = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (verify_password($password, $row["password_hash"])) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["role"] = $row["role"];
            header("Location: loans.php"); 
            exit();
        } else {
            echo "<p style='color: green; text-align: center;'>Registration Successful.</p>";
        }
    } else {
        echo "<p style='color: red; text-align: center;'>User not found.</p>";
    }

    $conn->close();
}
?>