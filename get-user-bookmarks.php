<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

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
                s.save_id
            FROM recipes r
            JOIN recipe_saves s ON r.recipe_id = s.recipe_id
            WHERE s.user_id = ? AND visibility = 'public'
            ORDER BY r.created_at DESC";

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
    
    $bookmarks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookmarks[] = [
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
                'isSaved' => (bool)$row['save_id']
            ];
        }
    }
    
    // Calculate total stats
    $totalLikes = array_sum(array_column($bookmarks, 'likes'));
    $totalComments = array_sum(array_column($bookmarks, 'comments'));
    $totalRecipes = count($bookmarks);
    $totalSaves = count($bookmarks);
    
    $response = [
        'bookmarks' => $bookmarks,
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