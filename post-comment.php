<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please login to comment'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        
        $conn->begin_transaction();

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $comment = $data['comment'];
        $recipe_id = $data['recipe_id'];

        // For posting a comment 
        $sql = "INSERT INTO comments (recipe_id, user_id, comment_text) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iis", $recipe_id, $user_id, $comment);
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
        
        // For updating comments_count in recipe table
        $update_sql = "UPDATE recipes SET comments_count = comments_count + 1 WHERE recipe_id = ?";

        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $update_stmt->bind_param("i", $recipe_id);

        if (!$update_stmt->execute()) {
            throw new Exception("Execute failed: " . $update_stmt->error);
        }
        $update_stmt->close();

        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Comment posted successfully! 🎉'
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