<?php
session_start();
include('db_connection.php');

// Check if admin is logged in by verifying session variable
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.html'); // redirect if not logged in
    exit(); // stop script execution
}

$users = $conn->query('SELECT * FROM users')->fetch_all(MYSQLI_ASSOC);
$admins = $conn->query('SELECT * FROM administrators')->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .dashboard {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 800px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h2 {
            margin-top: 0;
        }
    </style>
</head>
<body style="background-image: url('7.png'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    <main>
        <div class="dashboard">
            <h1>Admin Dashboard</h1>
            <h2>Users</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h2>Administrators</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo $admin['id']; ?></td>
                        <td><?php echo $admin['username']; ?></td>
                        <td><?php echo $admin['email']; ?></td>
                        <td><?php echo $admin['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>
</html>
