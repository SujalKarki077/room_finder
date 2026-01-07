<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  die("Unauthorized");
}

$id = $_POST['id'];
$title = $_POST['title'];
$location = $_POST['location'];
$price = $_POST['price'];
$description = $_POST['description'];
$user_id = $_SESSION['user_id'];

/* Update ONLY if owner_id matches */
$sql = "UPDATE rooms 
        SET title=?, location=?, price=?, description=? 
        WHERE id=? AND owner_id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
  "ssdssi",
  $title,
  $location,
  $price,
  $description,
  $id,
  $user_id
);

$stmt->execute();

header("Location: ../public/home.php");
exit;
