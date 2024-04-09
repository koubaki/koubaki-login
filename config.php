<?php
session_start();
if (empty($_SESSION['loggedin'])) $_SESSION['loggedin'] = false;

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'db');

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error) {
    die('Connect error: ' . $conn->connect_error);
}

function login($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare('SELECT password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        if (password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function register($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare('SELECT username FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows < 1) {
        $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        
        return true;
    } else {
        return false;
    }
}
?>