<?php
header('Content-Type: application/json');
include 'db_connection.php'; // Your database connection file

// Get the category from the query string
$category = isset($_GET['category']) ? $_GET['category'] : null;

if (!$category) {
    echo json_encode([]);
    exit;
}

// Fetch recipes by category
$sql = "SELECT recipe_id AS id, title, thumbnail_url AS image 
        FROM recipes 
        WHERE visibility='public' AND category = ? 
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}

echo json_encode($recipes);
?>
