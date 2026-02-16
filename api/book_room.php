<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$room_id = $_POST['room_id'] ?? null;

if (!$room_id) {
    echo "Invalid room";
    exit;
}

/* Get room owner */
$stmt = $conn->prepare("SELECT owner_id FROM rooms WHERE id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$room = $stmt->get_result()->fetch_assoc();

if (!$room) {
    echo "Room not found";
    exit;
}

$owner_id = $room['owner_id'];

/* Block if already approved */
$approved = $conn->prepare(
    "SELECT id FROM bookings WHERE room_id=? AND status='approved'"
);
$approved->bind_param("i", $room_id);
$approved->execute();
if ($approved->get_result()->num_rows > 0) {
    echo "Room already booked";
    exit;
}

/* Block duplicate pending request */
$pending = $conn->prepare(
    "SELECT id FROM bookings 
     WHERE room_id=? AND user_id=? AND status='pending'"
);
$pending->bind_param("ii", $room_id, $user_id);
$pending->execute();
if ($pending->get_result()->num_rows > 0) {
    echo "Request already sent";
    exit;
}

/* Insert booking */
$insert = $conn->prepare(
    "INSERT INTO bookings (room_id, user_id, owner_id, status)
     VALUES (?, ?, ?, 'pending')"
);
$insert->bind_param("iii", $room_id, $user_id, $owner_id);
$insert->execute();

echo "Booking request sent";
