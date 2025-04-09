<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Database connection using PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "microsavings";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$user_id = $_SESSION['user_id'];

// Fetch user data including profile picture
$sql = "SELECT memberName, nationalID, email, dob, phone, role, savings AS savings_frequency, amount, profile_picture 
        FROM users 
        WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $_SESSION['name'] = $user['memberName'];
    $_SESSION['nationalID'] = $user['nationalID'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['dob'] = $user['dob'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['savings_frequency'] = $user['savings_frequency'];
    $_SESSION['savings_amount'] = $user['amount'];
} else {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="prof.css">
</head>
<body>

    <h2>Edit Your Profile</h2>

    <?php
 $profilePicture = 'Images/user.png'; // fallback
 if (!empty($user['profile_picture'])) {
     $profilePicture = htmlspecialchars($user['profile_picture']);
 }
 
    ?>

    <h3>Profile Picture</h3>
    <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="width:120px;height:120px;border-radius:50%;border:2px solid #ccc;"><br><br>

    <form action="upload_picture.php" method="post" enctype="multipart/form-data">
        <input type="file" name="profile_picture" accept="image/*" required>
        <button type="submit">Upload Picture</button>
    </form>

    <br><hr><br>

    <!-- Profile Edit Form -->
    <form action="updateprofile.php" method="post">
        <label for="memberName">Full Names:</label><br>
        <input type="text" id="memberName" name="memberName" value="<?php echo htmlspecialchars($user['memberName']); ?>" required><br>

        <label for="nationalID">National ID:</label><br>
        <input type="text" id="nationalID" name="nationalID" value="<?php echo htmlspecialchars($user['nationalID']); ?>" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required><br>

        <label for="role">Role:</label><br>
        <select name="role" id="role" required>
            <option value="member" <?php echo ($user['role'] == 'member') ? 'selected' : ''; ?>>Member</option>
            <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select><br>

        <label for="savings">Savings Frequency:</label><br>
        <select name="savings" id="savings" required>
            <option value="weekly" <?php echo ($user['savings_frequency'] == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
            <option value="monthly" <?php echo ($user['savings_frequency'] == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
            <option value="daily" <?php echo ($user['savings_frequency'] == 'daily') ? 'selected' : ''; ?>>Daily</option>
        </select><br>

        <label for="amount">Amount:</label><br>
        <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($user['amount']); ?>" required><br><br>

        <button type="submit">Update Profile</button>
    </form>

    <div>
        <p><a href="login.html">Back to Login</a></p>
    </div>

</body>
</html>
