<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('../functions.php');
require_once('../db.php');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (mb_strlen($email) == 0 || mb_strlen($password) == 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Грешни входни данни.';
    header('Location: ../index.php?page=login');
    exit;
} else {
    
    $query = "SELECT * FROM `users` WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    
    if (!$row) {
        
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Грешни входни данни.';
        header('Location: ../index.php?page=login');
        exit;
    } else {
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_name'] = $row['names'];
            $_SESSION['user_id'] = $row['id'];
            setcookie('user_email', $row['email'], time() + 3600, '/', 'localhost', false, false);

            $_SESSION['flash']['message']['type'] = 'success';
            $_SESSION['flash']['message']['text'] = 'Успешен вход.';
            header('Location: ../index.php?page=home');
            exit;
        } else {
            
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = 'Грешни входни данни.';
            header('Location: ../index.php?page=login');
            exit;
        }
    }
}
?>
