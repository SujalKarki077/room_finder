<?php
include '../config/db.php';

if (!isset($_GET['id'])) {
    die("Room ID not provided");
}

$id = (int) $_GET['id'];

$sql = "SELECT r.*, u.username, u.phone
        FROM rooms r
        JOIN users u ON r.owner_id = u.id
        WHERE r.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$room = $result->fetch_assoc();

if (!$room) {
    die("Room not found or not approved yet");
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

<img src="../uploads/<?= htmlspecialchars($room['image']) ?>" width="400">

<p><strong>Location:</strong> <?= htmlspecialchars($room['location']) ?></p>
<p><strong>Price:</strong> Rs. <?= htmlspecialchars($room['price']) ?></p>
<p><strong>Description:</strong> <?= nl2br(htmlspecialchars($room['description'])) ?></p>

<hr>

<h3>Owner Contact</h3>
<p>Name: <?= htmlspecialchars($room['username'] ?? 'N/A') ?></p>
<p>Phone: <?= htmlspecialchars($room['phone'] ?? 'Not provided') ?></p>
<p>Email: <?= htmlspecialchars($room['email'] ?? 'Not provided') ?></p>

<button class="btn">Book Room</button>

</body>
</html>
