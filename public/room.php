<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    die("Room ID not provided");
}

$id = (int) $_GET['id'];

/* Fetch room + owner */
$sql = "SELECT r.*, u.username, u.phone, u.email
        FROM rooms r
        JOIN users u ON r.owner_id = u.id
        WHERE r.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

if (!$room) {
    die("Room not found");
}

/* Check booking status for logged-in user */
$bookingStatus = null;

if (isset($_SESSION['user_id'])) {
    $check = $conn->prepare(
        "SELECT status FROM bookings WHERE room_id = ? AND user_id = ?"
    );
    $check->bind_param("ii", $room['id'], $_SESSION['user_id']);
    $check->execute();
    $res = $check->get_result();
    $booking = $res->fetch_assoc();
    $bookingStatus = $booking['status'] ?? null;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($room['title']) ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2><?= htmlspecialchars($room['title']) ?></h2>

<img src="../uploads/<?= htmlspecialchars($room['image'] ?? 'default.jpg') ?>" width="400">

<p><strong>Location:</strong>
  <?= htmlspecialchars($room['location'] ?? 'Not specified') ?>
</p>

<p><strong>Price:</strong>
  Rs. <?= htmlspecialchars($room['price'] ?? '0') ?>
</p>

<p><strong>Description:</strong><br>
  <?= nl2br(htmlspecialchars($room['description'] ?? 'No description available')) ?>
</p>

<hr>

<h3>Owner Contact</h3>
<p><strong>Name:</strong> <?= htmlspecialchars($room['username']) ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($room['phone'] ?? 'Not provided') ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($room['email'] ?? 'Not provided') ?></p>

<hr>

<!-- BOOKING SECTION -->
<?php if (!isset($_SESSION['user_id'])): ?>

  <p><strong>Please login to book this room.</strong></p>

<?php elseif ($_SESSION['user_id'] == $room['owner_id']): ?>

  <p><strong>You are the owner of this room.</strong></p>

<?php elseif ($bookingStatus === 'pending'): ?>

  <button class="btn" disabled>Request Sent</button>

<?php elseif ($bookingStatus === 'approved'): ?>

  <button class="btn success" disabled>✅ Booking Confirmed</button>

<?php elseif ($bookingStatus === 'rejected'): ?>

  <button type="button"
          onclick="bookRoom(<?= (int)$room['id'] ?>)"
          class="btn">
    Request Again
  </button>
  <p id="book-msg"></p>

<?php else: ?>

  <button type="button"
          onclick="bookRoom(<?= (int)$room['id'] ?>)"
          class="btn">
    Book Now
  </button>
  <p id="book-msg"></p>

<?php endif; ?>

<script src="../js/booking.js"></script>

</body>
</html>
