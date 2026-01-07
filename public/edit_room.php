<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  die("Unauthorized access");
}

$room_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

/* Fetch ONLY if room belongs to logged-in user */
$sql = "SELECT * FROM rooms WHERE id = ? AND owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $room_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

if (!$room) {
  die("You cannot edit this room");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Room</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Edit Your Room</h2>

<form method="POST" action="../api/update_room.php">
  <input type="hidden" name="id" value="<?= $room['id'] ?>">

  <label>Title</label>
  <input type="text" name="title" value="<?= htmlspecialchars($room['title']) ?>" required>

  <label>Location</label>
  <input type="text" name="location" value="<?= htmlspecialchars($room['location']) ?>" required>

  <label>Price</label>
  <input type="number" name="price" value="<?= $room['price'] ?>" required>

  <label>Description</label>
  <textarea name="description"><?= htmlspecialchars($room['description']) ?></textarea>

  <button type="submit">Update Room</button>
</form>

</body>
</html>
