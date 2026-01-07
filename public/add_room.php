<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_lister'] != 1) {
    die("Access denied. Only room owners can add rooms.");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Room</title>
  <link rel="stylesheet" href="/roomfinder/public/css/add_room.css">
</head>
<body>

<h2>Add New Room</h2>

<div class="add-room-container">
  <h2>Add New Room</h2>
 
  <form method="POST" action="/roomfinder/api/add_room.php" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Room Title" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="number" name="price" placeholder="Price" required>

    <select name="room_type" required>
      <option value="Girls">Girls</option>
      <option value="Boys">Boys</option>
      <option value="Mixed">Mixed</option>
    </select>
   <textarea name="description" placeholder="Room description"></textarea>
    <input type="file" name="image" required>
    <button type="submit">Add Room</button>
  </form>
</div>

</body>
</html>
