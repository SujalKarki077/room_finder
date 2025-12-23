<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Room Finder</title>
  <link rel="stylesheet" href="/roomfinder/public/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <div class="logo">🏠 RoomFinder</div>
  <nav>
    <a href="#">Home</a>
    <a href="favorite.php">Favorite</a>
    <a href="#">Chat</a>
  </nav>

  <?php if(isset($_SESSION['username'])): ?>
    <span class="user"><?= $_SESSION['username'] ?></span>
  <?php else: ?>
    <a class="login-btn" href="login.php">Login</a>
  <?php endif; ?>
</header>

<!-- HERO -->
<section class="hero">
  <div class="hero-overlay">
    <h1>Room Finder</h1>

    <div class="search-box">
      <input type="text" placeholder="Search location or area">
      <button>Search</button>
    </div>
  </div>
</section>

<!-- LISTINGS -->
<section class="section">
  <h2>Best Rooms for You</h2>

  <div class="card-grid">

    <!-- CARD -->
    <div class="card">
      <img src="image/rooms/room1.jpg">
      <div class="card-body">
        <h3>Kos Griya Putri</h3>
        <p>Rs. 15,000 / month</p>
        <span class="tag">Girls</span>
      </div>
    </div>

    <div class="card">
      <img src="image/rooms/room2.jpg">
      <div class="card-body">
        <h3>Kos H. Turiman</h3>
        <p>Rs. 8,500 / month</p>
        <span class="tag green">Mixed</span>
      </div>
    </div>

    <div class="card">
      <img src="image/rooms/room3.jpg">
      <div class="card-body">
        <h3>Kost Mambo</h3>
        <p>Rs. 7,500 / month</p>
        <span class="tag">Girls</span>
      </div>
    </div>

  </div>
</section>

</body>
</html>
