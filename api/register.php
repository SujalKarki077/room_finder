<?php
session_start();
include '../config/db.php'; // db connection
$username = $_POST['rf_user_123'] ?? '';
$email = $_POST['rf_mail_456'] ?? '';
$password = $_POST['rf_pass_789'] ?? '';
$is_lister = isset($_POST['is_lister']) ? 1 : 0;

if (empty($username) || empty($email) || empty($password)) {
    die("All fields are required!");
}

// Check for existing username/email
$check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Redirect back to registration with error
    header("Location: ../public/register.php?error=exists");
    exit;
}
$check->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$sql = "INSERT INTO users (username, email, password, is_lister) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $username, $email, $hashed_password, $is_lister);

if ($stmt->execute()) {
    // Set session variables
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $username;
    $_SESSION['is_lister'] = $is_lister;
    $_SESSION['is_admin'] = 0;

    // Redirect to homepage
    header("Location: ../public/home.php");
    exit;
} else {
    header("Location: ../public/register.php?error=db");
    exit;
}

$stmt->close();
$conn->close();
?>
