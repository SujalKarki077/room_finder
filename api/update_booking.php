<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$booking_id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$booking_id || !in_array($action, ['approved', 'rejected'])) {
    die("Invalid request");
}

$owner_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "UPDATE bookings
     SET status = ?
     WHERE id = ? AND owner_id = ?"
);

$stmt->bind_param("sii", $action, $booking_id, $owner_id);
$stmt->execute();

header("Location: ../public/booking_requests.php");
exit;
