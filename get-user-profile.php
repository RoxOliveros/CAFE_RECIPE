<?php
require_once 'config/database.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($user_id <= 0) {
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

try {
    $sql = "SELECT 
                u.user_id, 
                u.username, 
                u.email, 
                u.display_name, 
                u.avatar_img, 
                u.bio, 
                u.created_at,
                (SELECT COUNT(*) FROM recipes WHERE user_id = u.user_id) AS recipes_count,
                (SELECT COUNT(*) FROM followers WHERE follower_id = u.user_id) AS following_count,
                (SELECT COUNT(*) FROM followers WHERE following_id = u.user_id) AS follower_count
            FROM users u
            WHERE u.user_id = ?";

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
        
        echo json_encode([
            'user_id' => (int)$user['user_id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'display_name' => $user['display_name'],
            'avatar_img' => $user['avatar_img'],
            'bio' => $user['bio'],
            'created_at' => $user['created_at'],
            'recipes_count' => (int)$user['recipes_count'],
            'following_count' => (int)$user['following_count'],
            'follower_count' => (int)$user['follower_count']
        ]);

    } else {
        throw new Exception("Invalid username or password");
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
$stmt->close();
?>