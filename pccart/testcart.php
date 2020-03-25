<?php
##### starting session#######;
session_start();

if(isset($_SESSION['cart']))
  print_r($_SESSION['cart']);
die('stop');

 ?>
