<?php
session_start();

include("admin/connection.php");

# checking login
if (!isset($_SESSION['customer_id']))
  header('Location:https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php');

$id = $_GET['oid'];
$result = mysqli_query($conn,"SELECT * FROM orders WHERE Order_id = {$id}") or die("unsucssfull");
$row = mysqli_fetch_array($result);

if($row['status'] == 1 || $row['status'] == 2){
    $res = mysqli_query($conn,"UPDATE orders SET status = 4 WHERE Order_id = {$id}") or die("unsucssfull");
    $res2 = mysqli_query($conn,"UPDATE product SET Quantity = Quantity + {$row['Quantity']}  WHERE Product_id = {$row['Product_id']}") or die("unsucssfull");
}

header('Location:https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/orderhistory.php' );

?>