<?php

include_once('connection.php');
$pid = $_POST['person_id'];
$fname = $_POST['newName'];
$Email = $_POST['Email'];

$sql = "UPDATE person SET FirstName = '{$fname}' , Email ='{$Email}' WHERE person_id = {$pid}";
$result = mysqli_query($conn,$sql) or die("unsucessful");

header("Location: http://localhost/pc-cart/pccart/admin/admin-table.php");

mysqli_close($conn);

?>