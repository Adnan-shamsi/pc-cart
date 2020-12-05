<?php
session_start();
unset($_SESSION['customer_id']);
unset($_SESSION['username']);
unset($_SESSION['cart']);
session_destroy();


$home_url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/home-page.php';
header('Location:' . $home_url);
?>
