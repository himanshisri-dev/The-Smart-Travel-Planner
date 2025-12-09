<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION["user_name"]; ?>!</h2>
    <p>This is the dashboard/home page after successful login.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
