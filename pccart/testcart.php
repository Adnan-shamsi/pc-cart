<?php
##### starting session#######;
session_start();

if(isset($_SESSION['cart']))
  print_r($_SESSION['cart']);
  echo  sizeof($_SESSION['cart']);
  if(sizeof($_SESSION['cart'])>3)
    echo "<script>alert('Only 20 products can be added to cart at once');</script>";


die('stop');

 ?>
