<?php
$path = dirname(__DIR__,2) .  "/vendor/autoload.php";
require($path);
$dotenv =  Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();
date_default_timezone_set("Asia/Kolkata");
$cat_image_location = 'upload/category-image/';
$prod_image_location = 'upload/product-image/';
$conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']) or die('Unable to connect with database');
