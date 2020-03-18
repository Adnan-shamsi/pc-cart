<?php
session_start();
#included connection.php
include_once ('connection.php');
if (!isset($_SESSION['person_id']))
  header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');

else if ($_SESSION['role'] == 1)
    header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/admin-panel.php');

else if($_SESSION['role'] != 0)
    die('404 Page not Found');

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/adminstyle.css">
    <title></title>
  </head>

<body>
<?php
################################# add product ###########################################
    if(isset($_POST['add_product']))
    {

        # validate image
        if(isset($_FILES['photo1']) && isset($_FILES['photo2']) )
        {
           $errors = array();

           #taking post input
          $product_name  = strtoupper(mysqli_real_escape_string($conn,trim($_POST['pro_name'])));
          $category_id   = mysqli_real_escape_string($conn,trim($_POST['cat_id']));
          $brand = strtoupper(mysqli_real_escape_string($conn,trim($_POST['brand'])));
          $description = mysqli_real_escape_string($conn,trim($_POST['desc']));
          $price = mysqli_real_escape_string($conn,$_POST['price']);
          $quantity = mysqli_real_escape_string($conn,$_POST['qty']);


           #taking parmeters of first image
           $file_name1 = $_FILES['photo1']['name'];
           $file_size1 = $_FILES['photo1']['size'];
           $file_tmp1 = $_FILES['photo1']['tmp_name'];
           $temp1 = explode('.',$file_name1);
           $file_ext1 = strtolower(end($temp1));

           #taking parmeters of second image
           $file_name2 = $_FILES['photo2']['name'];
           $file_size2 = $_FILES['photo2']['size'];
           $file_tmp2 = $_FILES['photo2']['tmp_name'];
           $temp2 = explode('.',$file_name2);
           $file_ext2 = strtolower(end($temp2));

           $extensions = array('jpeg','jpg','png');

           if($product_name == '' || $brand =='' || $description =='')
             $errors[] = "Feild Empty!!";

           #checking file extension
           if(in_array($file_ext1,$extensions) == false || in_array($file_ext2,$extensions) == false)
             $errors[] = "Extension not allowed, Please choose a jpeg or png";

           #checking size of file
           if($file_size1 > 2097152  || $file_size2 > 2097152)
             $errors[] = 'File must be 2MB or lower';

           if($file_name1 == $file_name2 && $file_size1 == $file_size2)
             $errors[] = 'Same image file';

           #reducing name conflict by adding date to name and extension to the end
           $file_name1 = date("dmyhis") . (substr($temp1[0],0,30)) . '.' . $file_ext1 ;
           $file_name2 = date("dmyhis") . (substr($temp2[0],0,30)) . '.' . $file_ext2 ;

           if(empty($errors)  == true)
           {
             #insert category into the table

            $insert_product_sql = "INSERT INTO `product`(`Name`, `category_id`, `Brand`, `Desc`, `Price`, `Quantity`, `first_image`, `second_image`, `Dealer_id`)
                                   VALUES
                                   ('{$product_name}',{$category_id} ,'{$brand}','{$description}',{$price},{$quantity},'{$file_name1}','{$file_name2}',{$_SESSION['person_id']})";

             mysqli_query($conn,$insert_product_sql) or die('Query failed');
             move_uploaded_file($file_tmp1,$prod_image_location . $file_name1);
             move_uploaded_file($file_tmp2,$prod_image_location . $file_name2);

             echo "<h4 style='color:slateblue;text-align:center;margin-top:10px;'>Product added SuccessFully!!</h4>";

           }
           else
           {
             foreach($errors as $value)
               echo "<h2 style='color:red;text-align:center;margin-top:10px;'>{$value}</h2>";
           }

        }
    }


 ?>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="passwordchange.php?pid=<?php echo $_SESSION['person_id'] ?>">Change Password</a>
        <a href="account-update.php?pid=<?php echo $_SESSION['person_id'] ?>">Change account info</a>
        <a href="#">Contact</a>
        <a href="logout.php">Logout</a>
      </div>

      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span><br>

        <button class='buttonClass' onclick="window.location.href='product-table.php';" style='width:80%;' >Product table</button>
        <button class='buttonClass' onclick="window.location.href='order.php';" style='width:80%;'>Orders</button>

<button class='buttonClass' onclick="document.getElementById('id01').style.display='block'" type="button" style="width:80%;">Add Product</button>


<!-- add product form ------------------------------------------------------------------------------------------->
<div id="id01" class="modal">

  <form class="modal-content animate" action='<?php $_SERVER["PHP_SELF"] ;?>' method="post" enctype="multipart/form-data">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

    </div>

    <div class="container">

      <label for="pro_name"><b>Product Name</b></label>
      <input type="text" placeholder="Enter Product Name" name="pro_name" required>

      <label for="cat_id"><b>Type</b></label>
      <select  class="form-control" name="cat_id" required>
         <option value ="" selected disabled>Select Type</option>


         <?php
################################## category option start ##########################################
            $get_category_sql = "SELECT * FROM category";
            $result = mysqli_query($conn,$get_category_sql) or die('Query failed');
            while($row = mysqli_fetch_assoc($result))
            {
         ?>
         <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['cat_name'] ?></option>

       <?php
         }
###############################category option close ##############################################
       ?>

      </select>

      <label for="brand"><b>Brand</b></label>
      <input type="text" placeholder="Enter Brand Name" name="brand" required>

      <label for="desc">Description:</label>
      <textarea class="form-control" rows="6" id="desc" name='desc' required></textarea>

      <label for="price"><b>Price</b></label>
      <input type="number" class="form-control" placeholder="Enter price" name="price" min='100' max='100000' required>

      <label for="qty"><b>Quantity</b></label>
      <input type="number" class="form-control" placeholder="Enter Quantity" name="qty" min='1' max='100000' required>


        <label for="photo1" class = "labelimg my-3">.Select 1st Image:</label>
        <input type="file" id="photo1" name="photo1" class = "labelimg" required><br>

        <label for="photo2" class = "labelimg">Select 2nd Image:</label>
        <input type="file" id="photo2" name="photo2" class = "labelimg" required>

        <input type="submit" class='btn btn-success' style='width:100%' name='add_product' >Submit

    </div>

  </form>
</div>
<!--add product form close--------------------------------------------------------------------------------->


      <script>
      function openNav() {
      document.getElementById("mySidenav").style.width = "300px";
              }

      function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
              }
      </script>

</body>

</html>
