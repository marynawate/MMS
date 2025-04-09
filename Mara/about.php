<?php
// about.php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        header{
    background-color: rgb(57, 146, 212);
    align-items: center;
    justify-content: center;
}
.topnav{
  text-align: right;
    position:relative;
    padding: 10px 10%;
    width: 100%; 
    overflow: hidden;
    display: flex;
    justify-content: center;
    margin: auto;
}
        body {
            font-family: sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 80px 20px 20px; /* Adjusted padding for navigation */
            background-image: url('Images/background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: #333;
        }

        .about-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .about-container h1, .about-container h2 {
            color: #0056b3;
            text-align: center;
        }

        .about-container p {
            margin-bottom: 20px;
        }

        .about-container ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        .about-container li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>

<div class="topnav">
    <a href="home.html">Home </a>
<a href="register.html"target="_blank">Register</a>
<a href="login.html">Log in</a>
<a href="contact.php">Contact Us</a>
<a href="profile.html">Profile
</a>
</header>
    <div class="about-container">
        <h1>About Our Financial Services</h1>

        <p>Welcome to our financial services platform. We are dedicated to providing reliable and efficient financial solutions to our members. Our goal is to empower individuals and businesses to achieve their financial objectives through our comprehensive range of services.</p>

        <h2>Our Mission</h2>
        <p>Our mission is to foster financial growth and security for our members by offering accessible and transparent financial services. We strive to build long-term relationships based on trust and mutual respect.</p>

        <h2>Our Services</h2>
        <p>We offer a variety of financial services tailored to meet the diverse needs of our members, including:</p>

        <ul>
            <li>Savings Accounts: Secure and flexible savings options to help you grow your wealth.</li>
            <li>Loan Services: Competitive loan options for personal and business needs.</li>
            <li>Online Banking: Convenient and secure online access to manage your finances.</li>
            <li>Financial Advisory: Expert advice to help you make informed financial decisions.</li>
        </ul>

        <h2>Our Values</h2>
        <p>We are guided by the following core values:</p>

        <ul>
            <li>Integrity: We conduct our business with the highest ethical standards.</li>
            <li>Transparency: We believe in clear and open communication.</li>
            <li>Customer Focus: We prioritize the needs and satisfaction of our members.</li>
            <li>Innovation: We continuously seek to improve our services and processes.</li>
        </ul>

        <p>Thank you for choosing us as your trusted financial partner. We look forward to serving you and helping you achieve your financial goals.</p>
    </div>
</body>
</html>