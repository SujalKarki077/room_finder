<?php
include 'admin_guard.php';
include '../config/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Welcome Admin: <?= $_SESSION['username'] ?></h2>

<ul>
    <li><a href="manage_users.php">Manage Users</a></li>
    <li><a href="manage_rooms.php">Manage Rooms</a></li>
    <li><a href="../public/logout.php">Logout</a></li>
</ul>

</body>
</html>
