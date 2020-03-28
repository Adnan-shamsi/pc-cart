<?php
session_start();

include("admin/connection.php");

# checking login
if (!isset($_SESSION['customer_id']))
  header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php');

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/table.css">
    <link rel="stylesheet" href="css/style.css">

    <title></title>
  </head>
<body>

<?php

#fetching result
$result = mysqli_query($conn,"SELECT * FROM orders WHERE Customer_id = {$_SESSION['customer_id']} ORDER BY price DESC") or die("unsucssfull");


################ included navbar file ################################################
  include_once ('navbar.php');

  if (mysqli_num_rows($result) > 0) {
?>

    <table>
    <tr>        
        <th>Product Name</th>
        <th>EmailID</th>
        <th>Status</th>
        <th>Cancel Order</th>
    </tr>
<?php

while($row = mysqli_fetch_array($result)) {
$result2 = mysqli_query($conn,"SELECT * FROM product WHERE Product_id = {$row['Product_id']}") or die("unsucssfull");
    $row2 = mysqli_fetch_array($result2);
?>
    <tr>
        <td><?php echo $row2["Name"]; ?></td>
        <td><?php echo $row2["Price"]; ?></td>
        <td><?php
        if($row["status"] == 1) {
            echo "pending";
        }
        else if($row["status"] == 2) {
            echo "shipped";
        }
        else if($row["status"] == 3) {
            echo "delivered";
        }
        else if($row["status"] == 4) {
            echo "cancelled";
        }
        ?></td>
        
        <td><a href='delete.php?oid=<?php echo $row["Order_id"]; ?>'><i class="fa fa-trash" style="font-size:30px;color:orangered" aria-hidden="true"></i></a></td>
    </tr>

    
<?php
}#closing of while loop
?>



</table>
 <?php
}#closing of if loop

#if no entry found
else
    echo "<h1  style='color:red;margin:100px;text-align:center'>No Result Found<h1>";

?>
    </table>

</body>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
