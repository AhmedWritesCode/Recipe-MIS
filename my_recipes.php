<?php
session_start();
include('db_connection.php');

$user_id = $_SESSION['user_id'];

// Get sorting and filtering parameters
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$ingredient = isset($_GET['ingredient']) ? $_GET['ingredient'] : '';

// Build the query
$query = "SELECT * FROM recipes WHERE user_id = ?";

if ($category != '') {
    $query .= " AND category = ?";
}

if ($ingredient != '') {
    $query .= " AND ingredients LIKE ?";
}

$query .= " ORDER BY $sort_by $order";

$stmt = $conn->prepare($query);

// Bind parameters dynamically
if ($category != '' && $ingredient != '') {
    $like_ingredient = "%" . $ingredient . "%";
    $stmt->bind_param('iss', $user_id, $category, $like_ingredient);
} elseif ($category != '') {
    $stmt->bind_param('is', $user_id, $category);
} elseif ($ingredient != '') {
    $like_ingredient = "%" . $ingredient . "%";
    $stmt->bind_param('is', $user_id, $like_ingredient);
} else {
    $stmt->bind_param('i', $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}

echo json_encode($recipes);
?>
