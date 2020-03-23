<?php
include('admin/connection.php');

$pid= $_GET['id'];
$result = mysqli_query($conn,"SELECT * FROM product WHERE Product_id = $pid") or die("unsuccessful");
$row = mysqli_fetch_array($result);
$cid=$row['category_id'];
$result2 = mysqli_query($conn,"SELECT * FROM product WHERE category_id = $cid") or die("unsuccessful");


?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" href="css/style.css">
<title>Description</title>
</head>
<body class='pb-5'>

<!--navbar start-->
<?php
############## included navbar.php  ##################
include_once('navbar.php');

 ?>

  <!--navbar end-->

<!--crousel and description  --------------------------->
<div class="container" style='margin-top:100px'>
  <div class="row ">

    <div class="col-md-5">
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active"> <img class="d-block w-100" src=<?php echo 'admin/'. $prod_image_location .$row['first_image']?> alt="First slide"> </div>
          <div class="carousel-item"> <img class="d-block w-100" src=<?php echo 'admin/'. $prod_image_location .$row['second_image']?> alt="Second slide"> </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
    </div>
    <div class="col-md-6 mx-2">
      <div class="row">
        <i><h2 class='text-primary'><?php echo $row['Name'] ?></h2></i>
      </div>
      <div class="row">
        <h1><i class="fa fa-inr" aria-hidden="true"></i><?php echo $row['Price'] ?></h1>
      </div>
      <!--Specification start-->
      <div class="row">
        <h3>Description</h3>
        <p><br><br><?php echo $row['Description'] ?></p>
      </div>
      <div class="row mt-4">
        <h3 class="text-info"><i class="fa fa-map-marker" aria-hidden="true"></i></h3>
        <p style="font-size: 20px"> &nbsp; Delivery by 23 July| &nbsp; <span class="text-success">FREE</span> </p>
      </div>
      <div class="row mt-4">
          <button class='btn btn-success m-2' type="button" name="button">Buy Now</button>
        <button class='btn btn-warning m-2' type="button" name="button">Add To Cart<i class="fa fa-cart-plus" aria-hidden="true"></i></button>
      </div>

    </div>
  </div>
</div>
<!--crousel and description close------------------------------------------>


<!---similar products ----------------------------------------------------->
<div class="container mt-5">

   	 <h2>Similar Products</h2><br>
      <?php
  while($row2 = mysqli_fetch_array($result2)) {
  ?>
    <div class='row jumbotron'>
  
      <div class="col-lg-3 col-md-4 col-sm-6 similar col-5 my-1 ">
        <div class="card inside-similar">
          <img class="img-fluid" src=<?php echo 'admin/'. $prod_image_location . $row2['first_image'] ?> alt="Card image cap" style="height:20vh">

          <div class="card-body" >
            <h5 class="card-title" style='height:25px;overflow-x:hidden;overflow-y:hidden;margin:0px 0px'><?php echo $row2['Name']?></h5>
            <p class='text-info mt-md-1 mb-0'><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $row2['Price']?></p>
          </div>

          <div class='dontshow'>
            <p class="card-text "><?php echo $row2['Description']?></p>
          </div>

          <div class='pb-2 pt-1 pb-lg-1 mx-2'>
            <button class='btn btn-success' type="button" name="button">Buy Now</button>
              <button type="button" name="button" class='btn btn-warning' style='float:right'><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
          </div>
        </div>
        
     </div>
     <?php 
    }
    ?>

    </div>
    
  </div>
  
</div>

<?php 
$result3 = mysqli_query($conn,"SELECT * FROM reviews WHERE product_id = $pid") or die("unsuccessful");
?>

<!--review start-->
<div class="container mt-5 mb-5 m-auto makeItSmall">
	<div>
		<h2 class='m-xs-auto'>Ratings & Reviews</h2>
	</div>
<div class="row mt-5 mb-5">

<?php 

while($row3 = mysqli_fetch_array($result3)) {
  $cust_id=$row3['customer_id'];
  $name = mysqli_query($conn,"SELECT FirstName FROM customer WHERE customer_id = $cust_id ") or die("unsuccessful");
  $row4 = mysqli_fetch_array($name);
?>

  <div class='row'>
      <div class="col-md-3">
        <h3 class='text-info'><?php $row4['FirstName'] ?></h3>
      </div>
      <div class="col-md-9">
          <h5 class="mt-0 text-danger"><?php $row3['rating'] ?></h5>
          <?php $row3['review'] ?>
      </div>
  </div>
<?php 
}
?>
 </div>
<!--review ends-->



	<form action="" method="GET">
  <div class="form-group">
          <label for="sel1">Select your experience:</label>
          <select class="form-control" name="reviews">
            <option value="Awesome product">Awesome product</option>
            <option value="Very nice product">Very nice product</option>
            <option value="Good product">Good product</option>
            <option value="Average product">Average product</option>
            <option value="Bad product">Bad product</option>
          </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Type your Review</label>
    <textarea type="text" class="form-control" id="exampleInputtextarea" placeholder="write your own reviews" rows="3"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

















<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
