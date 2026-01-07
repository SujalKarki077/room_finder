<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  die("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$room_id = $_POST['room_id'];

/* Check if already favorited */
$sql = "SELECT id FROM favorites WHERE user_id=? AND room_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  /* Remove favorite */
  $sql = "DELETE FROM favorites WHERE user_id=? AND room_id=?";
} else {
  /* Add favorite */
  $sql = "INSERT INTO favorites (user_id, room_id) VALUES (?, ?)";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $room_id);
$stmt->execute();

header("Location: ../public/home.php");
exit;
