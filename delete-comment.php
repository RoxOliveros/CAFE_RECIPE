<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable errors for debugging

session_start();
require_once 'config/database.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $comment_id = $data['comment_id'];

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

        $conn->query("ALTER TABLE comments AUTO_INCREMENT = 1");

        echo json_encode([
            'success' => true,
            'message' => 'Comment deleted successfully! 🎉'
        ]);

    } catch (Exception $e) {
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