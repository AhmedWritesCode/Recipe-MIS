<?php
session_start();
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare('DELETE FROM recipes WHERE id = ?');
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: my_recipes.html');
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>
