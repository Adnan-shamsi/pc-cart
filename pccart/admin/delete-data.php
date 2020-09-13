<?php
session_start();
#include connection.php
include_once('connection.php');

#################### login check
if (!isset($_SESSION['person_id']))
  header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');


if(!isset($_GET['pid']) && !isset($_GET['person']))
  die('ACCESS DENIED');

#to ensure that admin do not delete himself
if(isset($_GET['person']))
{
 if($_GET['person'] == $_SESSION['person_id'])
 header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/admin-table.php');
}

# for deleting product
if($_SESSION['role'] == 0 && isset($_GET['pid']))
{
  #unlinking product image file
  $get_image_pro = mysqli_query($conn,"SELECT * FROM product WHERE Product_id = {$_GET['pid']} ") or die("unsucessful");
  $r = mysqli_fetch_array($get_image_pro);
  unlink($prod_image_location . $r['first_image']);
  unlink($prod_image_location . $r['second_image']);

  #deleting product row
  $sql = "DELETE FROM product WHERE Product_id = {$_GET['pid']} AND dealer_id = {$_SESSION['person_id']} ";
  $result = mysqli_query($conn,$sql) or die("unsucessful");
  header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/product-table.php');
}

#for deleting category
else if($_SESSION['role'] == 1 && isset($_GET['pid']))
{
  #unlinking category image file
  $get_image_cat = mysqli_query($conn,"SELECT * FROM category WHERE cat_id = {$_GET['pid']} ") or die("unsucessful");

  $r = mysqli_fetch_array($get_image_cat);
  unlink($cat_image_location . $r['cat_img']);

  #deleting  category row
  $sql = "DELETE FROM category WHERE cat_id = {$_GET['pid']}";
  $result = mysqli_query($conn,$sql) or die("unsucessful");


  #deleting product that belong to that category
  $sql_inner = "SELECT * FROM product WHERE category_id = {$_GET['pid']}";
  $res = mysqli_query($conn,$sql_inner) or die("unsucessful");

  #unlinking images of that Product
  while($row = mysqli_fetch_array($res)) {
    unlink($prod_image_location .$row['first_image']);
    unlink($prod_image_location .$row['second_image']);
  }

  # then deleting those product that belong to that category
  mysqli_query($conn,"DELETE FROM product WHERE category_id ={$_GET['pid']} ") or die("unsucessful");

  header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/category.php');

}

#for deleting person
else if($_SESSION['role'] == 1 && isset($_GET['person']))
{
  $sql1 ="SELECT Role FROM person WHERE person_id ={$_GET['person']} ";
  $result = mysqli_query($conn,$sql1) or die("unsucessful");
  $row = mysqli_fetch_array($result);
  $sql2 = "DELETE FROM person WHERE person_id = {$_GET['person']} ";
  mysqli_query($conn,$sql2) or die("unsucessful");

  #### he is a dealer remove its product too;
  if($row["Role"] == 0)
  {
    $sql_inner = "SELECT * FROM product WHERE Dealer_id = {$_GET['person']}";
    $res = mysqli_query($conn,$sql_inner) or die("unsucessful");

    # unlinking product image of that deleted dealer
    while($row = mysqli_fetch_array($res)) {
      unlink($prod_image_location .$row['first_image']);
      unlink($prod_image_location .$row['second_image']);
    }

    # then deleting those product that belong to that respective deleted dealer
    mysqli_query($conn,"DELETE FROM product WHERE Dealer_id ={$_GET['person']} ") or die("unsucessful");
  }

  #moving person to their respective table page
  $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/'
    . ($row['Role'] == 1 ? 'admin-table.php' : 'dealer-table.php');

  header("Location:" . $url);
}

mysqli_close($conn);

?>
