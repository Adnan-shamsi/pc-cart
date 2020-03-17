<?php
#constant
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'pckart');


 date_default_timezone_set("Asia/Kolkata");
 $cat_image_location = 'upload/category-image/';
 $prod_image_location = 'upload/product-image/';
 $conn = mysqli_connect('localhost','root','','pckart') or die('Unable to connect with database');
?>
