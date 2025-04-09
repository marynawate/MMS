<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$userId = $_SESSION['user_id'];
$targetDir = "Images/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$filename = basename($_FILES["profile_picture"]["name"]);
$targetFile = $targetDir . time() . "_" . $filename;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Validate image
$check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
if ($check === false) {
    die("File is not an image.");
}

// Only allow certain formats
if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
    die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
}

if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=microsavings", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update profile picture path
        $sql = "UPDATE users SET profile_picture = :path WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':path', $targetFile);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        header("Location: update_profile.php"); // Redirect to profile page
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Failed to upload file.");
}
?>
