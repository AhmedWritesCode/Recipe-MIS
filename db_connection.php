<?php
$host = 'localhost'; // hostname
$db = 'healthy_recipes'; // db
$user = 'root'; // default username for MySQL db admin
$pass = ''; // no password

$conn = new mysqli($host, $user, $pass, $db); // Establish conn

if ($conn->connect_error) { // Check connection
    die('Connection failed: ' . $conn->connect_error);
}
?>
