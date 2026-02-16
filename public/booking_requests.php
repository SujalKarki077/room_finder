<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Login required");
}

$owner_id = $_SESSION['user_id'];

$sql = "SELECT b.id AS booking_id, b.status,
               r.title,
               u.username, u.phone
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        JOIN users u ON b.user_id = u.id
        WHERE b.owner_id = ?
        ORDER BY b.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Booking Requests</h2>

<table border="1" cellpadding="10">
<tr>
  <th>Room</th>
  <th>User</th>
  <th>Phone</th>
  <th>Status</th>
  <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= htmlspecialchars($row['title']) ?></td>
  <td><?= htmlspecialchars($row['username']) ?></td>
  <td><?= htmlspecialchars($row['phone'] ?? 'N/A') ?></td>
  <td><?= htmlspecialchars($row['status']) ?></td>
  <td>
    <?php if ($row['status'] == 'pending'): ?>
      <a href="../api/update_booking.php?id=<?= $row['booking_id'] ?>&action=approved">Approve</a> |
      <a href="../api/update_booking.php?id=<?= $row['booking_id'] ?>&action=rejected">Reject</a>
    <?php else: ?>
      —
    <?php endif; ?>
  </td>
</tr>
<?php endwhile; ?>
</table>
