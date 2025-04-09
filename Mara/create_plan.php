<?php
// create_plan.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Database connection
    $host = 'localhost';
    $db = 'microsavings';
    $user = 'root';
    $pass = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the insert query
        $sql = "INSERT INTO savings (user_id, name, description, amount, type)
                VALUES (:user_id, :name, :description, :amount, :type)";
       
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':type', $type);

        // Execute the query
        $stmt->execute();

        echo "Savings plan created successfully!";
        header('Location: savings.html'); // Redirect to the savings plans page
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
