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
   $result = mysqli_query($conn,"SELECT * FROM product WHERE dealer_id = {$_SESSION['person_id']}") or die("Unsuccessfull");

#checking if there is any result

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
################ included navbar file ################################################
  include_once ('navbar.php');

if (mysqli_num_rows($result) > 0) {
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

    <?php
        ###### php code
      while($row = mysqli_fetch_array($result)) {
        $cat_name= mysqli_query($conn,"SELECT cat_name FROM category WHERE cat_id = {$row['category_id']}") or die("Unsuccessfull");
       $row2 = mysqli_fetch_array($cat_name);

    ?>

    <tr>
        <td><?php echo $row["Product_id"]; ?></td>
        <td><?php echo $row["Name"]; ?></td>
        <td ><img src="<?php echo $prod_image_location . $row['first_image']; ?>" alt="" border="3" height="150" width="250;"></img></td>
        <td ><img src="<?php echo $prod_image_location . $row['second_image']; ?>" alt="" border="3" height="150" width="250;"></img></td>
        <td><?php echo $row2['cat_name']; ?></td>
        <td><?php echo  $row['Brand']; ?></td>
        <td><i class="fa fa-inr" aria-hidden="true"></i><?php echo  $row['Price']; ?></td>
        <td><?php echo  $row['Quantity']; ?></td>
        <td><a href='update-data.php?id=<?php echo $row["Product_id"]; ?>'><i class="fa fa-pencil-square-o" style="font-size:30px;color:black" aria-hidden="true"></i></a></td>
    <td><button class="fa fa-trash" style="font-size:30px;color:orangered" aria-hidden="true" onClick="delete_me(<?php echo $row['Product_id']; ?>)" name="delete_btn" ></button></td>
    </tr>
    <!-- JS for popup on deleting item-->
    <script type="text/javascript">
      function delete_me(del_id)
      {
        if(confirm("Do you want to delete product " +del_id+'')){
           window.location.href = 'delete-data.php?pid='+del_id +'';
           return true;
         }
      }
    </script>



    <?php
    ############### php code
    }
    ?>
    </table>
<?php
############### php code
}
else
echo "<h1  style='color:red;margin:100px;text-align:center'>No Result Found<h1>";
?>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
