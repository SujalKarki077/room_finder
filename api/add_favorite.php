<?php
session_start();
include_once "../config/db.php";

if(!isset($_SESSION['user_id'])){
    echo "not_logged_in";
    exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['room_name'])){
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO favorites (user_id, room_name, description) 
            VALUES (".$_SESSION['user_id'].", '$room_name', '$description')";

    if(mysqli_query($conn, $sql)){
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "invalid_request";
}
?>
