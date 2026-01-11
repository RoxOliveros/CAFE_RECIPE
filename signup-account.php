<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable errors for debugging

session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {

        $conn->begin_transaction();

        // Get input
        $display_name = trim($_POST['display_name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $conf_password = trim($_POST['confirm_password']);
        $avatar = $_POST['avatar_img'] ?? "Asset/no-profile.jpg";

        $hashed_pass = null;
        if ($password !== $conf_password) {
            throw new Exception("Passwords does not match");
        } else {
            $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
        }

        // For signing up
        $sql = "INSERT INTO users (username, email, password_hash, display_name, avatar_img) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssss", $username, $email, $hashed_pass, $display_name, $avatar);
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        // For logging in after sign up
        $login_sql = "SELECT user_id, username, password_hash, display_name, avatar_img FROM users WHERE username = ?";

        $login_stmt = $conn->prepare($login_sql);
        if (!$login_stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $login_stmt->bind_param("s", $username);
        
        if (!$login_stmt->execute()) {
            throw new Exception("Execute failed: " . $login_stmt->error);
        }

        $result = $login_stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // 2. Verify password using PHP function
            if (password_verify($password, $user['password_hash'])) {
                
                // 3. Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['display_name'] = $user['display_name'];
                $_SESSION['avatar_img'] = $user['avatar_img'];
                
                $conn->commit();

                echo json_encode([
                    'success' => true,
                    'message' => 'Logged in successfully!'
                ]);
            } else {
                throw new Exception("Invalid username or password");
            }
        } else {
            throw new Exception("Invalid username or password");
        }
        
        $login_stmt->close();

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
