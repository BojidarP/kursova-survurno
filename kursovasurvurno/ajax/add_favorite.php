<?php
session_start();
require_once('../db.php'); 

if (isset($_SESSION['user_id']) && isset($_POST['car_id']) && is_numeric($_POST['car_id'])) {
    $carId = (int) $_POST['car_id'];
    $userId = $_SESSION['user_id']; 

    try {
        $stmt = $pdo->prepare("INSERT INTO favorite_cars_users (user_id, car_id) VALUES (?, ?)");
        if ($stmt->execute([$userId, $carId])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Unable to add to favorites']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Моля, влезте в системата, за да добавяте в любими']);
}
?>
