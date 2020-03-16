<?php
session_start();
if (isset($_SESSION['person_id']) && isset($_SESSION['role']) && isset($_SESSION['username'])) {
    $_SESSION = array();
    session_destroy();
}
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/category.html';
echo $home_url;
header('Location:' . $home_url);
?>
