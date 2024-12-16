<?php

require_once('../functions.php');
require_once('../db.php');

$car_id = intval($_POST['car_id'] ?? 0);
$model = $_POST['model'] ?? '';  
$daily_price = $_POST['daily_price'] ?? '';  


if ($car_id <= 0 || mb_strlen($model) == 0 || mb_strlen($daily_price) == 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Моля попълнете всички полета.';
    header('Location: ../index.php?page=edit_car&car_id=' . $car_id);
    exit;
} else {
    $img_upload = false;
    $img_name = '';

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $img_name = time() . "_" . $_FILES['image']['name'];
        $upload_dir = '../uploads/';

        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0775, true);
        }

       
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $img_name)) {
            $img_upload = true;
        } else {
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = 'Възникна грешка при качването на файла.';
            header('Location: ../index.php?page=edit_car&car_id=' . $car_id);
            exit;
        }
    }

  
    $query = '';
    if ($img_upload) {
        $query = "
            UPDATE cars
            SET title = :title, price_per_day = :price, image = :image
            WHERE id = :id
        ";
    } else {
        $query = "
            UPDATE cars
            SET title = :title, price_per_day = :price
            WHERE id = :id
        ";
    }

    $stmt = $pdo->prepare($query);
    $params = [
        ':title' => $model,
        ':price' => $daily_price,
        ':id' => $car_id
    ];

    if ($img_upload) {
        $params[':image'] = $img_name;
    }

    if ($stmt->execute($params)) {
        $_SESSION['flash']['message']['type'] = 'success';
        $_SESSION['flash']['message']['text'] = 'Автомобилът е редактиран успешно.';
    } else {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Възникна грешка при редактиране на автомобила.';
    }
    header('Location: ../index.php?page=cars');
    exit;
}
?>
