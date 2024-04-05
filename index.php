<?php
include 'config.php';

if (!$_SESSION['loggedin']) header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
</head>
<body>
	<p>Welcome, <span style="text-transform: capitilize;"><?= htmlspecialchars($_SESSION['username']) ?></span>!</p>
	<a href="logout.php">Logout</a>
</body>
</html>