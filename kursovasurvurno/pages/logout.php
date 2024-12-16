<?php

session_start();
session_destroy();


setcookie('user_email', '', time() - 3600, '/', 'localhost', false, false);


header('Location: index.php');
exit;
?>
