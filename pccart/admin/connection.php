<?php
include_once('dbvars.php');

 date_default_timezone_set("Asia/Kolkata");
 $cat_image_location = 'upload/category-image/';
 $prod_image_location = 'upload/product-image/';
 $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME) or die('Unable to connect with database');
?>
