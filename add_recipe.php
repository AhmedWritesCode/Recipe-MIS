<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare('INSERT INTO recipes (user_id, title, category, ingredients, steps) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('issss', $user_id, $title, $category, $ingredients, $steps);

    if ($stmt->execute()) {
        header('Location: my_recipes.html');
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>
