<?php
require_once('../functions.php');
require_once('../db.php');

$error = '';
foreach ($_POST as $key => $value) {
    if (mb_strlen($value) == 0) {
        $error = 'Всички полета са задължителни!';
    }
}

if (mb_strlen($error) > 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = $error;
    $_SESSION['flash']['data'] = $_POST;
    header('Location: ../index.php?page=register');
    exit;
} else if ($_POST['password'] != $_POST['repeat_password']) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Паролите не съвпадат!';
    $_SESSION['flash']['data'] = $_POST;
    header('Location: ../index.php?page=register');
    exit;
} else {
    $names = htmlspecialchars($_POST['names']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    
    $query = "SELECT id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Грешка при регистрация!';
        $_SESSION['flash']['data'] = $_POST;
        header('Location: ../index.php?page=register');
        exit;
    }

    $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

    $query = "INSERT INTO users (names, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $params = [$names, $email, $password];
    if ($stmt->execute($params)) {
        $_SESSION['flash']['message']['type'] = 'success';
        $_SESSION['flash']['message']['text'] = 'Успешна регистрация!';
        header('Location: ../index.php?page=login');
        exit;
    } else {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = 'Възникна грешка, моля опитайте по-късно!';
        $_SESSION['flash']['data'] = $_POST;
        header('Location: ../index.php?page=register');
        exit;
    }
}
?>
