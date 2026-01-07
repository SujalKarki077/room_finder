<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Access denied");
}

$id = (int) $_GET['id'];

// delete image (optional)
$res = $conn->query("SELECT image FROM rooms WHERE id=$id");
$row = $res->fetch_assoc();
if ($row && $row['image']) {
    @unlink("../uploads/" . $row['image']);
}

$conn->query("DELETE FROM rooms WHERE id=$id");

header("Location: manage_rooms.php");
exit;
