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

        $action = $data['action'];
        $recipe_id = $data['recipe_id'];

        if ($action === "add-save") {
            
            // For adding like in saves_count in recipe table
            $sql = "UPDATE recipes SET saves_count = saves_count + 1 WHERE recipe_id = ?";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $recipe_id);
            
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();

            // For adding recipe_saves
            $saves_sql = "INSERT INTO recipe_saves (recipe_id, user_id) VALUES (?, ?)";

            $saves_stmt = $conn->prepare($saves_sql);
            if (!$saves_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $saves_stmt->bind_param("ii", $recipe_id, $user_id);
            
            if (!$saves_stmt->execute()) {
                throw new Exception("Execute failed: " . $saves_stmt->error);
            }
            $saves_stmt->close();

        } else {
            
            // For subracting likes in saves_count in recipe table
            $minus_sql = "UPDATE recipes SET saves_count = saves_count - 1 WHERE recipe_id = ?";

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
            $unsaves_sql = "DELETE FROM recipe_saves WHERE recipe_id = ? AND user_id = ?";

            $unsaves_stmt = $conn->prepare($unsaves_sql);
            if (!$unsaves_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $unsaves_stmt->bind_param("ii", $recipe_id, $user_id);
            
            if (!$unsaves_stmt->execute()) {
                throw new Exception("Execute failed: " . $unsaves_stmt->error);
            }
            $unsaves_stmt->close();

            $conn->query("ALTER TABLE recipe_saves AUTO_INCREMENT = 1");
        }

        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Saved recipe successfully!'
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