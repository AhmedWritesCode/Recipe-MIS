<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $stmt = $conn->prepare('INSERT INTO administrators (username, password, email) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $username, $password, $email);

    if ($stmt->execute()) {
        header('Location: admin_login.html');
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>