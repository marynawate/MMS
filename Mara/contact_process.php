<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $to = "mary.nawate@gmail.com"; // Replace with your email address
    $subject="Contact Form Submission: " . $subject;
    $message = "Name: " . $name . "\n" .
               "Email: " . $email . "\n\n" .
               "Message:\n" . $message;
    $headers = "From: " . $email;

    if (mail($to, $subject, $message, $headers)) {
        echo "<p style='color: green; text-align: center;'>Message sent successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Failed to send message.</p>";
    }
}
?>


