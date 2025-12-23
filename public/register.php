<?php if (isset($_GET['error'])): ?>
    <p style="color:red;">
        <?php
        if ($_GET['error'] === 'exists') echo "Username or email already exists.";
        if ($_GET['error'] === 'db') echo "Database error, try again.";
        ?>
    </p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Room Finder</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; display: flex; justify-content: center; align-items: center; height: 100vh; }
        form { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; width: 100%; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .login-link { text-align: center; margin-top: 10px; }
    </style>
</head>
<body>

<form action="../api/register.php" method="POST">

    <h2>Register</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <!-- Optional: Checkbox if user wants to be a lister -->
    <label>
        <input type="checkbox" name="is_lister" value="1"> I want to list rooms
    </label>

    <button type="submit">Register</button>

    <div class="login-link">
      Already registered? <a href="login.php">Login here</a>

    </div>
</form>

</body>
</html>
