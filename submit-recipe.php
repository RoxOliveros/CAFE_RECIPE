<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in production

session_start();
require_once 'config/database.php';

// Changed to user currently logged in
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $conn->begin_transaction();
    
    try {
        // Validate required fields
        if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['description'])) {
            throw new Exception("Please fill in all required fields");
        }
        
        // Get form data
        $title = $conn->real_escape_string(preg_replace('/\s+/', ' ', trim(ucwords(strtolower($_POST['title'])))));
        $category = $conn->real_escape_string(trim($_POST['category']));
        $description = $conn->real_escape_string(preg_replace('/\s+/', ' ', trim(ucfirst($_POST['description']))));
        $cooking_time = $conn->real_escape_string(trim($_POST['time'])) . ' mins';
        $servings = intval($_POST['servings']);
        $visibility = $conn->real_escape_string(trim($_POST['visibility']));
        
        // Handle thumbnail upload
        $thumbnail_url = null;
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/thumbnails/';
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    throw new Exception("Failed to create upload directory");
                }
            }
            
            $file_extension = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (!in_array($file_extension, $allowed_extensions)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and GIF allowed.");
            }
            
            // Check file size (5MB max)
            if ($_FILES['thumbnail']['size'] > 5 * 1024 * 1024) {
                throw new Exception("File too large. Maximum size is 5MB.");
            }
            
            $filename = time() . '_' . uniqid() . '.' . $file_extension;
            $thumbnail_path = $upload_dir . $filename;
            
            if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path)) {
                throw new Exception("Failed to upload thumbnail");
            }
            
            $thumbnail_url = $thumbnail_path;
        } else {
            $error_code = isset($_FILES['thumbnail']) ? $_FILES['thumbnail']['error'] : 'no file';
            throw new Exception("Thumbnail is required (Error: $error_code)");
        }
        
        // Handle video
        $video_type = 'none';
        $video_url = null;
        
        if (isset($_POST['video_option']) && $_POST['video_option'] !== 'none') {
            if ($_POST['video_option'] === 'youtube' && !empty($_POST['youtube_url'])) {
                $video_type = 'youtube';
                $video_url = $conn->real_escape_string(trim($_POST['youtube_url'])); 
            } elseif ($_POST['video_option'] === 'upload' && isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
                $video_type = 'upload';
                $video_upload_dir = 'uploads/videos/';
                
                if (!file_exists($video_upload_dir)) {
                    mkdir($video_upload_dir, 0777, true);
                }
                
                $video_filename = time() . '_' . basename($_FILES['video_file']['name']);
                $video_path = $video_upload_dir . $video_filename;
                
                if (move_uploaded_file($_FILES['video_file']['tmp_name'], $video_path)) {
                    $video_url = $video_path;
                }
            }
        }
        
        // Insert recipe
        $sql = "INSERT INTO recipes (user_id, title, description, category, thumbnail_url, cooking_time, servings, visibility, video_type, video_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("isssssssss", $user_id, $title, $description, $category, $thumbnail_url, $cooking_time, $servings, $visibility, $video_type, $video_url);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to insert recipe: " . $stmt->error);
        }
        
        $recipe_id = $conn->insert_id;
        
        // Insert ingredients
        if (isset($_POST['ingredients']) && is_array($_POST['ingredients'])) {
            $ingredient_sql = "INSERT INTO ingredients (recipe_id, ingredient_text, order_index) VALUES (?, ?, ?)";
            $ingredient_stmt = $conn->prepare($ingredient_sql);
            
            foreach ($_POST['ingredients'] as $index => $ingredient) {
                $ingredient = preg_replace('/\s+/', ' ', trim($ingredient));
                if (!empty($ingredient)) {
                    $ingredient_stmt->bind_param("isi", $recipe_id, $ingredient, $index);
                    $ingredient_stmt->execute();
                }
            }
            $ingredient_stmt->close();
        }
        
        // Insert instructions
        if (isset($_POST['instructions']) && is_array($_POST['instructions'])) {
            $instruction_sql = "INSERT INTO instructions (recipe_id, step_number, instruction_text) VALUES (?, ?, ?)";
            $instruction_stmt = $conn->prepare($instruction_sql);
            
            foreach ($_POST['instructions'] as $index => $instruction) {
                $instruction = preg_replace('/\s+/', ' ', trim($instruction));
                if (!empty($instruction)) {
                    $step_number = $index + 1;
                    $instruction_stmt->bind_param("iis", $recipe_id, $step_number, $instruction);
                    $instruction_stmt->execute();
                }
            }
            $instruction_stmt->close();
        }
        
        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Recipe created successfully!',
            'recipe_id' => $recipe_id
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