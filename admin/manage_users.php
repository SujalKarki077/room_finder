<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../public/login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/manage_users.css">
</head>
<body>

<div class="admin-container">
<h2>Manage Users</h2>
<a href="dashboard.php" class="back-btn">⬅ Back</a>

<table class="admin-table">
<tr>
    <th>Username</th>
    <th>Role</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($u = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($u['username']) ?></td>
    <td>
        <?= $u['is_admin'] ? 'Admin' : ($u['is_lister'] ? 'Owner' : 'User') ?>
    </td>
    <td><?= $u['status'] ?? 'active' ?></td>
    <td>
        <?php if ($u['status'] != 'blocked'): ?>
            <a href="block_user.php?id=<?= $u['id'] ?>">Block</a>
        <?php else: ?>
            <a href="unblock_user.php?id=<?= $u['id'] ?>">Unblock</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>