<?php
//starting session
session_start();
##### including connection.php which is in admin folder
include_once('admin/connection.php')

if(isset($_SESSION['customer_id']))
{

  if(isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['product_name']) && isset($_POST['address']) && isset($_POST['price']))
  {
    $query = "SELECT * FROM product
              WHERE product_id = $_POST['product_id']
              AND quantity >= $_POST['quantity'] ";

    $result = mysqli_query($conn,$query) or die('Unsuccessfull');

    if(mysqli_num_rows($result) == 1)
    {
       $address = mysqli_real_escape_string($conn,trim($_POST['address']));
       $quantity = $_POST['quantity'];
       $product_name = $_POST['product_name'];
       $price = $_POST['price'];

       $query = "INSERT INTO `orders` ( `Product_id`, `Customer_id`, `Address`, `status`, `Quantity`, `price`)
                 VALUES ({$_POST['product_id']},{$_SESSION['customer_id']},'{$address}',1,{$quantity},{$price})";

       $result = mysqli_query($conn,$query) or die('Unsuccessfull');

       $query = "UPDATE product
                 SET quantity = quantity - {$quantity}
                 WHERE product_id = $_POST['product_id'] ";

       mysqli_query($conn,$query) or die('Unsuccessfull');
    }


  }
}

?>
