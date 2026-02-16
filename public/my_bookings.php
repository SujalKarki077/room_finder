<?php
session_start();
include '../config/db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT rooms.title, bookings.status
        FROM bookings
        JOIN rooms ON rooms.id = bookings.room_id
        WHERE bookings.user_id = $user_id";

$result = mysqli_query($conn, $sql);
?>

<h2>My Bookings</h2>

<?php while($row = mysqli_fetch_assoc($result)): ?>
  <p>
    <?= $row['title'] ?> —
    <b><?= ucfirst($row['status']) ?></b>
  </p>
<?php endwhile; ?>
