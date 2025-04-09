<?php
// Include the database connection file
include 'db.php';  // Ensure this file exists and contains the PDO setup

header('Content-Type: application/json');

// Get the POST data
$input = json_decode(file_get_contents('php://input'), true);

// Validate that the ID exists
if (isset($input['id'])) {
    $planId = $input['id'];

    // Prepare and execute the delete query
    try {
        $sql = "DELETE FROM savings WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $planId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Check if any rows were deleted
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No rows deleted. Plan ID may not exist.']);
        }
    } catch (PDOException $e) {
        // Log error for debugging (could be written to a log file or displayed)
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request. No plan ID provided.']);
}
?>
