<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle GET request - fetch user data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT user_id, username, display_name, bio, avatar_img FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    echo json_encode(['success' => true, 'user' => $user]);
    exit;
}

// Handle POST request - update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $display_name = trim($_POST['display_name'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    
    // Validate display name
    if (empty($display_name)) {
        echo json_encode(['success' => false, 'message' => 'Display name is required']);
        exit;
    }
    
    // Check if avatar is being uploaded
    $hasNewAvatar = isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK;
    $avatar_img = null;
    
    if ($hasNewAvatar) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        $file_type = $_FILES['avatar']['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF allowed.']);
            exit;
        }
        
        // Check file size (max 5MB)
        if ($_FILES['avatar']['size'] > 5 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 5MB.']);
            exit;
        }
        
        // Create upload directory if it doesn't exist
        $upload_dir = 'uploads/avatars/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $user_id . '_' . time() . '.' . $extension;
        $upload_path = $upload_dir . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_path)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload avatar']);
            exit;
        }
        
        $avatar_img = $upload_path;
    }
    
    // Build and execute update query
    if ($avatar_img) {
        // Get old avatar before update
        $stmt = $conn->prepare("SELECT avatar_img FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $old_avatar = $stmt->get_result()->fetch_assoc()['avatar_img'] ?? null;
        $stmt->close();
        
        // Update with new avatar
        $stmt = $conn->prepare("UPDATE users SET display_name = ?, bio = ?, avatar_img = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $display_name, $bio, $avatar_img, $user_id);
    } else {
        // Update without avatar - keep existing avatar
        $stmt = $conn->prepare("UPDATE users SET display_name = ?, bio = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $display_name, $bio, $user_id);
    }
    
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        $stmt->close();
        exit;
    }
    
    $stmt->close();
    
    // Delete old avatar if new one was uploaded
    if ($avatar_img && isset($old_avatar) && $old_avatar && file_exists($old_avatar) && 
        strpos($old_avatar, 'Asset/') === false && strpos($old_avatar, 'https://') === false) {
        @unlink($old_avatar);
    }
    
    // Get current avatar if none was uploaded
    if (!$avatar_img) {
        $stmt = $conn->prepare("SELECT avatar_img FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $avatar_img = $stmt->get_result()->fetch_assoc()['avatar_img'] ?? 'Asset/no-profile.jpg';
        $stmt->close();
    }
    
    // Return updated user data
    echo json_encode([
        'success' => true,
        'message' => 'Profile updated successfully',
        'user' => [
            'user_id' => $user_id,
            'display_name' => $display_name,
            'bio' => $bio,
            'avatar_img' => $avatar_img
        ]
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method']);
?>