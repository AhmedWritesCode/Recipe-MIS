<?php
include 'db_connection.php';

// Assuming you have a session to track the logged-in user
session_start();
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

$response = array();

if ($userId !== null) {
    $sql = "SELECT r.id, r.title, r.category, r.ingredients, r.steps
            FROM recipes r
            JOIN favourites f ON r.id = f.recipe_id
            WHERE f.user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response['error'] = 'Failed to execute query: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['error'] = 'Failed to prepare statement: ' . $conn->error;
    }
} else {
    $response['error'] = 'User not logged in';
}

$conn->close();
echo json_encode($response);
?>
