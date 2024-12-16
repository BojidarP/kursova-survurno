
<?php

session_start();
require_once('./db.php');


if (!isset($_SESSION['user_id']) && !isset($_COOKIE['temp_user_token'])) {
    $temp_user_token = bin2hex(random_bytes(16));
    setcookie('temp_user_token', $temp_user_token, time() + (86400 * 30), "/"); // 30 days
} else {
    $temp_user_token = $_COOKIE['temp_user_token'] ?? null;
}
?>
