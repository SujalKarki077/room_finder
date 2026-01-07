<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$owner_id = $_SESSION['user_id'];

$sql = "SELECT * FROM rooms WHERE owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php while($room = $result->fetch_assoc()): ?>
  <div class="card">conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php while($room = $result->fetch_assoc()): ?>
  <div class="card">
    <h3><?= htmlspecialchars($room['title']) ?></h3>
    <p><?= htmlspecialchars($room['location']) ?></p>
    <p>Rs. <?= $room['price'] ?></p>

    <a href="edit_room.php?id=<?= $room['id'] ?>" class="btn">
      Edit
    </a>
  </div>
<?php endwhile; ?>
