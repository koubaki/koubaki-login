<?php
include 'config.php';

if ($_SESSION['loggedin']) header('Location: index.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (((empty($_POST['username'])) || (strlen($_POST['username']) > 50)) && ((empty($_POST['password'])) || (strlen($_POST['password']) < 8))) {
        $message = 'Both username and password are required. Username mustn\'t be more than 50 characters, and password must be at least 8 characters';
    } elseif ((empty($_POST['username'])) || (strlen($_POST['username']) > 50)) {
        $message = 'Username is required, and mustn\'t be more than 50 characters.';
    } elseif ((empty($_POST['password'])) || (strlen($_POST['password']) < 8)) {
        $message = 'Password is required, and must be at least 8 characters.';
    } else {
        $san_username = strtolower(trim(stripslashes($_POST['username'])));
        $san_password = password_hash(trim(stripslashes($_POST['password'])), PASSWORD_DEFAULT);
        
        $login = login($_POST['username'], $_POST['password']);
        
        if ($login) {
            $_SESSION['loggedin'] = true;
            
            $_SESSION['username'] = $san_username;
            $_SESSION['password'] = $san_password;
        } else {
            $message = 'Wrong username or password.';
        }
    }
} else {
    $message = 'Login or Register to continue.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>
<body>
	<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
		<label for="username">Username: </label>
		<input type="text" name="username" id="username" max="50">
		<br>
		<label for="password">Password: </label>
		<input type="password" name="password" id="password" min="8">
		<br>
		<input type="submit">
	</form>
	<p><?= $message ?></p>
	<a href="register.php">Register</a>
</body>
</html>