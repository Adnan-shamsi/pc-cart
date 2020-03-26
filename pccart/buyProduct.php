<?php
####### getting each product one by one by ajax from cart ################
//starting session
session_start();
##### including connection.php which is in admin folder
include_once('admin/connection.php');

//checking if customer is login or not
if (isset($_SESSION['customer_id'])) {
//checking if all the arguments are provided or not
//product id ,quantity,address, product name ,price
  if (isset($_POST['product_id'],$_POST['quantity'],$_POST['product_name'],$_POST['address'],$_POST['price'])) {

//removing that product from cart session
 array_splice($_SESSION['cart'],array_search($_POST['product_id'],$_SESSION['cart']),1);

    $query = "SELECT * FROM product
              WHERE product_id = {$_POST['product_id']}
              AND quantity >=  {$_POST['quantity']}";

    $result = mysqli_query($conn, $query) or die('Unsuccessfull');
//checking if we have suffcient orders or not
    if (mysqli_num_rows($result) == 1) {
      $address = mysqli_real_escape_string($conn, trim($_POST['address']));
      $quantity = $_POST['quantity'];
      $product_name = $_POST['product_name'];
      $price = $_POST['price'];
//inserting order data
      $query = "INSERT INTO `orders` ( `Product_id`, `Customer_id`, `Address`, `status`, `Quantity`, `price`)
                 VALUES
                 ({$_POST['product_id']},{$_SESSION['customer_id']},'{$address}',1,{$quantity},{$price})";

      $result = mysqli_query($conn, $query) or die('Unsuccessfull');

//updating product quantity
      $query = "UPDATE product
                SET quantity = quantity - {$quantity}
                WHERE product_id = {$_POST['product_id']}";

      mysqli_query($conn, $query) or die('Unsuccessfull');
      echo "success";
    }
  }
}
