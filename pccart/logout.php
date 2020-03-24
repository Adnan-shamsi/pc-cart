<?php
session_start();
unset($_SESSION['customer_id']);
unset($_SESSION['username']);
session_destroy();


$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/home-page.php';
header('Location:' . $home_url);
?>
