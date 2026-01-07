<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  die("Unauthorized");
}

$room_id = $_POST['id'];
$user_id = $_SESSION['user_id'];

/* Delete only if owner matches */
$sql = "DELETE FROM rooms WHERE id = ? AND owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $room_id, $user_id);
$stmt->execute();

header("Location: ../public/home.php");
exit;
