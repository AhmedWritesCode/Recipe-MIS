<?php
include 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$recipeId = isset($data['recipeId']) ? intval($data['recipeId']) : null;

// Assuming you have a session to track the logged-in user
session_start();
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

$response = array();

if ($recipeId !== null && $userId !== null) {
    $sql = "DELETE FROM favourites WHERE user_id = ? AND recipe_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $userId, $recipeId);

        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = 'Failed to execute query: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'Failed to prepare statement: ' . $conn->error;
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Invalid input';
}

$conn->close();
echo json_encode($response);
?>
