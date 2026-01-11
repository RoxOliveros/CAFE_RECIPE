<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config/database.php';

$user_id = $_SESSION['user_id'];

try {
    // Get all public recipes with user info
    $sql = "SELECT 
                r.recipe_id,
                r.title,
                r.description,
                r.category,
                r.thumbnail_url,
                r.cooking_time,
                r.servings,
                r.likes_count,
                r.comments_count,
                r.created_at,
                u.username,
                u.display_name,
                u.avatar_img,
                (SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = r.recipe_id AND user_id = ?) AS user_liked
            FROM recipes r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.visibility = 'public'
            ORDER BY user_liked DESC, r.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $recipes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Map category to label
            $categoryLabels = [
                'cakes' => 'CAKE',
                'cookies' => 'COOKIES',
                'frozen' => 'FROZEN',
                'pies' => 'PIE',
                'custards' => 'CUSTARD'
            ];
            
            $recipes[] = [
                'id' => (int)$row['recipe_id'],
                'title' => $row['title'],
                'category' => $row['category'],
                'categoryLabel' => $categoryLabels[$row['category']] ?? strtoupper($row['category']),
                'image' => $row['thumbnail_url'],
                'creator' => '@' . $row['username'],
                'creatorAvatar' => $row['avatar_img'] ?? 'Asset/no-profile.jpg',
                'likes' => (int)$row['likes_count'],
                'comments' => (int)$row['comments_count'],
                'description' => $row['description'],
                'time' => $row['cooking_time'],
                'isLiked' => (bool)$row['user_liked']
            ];
        }
    }

    echo json_encode($recipes);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>

