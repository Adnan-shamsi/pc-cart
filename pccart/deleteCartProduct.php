<?php
  ############# session start ####
  session_start();
  if(isset($_POST['product_id']))
  {  //deleting removed product from session cart
     array_splice($_SESSION['cart'],array_search($_POST['product_id'],$_SESSION['cart']),1);
  }





 ?>
