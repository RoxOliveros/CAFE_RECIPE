<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable errors for debugging

session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in', 'avatar_img' => 'no-profile.png']);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT user_id, username, email, display_name, avatar_img, bio, created_at FROM users WHERE user_id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    throw new Exception("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    throw new Exception("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['display_name'] = $user['display_name'];
    $_SESSION['avatar_url'] = $user['avatar_img'];
    $_SESSION['bio'] = $user['bio'];
    $_SESSION['created_at'] = $user['created_at'];
    
    echo json_encode([
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'email' => $_SESSION['email'],
        'display_name' => $_SESSION['display_name'],
        'avatar_img' => $_SESSION['avatar_img'],
        'bio' => $_SESSION['bio'],
        'created_at' => $_SESSION['created_at']
    ]);
} else {
    throw new Exception("Invalid username or password");
}

$stmt->close();
?>