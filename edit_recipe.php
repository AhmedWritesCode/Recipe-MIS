<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare('UPDATE recipes SET title = ?, category = ?, ingredients = ?, steps = ? WHERE id = ? AND user_id = ?');
    $stmt->bind_param('ssssii', $title, $category, $ingredients, $steps, $id, $user_id);

    if ($stmt->execute()) {
        header('Location: my_recipes.html');
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>
