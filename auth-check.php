<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = false;
$userId = null;
$currentUser = null;

if (isset($_SESSION['user_id'])) {
    $isLoggedIn = true;
    $userId = $_SESSION['user_id'];
    
    require_once 'config/database.php';
    
    $stmt = $conn->prepare("SELECT user_id, username, display_name, avatar_img FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentUser = $result->fetch_assoc();
    $stmt->close();
} else {
    $currentUser = [
        'user_id' => null,
        'username' => 'Guest',
        'display_name' => 'Guest',
        'avatar_img' => 'https://ui-avatars.com/api/?name=Guest&background=cccccc&color=666&bold=true&size=40'
    ];
}
?>