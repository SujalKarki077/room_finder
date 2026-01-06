<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$owner_id = $_SESSION['user_id'];
$title = $_POST['title'];
$location = $_POST['location'];
$price = $_POST['price'];
$room_type = $_POST['room_type'];
$description = $_POST['description'];

// IMAGE UPLOAD
$image_name = time() . "_" . $_FILES['image']['name'];
$upload_path = "../uploads/" . $image_name;

// CREATE uploads folder if not exists
if (!is_dir("../uploads")) {
    mkdir("../uploads", 0777, true);
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
    die("Image upload failed");
}

// INSERT DATA
$sql = "INSERT INTO rooms 
(owner_id, title, location, price, room_type, description, image) 
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "issdsss",
    $owner_id,
    $title,
    $location,
    $price,
    $room_type,
    $description,
    $image_name
);

$stmt->execute();

header("Location: ../public/home.php");
exit;
