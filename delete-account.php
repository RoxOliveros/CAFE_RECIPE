<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user's avatar before deletion
$stmt = $conn->prepare("SELECT avatar_img FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get user's uploaded recipe images before deletion
$stmt = $conn->prepare("SELECT thumbnail_url FROM recipes WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$recipes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Start transaction
$conn->begin_transaction();

try {
    // Delete user account (CASCADE will handle related records)
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to delete account');
    }
    
    $stmt->close();
    
    $conn->query("UPDATE recipes r SET 
        comments_count = (SELECT COUNT(*) FROM comments WHERE recipe_id = r.recipe_id),
        likes_count = (SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = r.recipe_id),
        saves_count = (SELECT COUNT(*) FROM recipe_saves WHERE recipe_id = r.recipe_id);
    ");

    // Reset AUTO_INCREMENT for all affected tables
    $conn->query("ALTER TABLE users AUTO_INCREMENT = 1");
    $conn->query("ALTER TABLE followers AUTO_INCREMENT = 1");
    $conn->query("ALTER TABLE comments AUTO_INCREMENT = 1");
    $conn->query("ALTER TABLE recipe_likes AUTO_INCREMENT = 1");
    $conn->query("ALTER TABLE recipe_saves AUTO_INCREMENT = 1");
    $conn->query("ALTER TABLE recipes AUTO_INCREMENT = 1");
    $conn->query("ALTER TABLE instructions AUTO_INCREMENT = 1");
    $conn->query("ALTER TABLE ingredients AUTO_INCREMENT = 1");
    
    // Commit transaction
    $conn->commit();
    
    // Delete user's avatar file if it exists and is uploaded
    if ($user['avatar_img'] && file_exists($user['avatar_img']) && 
        strpos($user['avatar_img'], 'Asset/') === false && 
        strpos($user['avatar_img'], 'https://') === false) {
        @unlink($user['avatar_img']);
    }
    
    // Delete user's recipe thumbnails if they're uploaded files
    foreach ($recipes as $recipe) {
        $thumbnail = $recipe['thumbnail_url'];
        if ($thumbnail && file_exists($thumbnail) && 
            strpos($thumbnail, 'uploads/') === 0) {
            @unlink($thumbnail);
        }
    }
    
    // Destroy session
    session_destroy();
    
    echo json_encode([
        'success' => true,
        'message' => 'Your account has been permanently deleted'
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete account: ' . $e->getMessage()
    ]);
}
?>