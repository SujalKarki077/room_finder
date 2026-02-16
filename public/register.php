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
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<form action="../api/register.php" method="POST">

    <!-- Hidden trap fields -->
    <input type="text" name="hidden_user" style="display:none">
    <input type="password" name="hidden_pass" style="display:none">

    <h2>Register</h2>

    <input 
        type="text" 
        name="rf_user_123" 
        placeholder="Username" 
        autocomplete="off"
        required
    >

    <input 
        type="email" 
        name="rf_mail_456" 
        placeholder="Email" 
        autocomplete="off"
        required
    >

    <input 
        type="password" 
        name="rf_pass_789" 
        placeholder="Password" 
        autocomplete="new-password"
        required
    >

    <label>
        <input type="checkbox" name="is_lister" value="1">
        I want to list rooms
    </label>

    <button type="submit">Register</button>
        <div class="login-link">
    Already registered?
    <a href="login.php" class="login-btn">Login</a>
</div>
</form>


</body>
</html>
