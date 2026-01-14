<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? 'fetch';

if ($action === 'fetch') {
    // Fetch notifications for likes on user's recipes
    $query = "
        SELECT 
            rl.like_id,
            rl.recipe_id,
            rl.user_id as liker_id,
            rl.created_at,
            u.username,
            u.display_name,
            u.avatar_img,
            r.title as recipe_title,
            r.thumbnail_url
        FROM recipe_likes rl
        INNER JOIN recipes r ON rl.recipe_id = r.recipe_id
        INNER JOIN users u ON rl.user_id = u.user_id
        WHERE r.user_id = ? 
        AND rl.user_id != ?
        ORDER BY rl.created_at DESC
        LIMIT 20
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $avatar = !empty($row['avatar_img']) 
            ? $row['avatar_img'] 
            : 'https://ui-avatars.com/api/?name=' . urlencode($row['display_name'] ?? $row['username']) . '&background=ff6b9d&color=fff&bold=true&size=40';
        
        $timeAgo = getTimeAgo($row['created_at']);
        
        $notifications[] = [
            'id' => $row['like_id'],
            'type' => 'like',
            'liker_id' => $row['liker_id'],
            'liker_name' => $row['display_name'] ?? $row['username'],
            'liker_avatar' => $avatar,
            'recipe_id' => $row['recipe_id'],
            'recipe_title' => $row['recipe_title'],
            'recipe_thumbnail' => $row['thumbnail_url'],
            'time_ago' => $timeAgo,
            'created_at' => $row['created_at']
        ];
    }
    
    echo json_encode([
        'notifications' => $notifications,
        'count' => count($notifications)
    ]);
    
    $stmt->close();
}

function getTimeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' min' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('M j, Y', $timestamp);
    }
}

$conn->close();
?>