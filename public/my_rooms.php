<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_lister'] != 1) {
    header("Location: login.php");
    exit;
}

$owner_id = $_SESSION['user_id'];

/* Owner rooms */
$sql = "SELECT * FROM rooms WHERE owner_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

/* Booking requests */
$bookingSql = "
SELECT b.id AS booking_id, b.status,
       u.username,
       r.title
FROM bookings b
JOIN users u ON b.user_id = u.id
JOIN rooms r ON b.room_id = r.id
WHERE b.owner_id = ?
ORDER BY b.id DESC
";
$bookingStmt = $conn->prepare($bookingSql);
$bookingStmt->bind_param("i", $owner_id);
$bookingStmt->execute();
$bookingRequests = $bookingStmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Rooms</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
  <div class="logo">🏠 RoomFinder</div>
  <nav>
    <a href="home.php">Home</a>
    <a href="add_room.php">Add Room</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<section class="section">
  <h2>Booking Requests</h2>

  <?php if ($bookingRequests->num_rows > 0): ?>
    <?php while($b = $bookingRequests->fetch_assoc()): ?>
      <div class="request-box">
        <p>
          <strong><?= htmlspecialchars($b['username']) ?></strong>
          requested
          <strong><?= htmlspecialchars($b['title']) ?></strong>
        </p>

        <?php if ($b['status'] == 'pending'): ?>
          <a href="../api/approve_booking.php?id=<?= $b['booking_id'] ?>"
             class="btn success">Approve</a>

          <a href="../api/reject_booking.php?id=<?= $b['booking_id'] ?>"
             class="btn danger">Reject</a>

        <?php elseif ($b['status'] == 'approved'): ?>
          <span class="status approved">✅ Approved</span>
        <?php else: ?>
          <span class="status rejected">❌ Rejected</span>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No booking requests yet.</p>
  <?php endif; ?>
</section>

<section class="section">
  <h2>My Added Rooms</h2>

  <div class="card-grid">
    <?php if($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
          <img src="../uploads/<?= htmlspecialchars($row['image'] ?? 'default.jpg') ?>">
          <div class="card-body">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars($row['location']) ?></p>
            <p>Rs. <?= htmlspecialchars($row['price']) ?></p>

            <a href="edit_room.php?id=<?= $row['id'] ?>" class="btn">✏ Edit</a>
            <a href="../api/delete_room.php?id=<?= $row['id'] ?>"
               class="btn danger"
               onclick="return confirm('Delete this room?')">
               ❌ Delete
            </a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>You have not added any rooms yet.</p>
    <?php endif; ?>
  </div>
</section>

</body>
</html>
