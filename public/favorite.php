<?php
session_start();
include_once "../config/db.php";

if(!isset($_SESSION['username'])){
    header("Location: home.php");
    exit();
}

$sql = "SELECT * FROM favorites WHERE user_id=".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Favorites</title>
    <link rel="stylesheet" href="/roomfinder/public/css/style.css">
</head>
<body>
<h1>Your Favorite Rooms</h1>
<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo "<div class='room'>";
        echo "<h2>".$row['room_name']."</h2>";
        echo "<p>".$row['description']."</p>";
        echo "</div>";
    }
}else{
    echo "<p>No favorites added yet.</p>";
}
?>
</body>
</html>
