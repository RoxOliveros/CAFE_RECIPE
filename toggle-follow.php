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

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $action = $data['action'];
        $following = $data['other_user_id'];

        if ($action === "follow") {

            $sql = "INSERT INTO followers (follower_id, following_id) VALUES (?, ?)";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ii", $user_id, $following);
            
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();

        } else {

            $unfollow_sql = "DELETE FROM followers WHERE follower_id = ? AND following_id = ?";

            $unfollow_stmt = $conn->prepare($unfollow_sql);
            if (!$unfollow_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $unfollow_stmt->bind_param("ii", $user_id, $following);
            
            if (!$unfollow_stmt->execute()) {
                throw new Exception("Execute failed: " . $unfollow_stmt->error);
            }
            $unfollow_stmt->close();

            $conn->query("ALTER TABLE followers AUTO_INCREMENT = 1");
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Followed user successfully!'
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