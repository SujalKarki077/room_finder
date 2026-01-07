<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT rooms.*
FROM rooms
JOIN favorites ON rooms.id = favorites.room_id
WHERE favorites.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<h2>My Favorite Rooms</h2>

<div class="card-grid">
<?php while($row = $result->fetch_assoc()): ?>
  <div class="card">
    <img src="../uploads/<?= htmlspecialchars($row['image'] ?? 'default.jpg') ?>">
    <div class="card-body">
      <h3><?= htmlspecialchars($row['title']) ?></h3>
      <p><?= htmlspecialchars($row['location']) ?></p>
      <p>Rs. <?= $row['price'] ?></p>

      <a href="room.php?id=<?= $row['id'] ?>" class="btn">Know More</a>
    </div>
  </div>
<?php endwhile; ?>
</div>
