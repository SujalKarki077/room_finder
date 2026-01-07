<?php
session_start();
include '../config/db.php';

$id = (int)$_GET['id'];
$conn->query("UPDATE users SET status='active' WHERE id=$id");

header("Location: manage_users.php");
