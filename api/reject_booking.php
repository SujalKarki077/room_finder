<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['is_lister']) || $_SESSION['is_lister'] != 1) {
    exit("Unauthorized");
}

$id = (int)$_GET['id'];

mysqli_query($conn, "
    UPDATE bookings 
    SET status='rejected' 
    WHERE id=$id
");

header("Location: ../public/booking_requests.php");
exit;
