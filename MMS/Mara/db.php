<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "mms_system";


$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $mysqli_connect_error());
}


?>
