<?php
##### starting session#######;
session_start();

  if(isset($_POST['product_id']))
  {
      //if cart already exist
      if(isset($_SESSION['cart']))
      { //if the item is in the cart
        if(in_array($_POST['product_id'],$_SESSION['cart']))
          echo "<script>alert('This item is already in the cart');</script>";
        else
           $_SESSION['cart'][] = $_POST['product_id'];
      }
      //if cart do not exist
      else
      {
        //making cart as array
        $_SESSION['cart'] = array();
        //inserting the first product
        $_SESSION['cart'][] = $_POST['product_id'];
      }

  }

 ?>
