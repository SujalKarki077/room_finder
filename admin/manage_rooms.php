<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../public/login.php");
    exit;
}

$result = mysqli_query($conn, "
    SELECT rooms.*, users.username 
    FROM rooms 
    JOIN users ON rooms.owner_id = users.id 
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>come Admin: Sujalkarki(Admin)

    Manage Users
    Manage Rooms
    Logout

<head>
    <title>Manage Rooms</title>
</head>
<body>

<h2>All Rooms (Admin)</h2>
<a href="dashboard.php">⬅ Back</a>

<table border="1" cellpadding="10">
<tr>
    <th>Title</th>
    <th>Owner</th>
    <th>Location</th>
    <th>Price</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['title']) ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= htmlspecialchars($row['location']) ?></td>
    <td><?= $row['price'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <?php if ($row['status'] == 'pending'): ?>
            <a href="approve_room.php?id=<?= $row['id'] ?>">Approve</a>
        <?php endif; ?>

        | <a href="delete_room.php?id=<?= $row['id'] ?>"
             onclick="return confirm('Delete this room?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
