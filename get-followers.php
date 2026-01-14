<?php
require_once 'config/database.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($user_id <= 0) {
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

try {
    // Get user's recipes with stats
    $sql = "SELECT 
                u.user_id,
                u.username,
                u.display_name,
                u.avatar_img,
                f.following_id
            FROM users u
            JOIN followers f ON u.user_id = f.follower_id
            WHERE following_id = ?
            ORDER BY u.display_name ASC";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $follower = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $follower[] = [
                'id' => (int)$row['user_id'],
                'username' => $row['username'],
                'display_name' => $row['display_name'],
                'avatar_img' => $row['avatar_img'],
            ];
        }
    }
    
    echo json_encode($follower);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>