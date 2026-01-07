<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Access denied");
}

$id = (int) $_GET['id'];

$conn->query("UPDATE rooms SET status='approved' WHERE id=$id");

header("Location: manage_rooms.php");
exit;
