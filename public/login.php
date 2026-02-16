<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Room Finder</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<form action="../api/login.php" method="POST">

    <h2>Login</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>

    <div class="register-link">
    Don't have an account? <a href="register.php">Register here</a>


</form>

</body>
</html>
