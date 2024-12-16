<?php

require_once('../functions.php');
require_once('../db.php');

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';

if (mb_strlen($title) == 0 || mb_strlen($price) == 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Моля попълнете всички полета.';
    header('Location: ../index.php?page=add_car');
    exit;
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $img_name = time() . "_" . basename($_FILES['image']['name']);
    $upload_dir = '../uploads/';

   
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0775, true)) {
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = 'Неуспешно създаване на директория за качване на файлове.';
            header('Location: ../index.php?page=add_car');
            exit;
        }
    }

    $target_path = $upload_dir . $img_name;

    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
        
        $query = "INSERT INTO cars (title, image, price_per_day) VALUES (:title, :image, :price_per_day)";
        $stmt = $pdo->prepare($query);
        $params = [
            ':title' => $title,
            ':image' => $img_name,
            ':price_per_day' => $price,
        ];

        if ($stmt->execute($params)) {
            $_SESSION['flash']['message']['type'] = 'success';
            $_SESSION['flash']['message']['text'] = 'Автомобилът е добавен успешно.';
            header('Location: ../index.php?page=cars');
            exit;
        } else {
           
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = 'Възникна грешка при добавяне на автомобила.';
        }
    } else {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Неуспешно качване на файла.';
    }
} else {
    $error_code = $_FILES['image']['error'] ?? 'UNKNOWN';
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля качете изображение. Код на грешка: $error_code.";
}


header('Location: ../index.php?page=add_car');
exit;

?>
