<?php
session_start();
unset($_SESSION['person_id']);
unset($_SESSION['username']);
unset($_SESSION['role']);
session_destroy();


$home_url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php';
header('Location:' . $home_url);
?>
