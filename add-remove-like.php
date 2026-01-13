<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Please log in'
    ]);
    exit;
}

require_once 'config/database.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {

        $conn->begin_transaction();

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $action = $data['action'];
        $recipe_id = $data['recipe_id'];

        if ($action === "add-like") {
            
            // For adding like in likes_count in recipe table
            $sql = "UPDATE recipes SET likes_count = likes_count + 1 WHERE recipe_id = ?";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $recipe_id);
            
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();

            // For adding recipe_likes
            $likes_sql = "INSERT INTO recipe_likes (recipe_id, user_id) VALUES (?, ?)";

            $likes_stmt = $conn->prepare($likes_sql);
            if (!$likes_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $likes_stmt->bind_param("ii", $recipe_id, $user_id);
            
            if (!$likes_stmt->execute()) {
                throw new Exception("Execute failed: " . $likes_stmt->error);
            }
            $likes_stmt->close();

        } else {
            
            // For subracting likes in likes_count in recipe table
            $minus_sql = "UPDATE recipes SET likes_count = likes_count - 1 WHERE recipe_id = ?";

            $minus_stmt = $conn->prepare($minus_sql);
            if (!$minus_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $minus_stmt->bind_param("i", $recipe_id);
            
            if (!$minus_stmt->execute()) {
                throw new Exception("Execute failed: " . $minus_stmt->error);
            }
            $minus_stmt->close();

            // For adding recipe_likes
            $unlikes_sql = "DELETE FROM recipe_likes WHERE recipe_id = ? AND user_id = ?";

            $unlikes_stmt = $conn->prepare($unlikes_sql);
            if (!$unlikes_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $unlikes_stmt->bind_param("ii", $recipe_id, $user_id);
            
            if (!$unlikes_stmt->execute()) {
                throw new Exception("Execute failed: " . $unlikes_stmt->error);
            }
            $unlikes_stmt->close();

            $conn->query("ALTER TABLE recipe_likes AUTO_INCREMENT = 1");
        }

        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Liked recipe successfully!'
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
$conn->close();
?>