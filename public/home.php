<?php
session_start();
include "../config/db.php";

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM rooms
            WHERE title LIKE '%$search%'
            OR location LIKE '%$search%'
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM rooms ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Room Finder</title>
  <link rel="stylesheet" href="/roomfinder/public/css/style.css">
</head>
<body>

<header class="navbar">
  <div class="logo">🏠 RoomFinder</div>
  <nav>
  <a href="home.php">Home</a>
  <a href="favorite.php">Favorite</a>

  <?php if(isset($_SESSION['is_lister']) && $_SESSION['is_lister'] == 1): ?>
      <a href="add_room.php">Add Room</a>
      <a href="my_rooms.php">My Rooms</a>
  <?php endif; ?>
</nav>


  <?php if(isset($_SESSION['username'])): ?>
    <span class="user"><?= $_SESSION['username'] ?></span>
  <?php else: ?>
    <a class="login-btn" href="login.php">Login</a>
  <?php endif; ?>
</header>

<section class="hero">
  <div class="hero-overlay">
    <h1>Room Finder</h1>

    <form method="GET" class="search-box">
      <input type="text" name="search" placeholder="Search location or area"
             value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Search</button>
    </form>
  </div>
</section>

<section class="section">
  <h2>Available Rooms</h2>

  <div class="card-grid">
  <?php if(mysqli_num_rows($result) > 0): ?>
    <?php while($room = mysqli_fetch_assoc($result)): ?>
      <div class="card">
        <img src="../uploads/<?= $room['image'] ?>">
        <div class="card-body">
          <h3><?= $room['title'] ?></h3>
          <p><?= $room['location'] ?></p>
          <p>Rs. <?= $room['price'] ?> / month</p>
          <span class="tag"><?= $room['room_type'] ?></span>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No rooms found</p>
  <?php endif; ?>
  </div>
</section>

</body>
</html>
