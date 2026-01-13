<?php
header('Content-Type: application/json');
session_start();
require_once 'config/database.php';

// Changed to user currently logged in
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $recipe_id = intval($input['id']);
    
    try {
        // Verify user owns this recipe
        $check_sql = "SELECT user_id FROM recipes WHERE recipe_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $recipe_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Recipe not found']);
            exit;
        }
        
        $recipe = $result->fetch_assoc();
        if ($recipe['user_id'] != $user_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        // Delete recipe (CASCADE will delete ingredients, instructions, comments)
        $delete_sql = "DELETE FROM recipes WHERE recipe_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $recipe_id);
        
        if ($delete_stmt->execute()) {
            echo json_encode(['success' => true]);
            
            // Reset AUTO_INCREMENT in recipes, instructions, and ingredients
            $conn->query("ALTER TABLE recipes AUTO_INCREMENT = 1");
            $conn->query("ALTER TABLE instructions AUTO_INCREMENT = 1");
            $conn->query("ALTER TABLE ingredients AUTO_INCREMENT = 1");
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete recipe']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

$conn->close();
?>