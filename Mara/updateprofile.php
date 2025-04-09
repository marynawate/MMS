<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Database connection using PDO
$servername = "localhost";  // Replace with your database server
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "microsavings";  // Replace with your database name

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle the connection error
    die("Connection failed: " . $e->getMessage());
}

// Retrieve and sanitize form data
$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID
$memberName = htmlspecialchars($_POST['memberName']);
$nationalID = htmlspecialchars($_POST['nationalID']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$dob = htmlspecialchars($_POST['dob']);
$role = htmlspecialchars($_POST['role']);
$savings = htmlspecialchars($_POST['savings']);
$amount = htmlspecialchars($_POST['amount']);

// Prepare SQL query to update user details
$sql = "UPDATE users SET 
            memberName = :memberName,
            nationalID = :nationalID,
            email = :email,
            phone = :phone,
            dob = :dob,
            role = :role,
            savings = :savings,
            amount = :amount
        WHERE id = :user_id";

$stmt = $conn->prepare($sql);

// Bind parameters to the SQL query
$stmt->bindParam(':memberName', $memberName, PDO::PARAM_STR);
$stmt->bindParam(':nationalID', $nationalID, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
$stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
$stmt->bindParam(':role', $role, PDO::PARAM_STR);
$stmt->bindParam(':savings', $savings, PDO::PARAM_STR);
$stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Execute the query to update user details
if ($stmt->execute()) {
    // If successful, update the session data
    $_SESSION['name'] = $memberName;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['dob'] = $dob;
    $_SESSION['role'] = $role;
    $_SESSION['savings_frequency'] = $savings;
    $_SESSION['savings_amount'] = $amount;

    // Redirect back to profile page with success message
    echo "Profile updated successfully";
    header("Location: update_profile.php");
    exit;
} else {
    // If update failed, redirect back with an error message
    header("Location: update_profile.php?message=Error updating profile");
    exit;
}
?>
