<?php
session_start();
include '../config/db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    die("All fields are required!");
}

/* Check username */
$sql = "SELECT id, username, password, is_lister, is_admin FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    header("Location: ../public/login.php?error=notfound");
    exit;
}

$stmt->bind_result($id, $uname, $hashed_password, $is_lister, $is_admin);
$stmt->fetch();

if (password_verify($password, $hashed_password)) {

    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $uname;
    $_SESSION['is_lister'] = $is_lister;
    $_SESSION['is_admin'] = $is_admin;

    header("Location: ../public/home.php");
    exit;

} else {
    header("Location: ../public/login.php?error=invalid");
    exit;
}

$stmt->close();
$conn->close();
