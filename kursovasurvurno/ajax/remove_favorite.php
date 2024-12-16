<?php
session_start();
require_once('../db.php'); 

if (isset($_POST['car_id']) && is_numeric($_POST['car_id'])) {
    $carId = (int) $_POST['car_id'];
    $userId = $_SESSION['user_id']; 

    
    $stmt = $pdo->prepare("DELETE FROM favorite_cars_users WHERE user_id = ? AND car_id = ?");
    if ($stmt->execute([$userId, $carId])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Unable to remove from favorites']);
    }
}
?>
