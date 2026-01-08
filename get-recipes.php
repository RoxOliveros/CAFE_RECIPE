<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

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
                u.avatar_url
            FROM recipes r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.visibility = 'public'
            ORDER BY r.created_at DESC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

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
                'creatorAvatar' => $row['avatar_url'] ?? 'https://i.pravatar.cc/150?img=1',
                'likes' => (int)$row['likes_count'],
                'comments' => (int)$row['comments_count'],
                'description' => $row['description'],
                'time' => $row['cooking_time']
            ];
        }
    }

    echo json_encode($recipes);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>

