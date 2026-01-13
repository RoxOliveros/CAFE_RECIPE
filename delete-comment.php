<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable errors for debugging

session_start();
require_once 'config/database.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        $conn->begin_transaction();

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $comment_id = $data['comment_id'];
        $recipe_id = $data['recipe_id'];

        // For deleting a comment
        $sql = "DELETE FROM comments WHERE comment_id = ? AND user_id = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $comment_id, $user_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();

        // For subtracting comment count in recipes table
        $minus_sql = "UPDATE recipes SET comments_count = comments_count - 1 WHERE recipe_id = ?";

        $minus_stmt = $conn->prepare($minus_sql);
        if (!$minus_stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $minus_stmt->bind_param("i", $recipe_id);
        
        if (!$minus_stmt->execute()) {
            throw new Exception("Execute failed: " . $minus_stmt->error);
        }
        $minus_stmt->close();

        $conn->query("ALTER TABLE comments AUTO_INCREMENT = 1");

        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Comment deleted successfully! 🎉'
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