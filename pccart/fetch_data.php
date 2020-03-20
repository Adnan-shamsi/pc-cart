<?php
##including connction.php from admin panel
include('admin/connection.php');

if(isset($_POST['search_for']))
{
    $search  = $_POST['search_for'];

    $query = "SELECT * FROM category
              JOIN product ON cat_id = category_id
              WHERE (cat_name REGEXP '{$search}' OR
              name REGEXP '{$search}' OR
              description REGEXP '{$search}')";

    if(isset($_POST['minimum_price'])&& isset($_POST['maximum_price']) && !empty($_POST['maximum_price']) && !empty($_POST['minimum_price']) )
    {
      $query.= " AND (price BETWEEN {$_POST['minimum_price']} AND {$_POST['maximum_price']})";
    }

    if(isset($_POST['brand']))
    {  ##creating regular expression for sql
       $brand_filter = implode("$|^",$_POST['brand']) ;
       $brand_filter = "^" . $brand_filter . "$";
       $query .= " AND brand REGEXP '{$brand_filter}'";
    }
    $result = mysqli_query($conn,$query) or die('Query failed');

    if (mysqli_num_rows($result) > 0)
    {
      while($row = mysqli_fetch_array($result)){
?>

<div class="col-lg-3 col-md-4 col-sm-6 col-9 my-1 m-xs-auto">
  <div class="card">
    <img class="img-fluid p-xs-3" src="<?php echo 'admin/'.$prod_image_location . $row['first_image'] ?>" alt="Card image cap" style="height:20vh">
    <div class="card-body" style='height:22vh;overflow-x:hidden;overflow-y:hidden;'>
      <h5 class="card-title"><?php echo (substr($row['Name'],0,30)) ?></h5>
      <p class='text-info'><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $row['Price'] ?> </p>
        <p class="card-text"><?php echo $row['Description'] ?></p>
     </div>
    <div class='pb-2 pt-1 pb-lg-1 mx-2'>
        <button class='btn btn-success' type="button" name="button">Buy Now</button>
        <button type="button" name="button" class='btn btn-warning' style='float:right'>Add To <i class="fa fa-cart-plus" aria-hidden="true"></i></button>
   </div>
 </div>
</div>

<?php
      }##while closing
    }//if closing
    else{
      echo "<h1 style='color:purple;text-align:center;margin:auto'>No Result Found<h1></div>";
    }

}










 ?>
