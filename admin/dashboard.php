<?php
include 'admin_guard.php';
include '../config/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-dashboard">

    <h2>Welcome Admin: <?= htmlspecialchars($_SESSION['username']) ?></h2>

    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_rooms.php">Manage Rooms</a></li>
        <li><a href="../public/logout.php" class="logout">Logout</a></li>
    </ul>

</div>

</body>
</html>
