<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Room Finder</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; display: flex; justify-content: center; align-items: center; height: 100vh; }
        form { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; width: 100%; background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
        .register-link { text-align: center; margin-top: 10px; }
    </style>
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
