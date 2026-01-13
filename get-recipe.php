<?php
session_start();
require_once 'config/database.php';

$isLoggedIn = isset($_SESSION['user_id']);
$userId = $isLoggedIn ? (int)$_SESSION['user_id'] : 0;
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($recipe_id <= 0) {
    echo json_encode(['error' => 'Invalid recipe ID']);
    exit;
}

try {
    // Get recipe with user info
    $sql = "SELECT 
                r.recipe_id,
                r.title,
                r.description,
                r.category,
                r.visibility,
                r.thumbnail_url,
                r.cooking_time,
                r.servings,
                r.video_type,
                r.video_url,
                r.likes_count,
                r.saves_count,
                r.views_count,
                r.created_at,
                u.username,
                u.display_name,
                u.avatar_img,
                (SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = r.recipe_id AND user_id = ?) AS user_liked,
                (SELECT COUNT(*) FROM recipe_saves WHERE recipe_id = r.recipe_id AND user_id = ?) AS user_saved
            FROM recipes r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.recipe_id = ?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("iii", $user_id, $user_id, $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'Recipe not found']);
        exit;
    }
    
    $recipe = $result->fetch_assoc();
    
    // Get ingredients
    $ingredients_sql = "SELECT ingredient_text FROM ingredients WHERE recipe_id = ? ORDER BY order_index ASC";
    $ingredients_stmt = $conn->prepare($ingredients_sql);
    
    if (!$ingredients_stmt) {
        throw new Exception("Ingredients prepare failed: " . $conn->error);
    }
    
    $ingredients_stmt->bind_param("i", $recipe_id);
    $ingredients_stmt->execute();
    $ingredients_result = $ingredients_stmt->get_result();
    
    $ingredients = [];
    while ($row = $ingredients_result->fetch_assoc()) {
        $ingredients[] = $row['ingredient_text'];
    }
    
    // Get instructions
    $instructions_sql = "SELECT instruction_text FROM instructions WHERE recipe_id = ? ORDER BY step_number ASC";
    $instructions_stmt = $conn->prepare($instructions_sql);
    
    if (!$instructions_stmt) {
        throw new Exception("Instructions prepare failed: " . $conn->error);
    }
    
    $instructions_stmt->bind_param("i", $recipe_id);
    $instructions_stmt->execute();
    $instructions_result = $instructions_stmt->get_result();
    
    $instructions = [];
    while ($row = $instructions_result->fetch_assoc()) {
        $instructions[] = $row['instruction_text'];
    }
    
    // Get comments
    $comments_sql = "SELECT 
                        c.user_id,
                        c.comment_id,
                        c.comment_text,
                        c.created_at,
                        u.username,
                        u.display_name,
                        u.avatar_img
                     FROM comments c
                     JOIN users u ON c.user_id = u.user_id
                     WHERE c.recipe_id = ?
                     ORDER BY c.created_at DESC";
    
    $comments_stmt = $conn->prepare($comments_sql);
    
    if (!$comments_stmt) {
        throw new Exception("Comments prepare failed: " . $conn->error);
    }
    
    $comments_stmt->bind_param("i", $recipe_id);
    $comments_stmt->execute();
    $comments_result = $comments_stmt->get_result();
    
    $comments = [];
    while ($row = $comments_result->fetch_assoc()) {
        $comments[] = [
            'id' => $row['comment_id'],
            'author' => $row['display_name'] ?? $row['username'],
            'username' => '@' . $row['username'],
            'avatar' => $row['avatar_img'] ?? 'Asset/no-profile.jpg',
            'date' => date('Y-m-d', strtotime($row['created_at'])),
            'text' => $row['comment_text'],
            'authorId' => $row['user_id']
        ];
    }
    
    // Get comment count
    $comments_count = count($comments);
    
    // Map category to readable name
    $categoryMap = [
        'cakes' => 'Cakes & Cupcakes',
        'cookies' => 'Cookies & Bars',
        'frozen' => 'Frozen Desserts',
        'pies' => 'Pies & Tarts',
        'custards' => 'Custards & Puddings'
    ];
    
    // Prepare response
    $response = [
        'id' => (int)$recipe['recipe_id'],
        'title' => $recipe['title'],
        'description' => $recipe['description'],
        'category' => $categoryMap[$recipe['category']] ?? ucfirst($recipe['category']),
        'visibility' => $recipe['visibility'],
        'time' => (int)$recipe['cooking_time'],
        'servings' => (int)$recipe['servings'],
        'difficulty' => 'Medium',
        'image' => $recipe['thumbnail_url'],
        'videoUrl' => null,
        'creator' => [
            'name' => $recipe['display_name'] ?? $recipe['username'],
            'username' => '@' . $recipe['username'],
            'avatar' => $recipe['avatar_img'] ?? 'Asset/no-profile.jpg',
            'createdDate' => date('Y-m-d', strtotime($recipe['created_at']))
        ],
        'stats' => [
            'likes' => (int)$recipe['likes_count'],
            'saves' => (int)$recipe['saves_count'],
            'comments' => $comments_count
        ],
        'ingredients' => $ingredients,
        'instructions' => $instructions,
        'comments' => $comments,
        'isLiked' => (bool)$recipe['user_liked'],
        'isSaved' => (bool)$recipe['user_saved']
    ];
    
    // Handle video URL
    if ($recipe['video_type'] === 'youtube' && !empty($recipe['video_url'])) {
        $video_url = $recipe['video_url'];
        
        // Convert to embed format
        if (strpos($video_url, 'youtube.com/watch?v=') !== false) {
            preg_match('/[?&]v=([^&]+)/', $video_url, $matches);
            if (isset($matches[1])) {
                $response['videoUrl'] = 'https://www.youtube.com/embed/' . $matches[1];
            }
        } elseif (strpos($video_url, 'youtu.be/') !== false) {
            $video_id = basename(parse_url($video_url, PHP_URL_PATH));
            $response['videoUrl'] = 'https://www.youtube.com/embed/' . $video_id;
        }
    } elseif ($recipe['video_type'] === 'upload' && !empty($recipe['video_url'])) {
        $response['videoUrl'] = $recipe['video_url'];
    }
    
    // Update view count
    $update_views = "UPDATE recipes SET views_count = views_count + 1 WHERE recipe_id = ?";
    $update_stmt = $conn->prepare($update_views);
    $update_stmt->bind_param("i", $recipe_id);
    $update_stmt->execute();
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>