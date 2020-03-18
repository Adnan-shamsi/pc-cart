<?php
session_start();
# checking login
if (!isset($_SESSION['person_id']))
  header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');
#redirecting dealer to admin to home page
else if ($_SESSION['role'] == 1)
     header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/admin-panel.php');
#additional check
else if($_SESSION['role'] != 0)
     die('404 Page not Found');

#included connection file
include_once ('connection.php');

# to check if product exist or not for that dealer
if($_SESSION['role'] == 0)
   $result = mysqli_query($conn,"SELECT * FROM product WHERE product_id = $id  AND dealer_id = {$_SESSION['person_id']}") or die("Unsuccessfull");

#checking if there is any result
if(mysqli_num_rows($result) == 0)
  die('Unsuccessfully');

?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/style.css">
    <title></title>
  </head>
<body>

  <?php
  ################## included navbar file ################################################
  include_once ('navbar.php');
  ?>


    <table>
    <tr>
        <th>ProductID</th>
        <th>Product Name</th>
        <th>image1</th>
        <th>image2</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <tr>
        <td>P436</td>
        <td>Ryzen 5 3400G</td>
        <td><img src="upload/product-image/Ryzen 5 3400G.jpg" alt="" border="3" height="150" width="150"></img></td>
        <td><img src="upload/category-image/cpu.jpg" alt="" border="3" height="150" width="150"></img></td>
        <td>CPU</td>
        <td>AMD</td>
        <td><i class="fa fa-inr" aria-hidden="true"></i> 10000</td>
        <td>2</td>
        <td><a href="#"><i class="fa fa-pencil-square-o" style="font-size:30px;color:black" aria-hidden="true"></i></a></td>
        <td><a href='#' ><i class="fa fa-trash" style="font-size:30px;color:orangered" aria-hidden="true"></i></a></td>
    </tr>
    </table>

</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
