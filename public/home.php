<?php
session_start();
include '../config/db.php';

$where = "WHERE 1";


// SEARCH BY LOCATION (STARTS WITH)
if (!empty($_GET['location'])) {
    $location = $conn->real_escape_string($_GET['location']);
    $where .= " AND location LIKE '$location%'";
}

$sql = "SELECT * FROM rooms $where ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html>
<head>
  <title>Room Finder</title>
 <link rel="stylesheet" href="css/style.css">

</head>
<body>

<header class="navbar">
  <div class="logo">🏠 RoomFinder</div>
  <nav>
  <a href="home.php">Home</a>
  <a href="favorite.php">Favorite</a>

<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
    <a href="../admin/dashboard.php">Admin Panel</a>
<?php endif; ?>

<?php if (isset($_SESSION['is_lister']) && $_SESSION['is_lister'] == 1): ?>
  <a href="add_room.php">Add Room</a>
  <a href="my_rooms.php">My Rooms</a>
  <a href="booking_requests.php">Booking Requests</a>
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
  <input type="text" name="location" placeholder="Search location"
         value="<?= $_GET['location'] ?? '' ?>">
  <button type="submit">Search</button>
</form>

  </div>
</section>

<section class="section">
  <h2>Available Rooms</h2>

  <div class="card-grid">
  <?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="card">
      <img src="../uploads/<?= htmlspecialchars($row['image'] ?? 'default.jpg') ?>">
      
      <div class="card-body">
        <h3><?= htmlspecialchars($row['title']) ?></h3>

        <p class="location"><?= htmlspecialchars($row['location']) ?></p>

        <p>Rs. <?= htmlspecialchars($row['price']) ?></p>

        <span class="tag"><?= htmlspecialchars($row['room_type'] ?? 'N/A') ?></span>
      <?php if (isset($_SESSION['user_id'])): ?>
       <form action="../api/toggle_favorite.php" method="POST" class="fav-form">
         <input type="hidden" name="room_id" value="<?= $row['id'] ?>">
         <button type="submit" class="fav-btn">❤️</button>
       </form>
    <?php endif; ?>

       <a href="room.php?id=<?= $row['id'] ?>" class="btn">Know More</a>

      <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['owner_id']): ?>
          <a href="edit_room.php?id=<?= $row['id'] ?>" class="btn edit-btn">
            Edit
          </a>

     <form action="../api/delete_room.php" method="POST" style="display:inline;">
       <input type="hidden" name="id" value="<?= $row['id'] ?>">
       <button type="submit" class="btn delete-btn"
           onclick="return confirm('Are you sure you want to delete this room?')">
           Delete
       </button>
  </form>
<?php endif; ?>

      </div>
    </div>
  <?php endwhile; ?>
  </div>
</section>

</body>
</html>
