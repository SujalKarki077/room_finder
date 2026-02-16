<?php
session_start();
include '../config/db.php';

/* Only logged-in listers */
if (!isset($_SESSION['user_id']) || $_SESSION['is_lister'] != 1) {
    die("Unauthorized");
}

$booking_id = (int)($_GET['id'] ?? 0);
$owner_id   = $_SESSION['user_id'];

/* 1️⃣ Verify booking belongs to this owner */
$stmt = $conn->prepare(
    "SELECT room_id FROM bookings WHERE id = ? AND owner_id = ?"
);
$stmt->bind_param("ii", $booking_id, $owner_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid booking request");
}

$booking = $result->fetch_assoc();
$room_id = $booking['room_id'];

/* 2️⃣ Approve selected booking */
$approve = $conn->prepare(
    "UPDATE bookings SET status = 'approved' WHERE id = ?"
);
$approve->bind_param("i", $booking_id);
$approve->execute();

/* 3️⃣ Reject other bookings for same room */
$reject = $conn->prepare(
    "UPDATE bookings 
     SET status = 'rejected' 
     WHERE room_id = ? AND id != ?"
);
$reject->bind_param("ii", $room_id, $booking_id);
$reject->execute();

/* 4️⃣ Redirect back to owner dashboard */
header("Location: ../public/my_rooms.php");
exit;
