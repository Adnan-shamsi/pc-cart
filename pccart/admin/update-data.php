<?php
 ################################# login check #######################################
  session_start();
  #### included connection.php
  include_once ('connection.php');
  #checking for login
  if (!isset($_SESSION['person_id']))
     header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');

  #checking if pid and peson id is same or not
  if(!isset($_GET['id']))
     die("<h2 style='text-align:center;'>Access Denied !!</h2> ");

  # fetching id of category or product
  $id = $_GET['id'];

  # for category only for admin
  if ($_SESSION['role'] == 1)
     $result = mysqli_query($conn,"SELECT * FROM category WHERE cat_id = $id") or die("Unsuccessfull");

  #for product only for buyer
  else if($_SESSION['role'] == 0)
     $result = mysqli_query($conn,"SELECT * FROM product WHERE product_id = $id  AND dealer_id = {$_SESSION['person_id']}") or die("Unsuccessfull");

  #checking if there is any result
  if(mysqli_num_rows($result) == 0)
    die('Unsuccessfully');

    $row_upper = mysqli_fetch_array($result);
 ?>




 <?php
  ######################## php code for updating category ##########################################
  if(isset($_POST['update_category']))
  {
    echo "hi";
    $title = mysqli_real_escape_string($conn,trim($_POST['catname']));
    $title = strtoupper(trim($title));

    $errors = array();

    if($title == '')
      $errors[] = " Title is Empty !!";

    #checking if category name is unique or not
    $validate_category = "SELECT cat_id FROM category WHERE cat_name = '{$title}' AND NOT cat_id = $id ";
    $result2 = mysqli_query($conn,$validate_category) or die('Query failed');

    if(mysqli_num_rows($result2)> 0)
      echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Category already exist!!</h2>";
   else
   {
      # validate image if it is given
      if(isset($_FILES['filephoto']) && $_FILES['filephoto']['name']!='')
      {

         $file_name = $_FILES['filephoto']['name'];
         $file_size = $_FILES['filephoto']['size'];
         $file_tmp = $_FILES['filephoto']['tmp_name'];
         $file_type = $_FILES['filephoto']['type'];
         $temp = explode('.',$file_name);
         $file_ext = strtolower(end($temp));
         $extensions = array('jpeg','jpg','png');
         echo "File".$file_name;
         #checking file extension
         if(in_array($file_ext,$extensions) == false)
           $errors[] = "Extension not allowed, Please choose a jpeg or png";

         #checking size of file
         if($file_size > 2097152 )
           $errors[] = 'File must be 2MB or lower';

         #reducing name conflict by adding date to name and extension to the end
         $save_date = date("dmyhis");
         $file_name = $save_date . (substr($temp[0],0,30)) . '.' . $file_ext ;

         if(empty($errors)  == true)
         {

           #get old image name to unlink the file
           $get_img_name = "SELECT cat_img FROM category WHERE cat_id = $id ";
           $res = mysqli_query($conn,$get_img_name) or die('Unable to get image name');
           $row_inner = mysqli_fetch_array($res);
           unlink($cat_image_location .$row_inner['cat_img']);

           #insert category image into the table
           $insert_image ="UPDATE  category SET cat_img = '{$file_name}' WHERE cat_id = $id " ;
           mysqli_query($conn,$insert_image) or die('Unable to save category to Database');
           move_uploaded_file($file_tmp,$cat_image_location . $file_name);

          }

       }

       if(empty($errors)  == false)
       {
           foreach($errors as $value)
             echo "<h2 style='color:red;text-align:center;margin-top:10px;'>{$value}</h2>";
       }
       else
       {
           #insert category name into the table
           $insert_title = "UPDATE  category SET cat_name = '{$title}' WHERE cat_id = $id " ;
           mysqli_query($conn,$insert_title) or die('Unable to save title');

           #moving to home page after completion
           header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/admin-panel.php');
       }

   }
 }

 ?>


 <?php
 ################################# add product ###########################################
 if(isset($_POST['update_product']))
 {

     $errors = array();
     $extensions = array('jpeg','jpg','png');

     #taking post input
     $product_name  = strtoupper(mysqli_real_escape_string($conn,trim($_POST['pro_name'])));
     $category_id   = mysqli_real_escape_string($conn,trim($_POST['cat_id']));
     $brand = strtoupper(mysqli_real_escape_string($conn,trim($_POST['brand'])));
     $description = mysqli_real_escape_string($conn,trim($_POST['desc']));
     $price = mysqli_real_escape_string($conn,$_POST['price']);
     $quantity = mysqli_real_escape_string($conn,$_POST['qty']);

     if(isset($_FILES['photo1']) && $_FILES['photo1']['name']!='' )
     {
        #taking parmeters of first image
        $file_name1 = $_FILES['photo1']['name'];
        $file_size1 = $_FILES['photo1']['size'];
        $file_tmp1 = $_FILES['photo1']['tmp_name'];
        $temp1 = explode('.',$file_name1);
        $file_ext1 = strtolower(end($temp1));

        #checking file extension
        if(in_array($file_ext1,$extensions) == false )
          $errors[] = "For image1, Please choose a jpeg or png Extension ";

       #checking size of file
      if($file_size1 > 2097152)
          $errors[] = 'File must be 2MB or lower';

     }

     if(isset($_FILES['photo2']) && $_FILES['photo2']['name']!='')
     {
        #taking parmeters of second image
        $file_name2 = $_FILES['photo2']['name'];
        $file_size2 = $_FILES['photo2']['size'];
        $file_tmp2 = $_FILES['photo2']['tmp_name'];
        $temp2 = explode('.',$file_name2);
        $file_ext2 = strtolower(end($temp2));

        #checking file extension
        if(in_array($file_ext2,$extensions) == false)
          $errors[] = "For image2, Please choose a jpeg or png Extension";


        #checking size of file
        if($file_size2 > 2097152 && in_array('File must be 2MB or lower', $errors) == false)
          $errors[] = 'File must be 2MB or lower';

     }

     if($product_name == '' || $brand =='' || $description =='')
       $errors[] = "Feild Empty!!";

     #checking if both are same files or not
     if(isset($_FILES['photo1']) && $_FILES['photo1']['name']!='' && isset($_FILES['photo2']) && $_FILES['photo2']['name']!='')
       if($file_name1 == $file_name2 && $file_size1 == $file_size2)
         $errors[] = 'Same image file';

     #reducing name conflict by adding date to name and extension to the end
     $save_date = date("dmyhis");
     if(isset($_FILES['photo1']) && $_FILES['photo1']['name']!='')
       $file_name1 = $save_date . (substr($temp1[0],0,30)) . '.' . $file_ext1 ;

     if(isset($_FILES['photo2']) && $_FILES['photo2']['name']!='')
       $file_name2 = $save_date ."2". (substr($temp2[0],0,30)) . '.' . $file_ext2 ;

     if(empty($errors)  == true)
     {
        #insert category details into the table

       $insert_product_sql = "UPDATE `product`
                              SET
                              `Name`='{$product_name}' , `category_id` ={$category_id} ,
                              `Brand` = '{$brand}', `Description` ='{$description}',
                              `Price` = {$price}, `Quantity` = {$quantity} WHERE `Product_id` = $id ";

      mysqli_query($conn,$insert_product_sql) or die('Query failed');

      $get_old_images = mysqli_query($conn,"SELECT * FROM product WHERE `Product_id` =$id ");
      $row_temp = mysqli_fetch_array($get_old_images);

      #for first image
      if(isset($_FILES['photo1']) && $_FILES['photo1']['name']!='')
      {
        #unlinking old image then uploading new image
        unlink($prod_image_location . $row_temp['first_image']);
        $x = mysqli_query($conn,"UPDATE `product` SET `first_image` =  '$file_name1' WHERE `product_id` = $id") ;
        echo $x;
        move_uploaded_file($file_tmp1,$prod_image_location . $file_name1);
      }

      #for second image
      if(isset($_FILES['photo2']) && $_FILES['photo2']['name']!='')
      {
        #unlinking old image then uploading new image
        unlink($prod_image_location . $row_temp['second_image']);
        mysqli_query($conn,"UPDATE `product` SET second_image = '$file_name2' WHERE product_id = $id")or die("Second image not update") ;
        move_uploaded_file($file_tmp2,$prod_image_location . $file_name2);
      }

      #moving to home page after completion
      header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/dealer-home.php');

    }
    else
    {
      foreach($errors as $value)
        echo "<h2 style='color:red;text-align:center;margin-top:10px;'>{$value}</h2>";
    }

 }


  ?>











<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title></title>
  </head>
  <body>

<?php

## show category form only to admin
if($_SESSION['role'] == 1){
?>


    <!-- update category form --------------------------------------------------->
    <div class='container mt-5 jumbotron'>

      <form action='<?php $_SERVER["PHP_SELF"] ;?>' method="post" enctype="multipart/form-data">

        <h1 style ='text-align:center;'><b>UPDATE CATEGORY<br></b></h1>

        <div class="container form-group">
          <label for="catname"><b>Category Name</b></label>
          <input class="form-control" type="text" placeholder="Enter Category Name" name="catname" value="<?php echo $row_upper['cat_name'] ?>" required >

          <label for="catimg" class = "labelimg mt-3">Select Image:</label>
          <input  type="file" id="catimg" name="filephoto" class = "labelimg" >
          <img class='my-5' src="<?php echo $cat_image_location . $row_upper['cat_img'] ?>" alt="" border="3" height="150" width="250"></img>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-success" name="update_category">Submit</button>
          <span class='float-right'><a class='btn btn-success' href="admin-panel.php">Cancel</a></span>
        </div>


      </form>
    </div>
    <!-- end of update category form --------------------------------------------------->




<?php
}
## show update product form only to  thier dealer
else{
?>




<!-- add product form ------------------------------------------------------------------------------------------->
<div class='container mt-5 jumbotron'>

  <form action='<?php $_SERVER["PHP_SELF"] ;?>' method="post" enctype="multipart/form-data">

    <h1 style ='text-align:center;'><b>UPDATE PRODUCT<br></b></h1>

    <div class="container form-group">

      <label for="pro_name"><b>Product Name</b></label>
      <input class="form-control" type="text" placeholder="Enter Product Name" name="pro_name" value="<?php echo $row_upper['Name'] ?>" required>

      <label for="cat_id"><b>Type</b></label>
      <select class="form-control" class="form-control" name="cat_id"  required>

         <?php
################################## category option start ##########################################
            $get_category_sql = "SELECT * FROM category";
            $result2 = mysqli_query($conn,$get_category_sql) or die('Query failed');
            while($row2 = mysqli_fetch_assoc($result2))
            {
              $selected ='';
              if($row_upper['category_id'] == $row2['cat_id'])
                 $selected = 'selected';
         ?>
         <option value="<?php echo $row2['cat_id'] ?>" <?php echo $selected ?> >   <?php echo $row2['cat_name']; ?>  </option>

      <?php
         }
###############################category option close ##############################################
       ?>

      </select>

      <label for="brand"><b>Brand</b></label>
      <input class="form-control" type="text" placeholder="Enter Brand Name" name="brand" value="<?php echo $row_upper['Brand'] ?>" required>

      <label for="desc"><b> Description:</b></label>
      <textarea class="form-control" rows="10" id="desc" name='desc' required> <?php echo $row_upper['Description'] ?></textarea>

      <label for="price"><b>Price</b></label>
      <input type="number" class="form-control" placeholder="Enter price" name="price" min='100' max='100000' value="<?php echo $row_upper['Price'] ?>" required>

      <label for="qty"><b>Quantity</b></label>
      <input class="form-control" type="number" class="form-control" placeholder="Enter Quantity" name="qty" min='1' max='100000' value="<?php echo $row_upper['Quantity'] ?>" required>


        <label for="photo1" class = "labelimg my-3">Select 1st Image:</label>
        <input type="file" id="photo1" name="photo1" class = "labelimg">
        <img class='my-3' src="<?php echo $prod_image_location .$row_upper['first_image'] ?>" alt="" border="3" height="150" width="250">
        <br>
        <label for="photo2" class = "labelimg">Select 2nd Image:</label>
        <input type="file" id="photo2" name="photo2" class = "labelimg">
        <img class='my-3' src="<?php echo $prod_image_location .$row_upper['second_image'] ?>" alt="" border="3" height="150" width="250">

        <div class="form-group">
          <button type="submit" class="btn btn-success" name="update_product">Submit</button>
          <span class='float-right'><a class='btn btn-success' href="dealer-home.php">Cancel</a></span>
        </div>

    </div>

  </form>
</div>
<!--add product form close--------------------------------------------------------------------------------->

<?php
}#else closing
 ?>
  </body>
</html>
