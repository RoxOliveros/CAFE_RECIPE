<?php
/**
 * Top Contributors Data Fetcher
 */

require_once 'config/database.php';

$topContributors = [];
$maxCount = 1;
$contributorCount = 0;

try {
    $query = "
        SELECT 
            u.user_id,
            u.username,
            u.display_name,
            u.avatar_img,
            COUNT(r.recipe_id) AS recipe_count
        FROM users u
        LEFT JOIN recipes r 
            ON u.user_id = r.user_id 
            AND r.visibility = 'public'
        GROUP BY 
            u.user_id, 
            u.username, 
            u.display_name, 
            u.avatar_img
        HAVING recipe_count > 0
        ORDER BY recipe_count DESC, u.user_id ASC
        LIMIT 3
    ";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $topContributors[] = $row;
        }

        if (!empty($topContributors)) {
            $maxCount = (int)$topContributors[0]['recipe_count'];
        }

        $contributorCount = count($topContributors);
    }

} catch (Exception $e) {
    error_log("Top Contributors Error: " . $e->getMessage());
}
?>
