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
                r.recipe_id,
                r.title,
                r.category,
                r.thumbnail_url,
                r.cooking_time,
                r.servings,
                r.likes_count,
                r.saves_count,
                r.comments_count,
                r.visibility,
                r.created_at,
                l.like_id
            FROM recipes r
            JOIN recipe_likes l ON r.recipe_id = l.recipe_id
            WHERE l.user_id = ? AND visibility = 'public'
            ORDER BY l.created_at DESC";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Map category to readable name
    $categoryMap = [
        'cakes' => 'Cakes & Cupcakes',
        'cookies' => 'Cookies & Bars',
        'frozen' => 'Frozen Desserts',
        'pies' => 'Pies & Tarts',
        'custards' => 'Custards & Puddings'
    ];
    
    $likes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $likes[] = [
                'id' => (int)$row['recipe_id'],
                'title' => $row['title'],
                'category' => $categoryMap[$row['category']] ?? ucfirst($row['category']),
                'image' => $row['thumbnail_url'] ?: 'Asset/default-recipe.jpg',
                'time' => $row['cooking_time'],
                'servings' => (int)$row['servings'],
                'likes' => (int)$row['likes_count'],
                'saves' => (int)$row['saves_count'],
                'comments' => (int)$row['comments_count'],
                'createdDate' => date('Y-m-d', strtotime($row['created_at'])),
                'visibility' => $row['visibility'],
                'isLiked' => (bool)$row['like_id']
            ];
        }
    }
    
    // Calculate total stats
    $totalLikes = array_sum(array_column($likes, 'likes'));
    $totalComments = array_sum(array_column($likes, 'comments'));
    $totalRecipes = count($likes);
    $totalSaves = count($likes);
    
    $response = [
        'liked_recipes' => $likes,
        'saved_stats' => [
            'totalRecipes' => $totalRecipes,
            'totalLikes' => $totalLikes,
            'totalSaves' => $totalSaves,
            'totalComments' => $totalComments
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>