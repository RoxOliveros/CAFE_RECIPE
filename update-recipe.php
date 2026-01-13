<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide errors for security in production

session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();
    
    try {

        $recipe_id = intval($_POST['recipe_id']); // Ensure this is sent from the frontend
        
        // Verify Ownership: Ensure this user owns the recipe they are trying to edit
        $owner_check = "SELECT recipe_id, user_id, thumbnail_url, video_url FROM recipes WHERE recipe_id = ?";
        $owner_stmt = $conn->prepare($owner_check);
        $owner_stmt->bind_param("i", $recipe_id);
        $owner_stmt->execute();
        $owner_result = $owner_stmt->get_result();
        $existing_recipe = $owner_result->fetch_assoc();

        if ($existing_recipe['user_id'] !== $user_id) {
            throw new Exception("Unauthorized: You do not have permission to edit this recipe.");
        }

        // Collect and Validate form data
        $title = $conn->real_escape_string(preg_replace('/\s+/', ' ', trim(ucwords(strtolower($_POST['title'])))));
        $category = $conn->real_escape_string(trim($_POST['category']));
        $description = $conn->real_escape_string(preg_replace('/\s+/', ' ', trim(ucfirst($_POST['description']))));
        $cooking_time = $conn->real_escape_string(trim($_POST['time'])) . ' mins';
        $servings = intval($_POST['servings']);
        $visibility = $conn->real_escape_string(trim($_POST['visibility']));
        
        // Handle Thumbnail Update (Keep existing if no new file is uploaded)
        $thumbnail_url = $existing_recipe['thumbnail_url'];
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/thumbnails/';
            $file_extension = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            $filename = time() . '_' . uniqid() . '.' . $file_extension;
            $thumbnail_path = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path)) {
                $thumbnail_url = $thumbnail_path;
            }
        }

        // Handle Video Logic
        $video_type = 'none';
        $video_url = $existing_recipe['video_url'];
        $video_option = $_POST['video_option'] ?? 'none';

        if ($video_option === 'youtube' && !empty($_POST['youtube_url'])) {
            $video_type = 'youtube';
            $video_url = $conn->real_escape_string(trim($_POST['youtube_url']));
        } elseif ($video_option === 'upload' && isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
            $video_type = 'upload';
            $video_upload_dir = 'uploads/videos/';
            $video_filename = time() . '_' . basename($_FILES['video_file']['name']);
            $video_path = $video_upload_dir . $video_filename;
            
            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $video_path)) {
                $video_url = $video_path;
            }
        } elseif ($video_option === 'none') {
            $video_type = 'none';
            $video_url = null;
        }

        // Update the Recipes Table
        $sql = "UPDATE recipes SET 
                    title = ?, description = ?, category = ?, thumbnail_url = ?, 
                    cooking_time = ?, servings = ?, visibility = ?, 
                    video_type = ?, video_url = ?
                WHERE recipe_id = ? AND user_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisssii", 
            $title, $description, $category, $thumbnail_url, 
            $cooking_time, $servings, $visibility, 
            $video_type, $video_url, $recipe_id, $user_id
        );
        $stmt->execute();

        // Update Ingredients (Delete old and Insert new)
        $conn->query("DELETE FROM ingredients WHERE recipe_id = $recipe_id");
        if (isset($_POST['ingredients']) && is_array($_POST['ingredients'])) {
            $ing_stmt = $conn->prepare("INSERT INTO ingredients (recipe_id, ingredient_text, order_index) VALUES (?, ?, ?)");
            foreach ($_POST['ingredients'] as $index => $ingredient) {
                $ingredient = preg_replace('/\s+/', ' ', trim($ingredient));
                if (!empty(trim($ingredient))) {
                    $ing_stmt->bind_param("isi", $recipe_id, $ingredient, $index);
                    $ing_stmt->execute();
                }
            }
        }
        $conn->query("ALTER TABLE ingredients AUTO_INCREMENT = 1");

        // Update Instructions (Delete old and Insert new)
        $conn->query("DELETE FROM instructions WHERE recipe_id = $recipe_id");
        if (isset($_POST['instructions']) && is_array($_POST['instructions'])) {
            $ins_stmt = $conn->prepare("INSERT INTO instructions (recipe_id, step_number, instruction_text) VALUES (?, ?, ?)");
            foreach ($_POST['instructions'] as $index => $instruction) {
                $instruction = preg_replace('/\s+/', ' ', trim($instruction));
                if (!empty(trim($instruction))) {
                    $step_num = $index + 1;
                    $ins_stmt->bind_param("iis", $recipe_id, $step_num, $instruction);
                    $ins_stmt->execute();
                }
            }
        }
        $conn->query("ALTER TABLE instructions AUTO_INCREMENT = 1");

        $conn->commit();
        echo json_encode([
            'success' => true,
            'message' => 'Recipe updated successfully!']);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'success' => false, 
            'message' => $e->getMessage()]);
    }
}
$conn->close();
?>