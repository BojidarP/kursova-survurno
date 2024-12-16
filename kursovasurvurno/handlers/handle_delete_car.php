<?php

require_once('../functions.php');
require_once('../db.php');
session_start(); 


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not authorized']);
    exit;
}

if (isset($_POST['car_id']) && !empty($_POST['car_id'])) {
    $car_id = $_POST['car_id']; 

    try {
        
        $sql = "DELETE FROM cars WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $car_id, PDO::PARAM_INT); 
        $stmt->execute();

        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Car not found or already deleted']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid car ID']);
}

?>
