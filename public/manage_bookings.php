<?php
session_start();
include '../config/db.php';

if (!$_SESSION['is_admin'] && !$_SESSION['is_lister']) {
    die("Access denied");
}

$sql = "SELECT bookings.id, rooms.title, users.username, bookings.status
        FROM bookings
        JOIN rooms ON rooms.id = bookings.room_id
        JOIN users ON users.id = bookings.user_id";

$result = mysqli_query($conn, $sql);
?>

<h2>Booking Requests</h2>

<?php while($row = mysqli_fetch_assoc($result)): ?>
  <p>
    <?= $row['title'] ?> |
    <?= $row['username'] ?> |
    <?= $row['status'] ?>

    <a href="../api/update_booking.php?id=<?= $row['id'] ?>&status=approved">Approve</a>
    <a href="../api/update_booking.php?id=<?= $row['id'] ?>&status=rejected">Reject</a>
  </p>
<?php endwhile; ?>
