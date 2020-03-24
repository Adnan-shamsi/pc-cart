<?php
####### starting session
session_start();
####### include connection.php
include('admin/connection.php');
### geting id of product
$pid = mysqli_real_escape_string($conn,trim($_GET['pid']));

$result = mysqli_query($conn,"SELECT * FROM product WHERE Product_id = $pid") or die("unsuccessful");
$row = mysqli_fetch_array($result);

### getting category of the product
$cid = $row['category_id'];
## getting only four other similar products

$result2 = mysqli_query($conn,"SELECT * FROM product
                               WHERE (category_id = $cid)
                               AND (Product_id <> $pid) LIMIT 0, 4") or die("unsuccessful");

############## if review is submitted ############################
if(isset($_GET['submit']) && $_SESSION['id'])
{
   $title = mysqli_real_escape_string($conn,trim($_GET['title']));
   $comment = mysqli_real_escape_string($conn,trim($_GET['comment']));

   //to check if he is not submitting comment again for this product
   $res = mysqli_query($conn,"SELECT * FROM reviews
                              WHERE cus_id = {$_SESSION['id']}
                              AND p_id ={$pid}") or die("unsuccessful");

   //only accept unique person id for particular product
   if (mysqli_num_rows($res) == 0)
   {
     mysqli_query($conn,"INSERT INTO `reviews`(`comment`, `cus_id`, `title`, `p_id`)
                         VALUES ('{$comment}',{$_SESSION['id']},{$title},{$pid},)") or die("unsuccessful");
   }



}








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

<?php
####### included navbar.php ###########
include_once('navbar.php');
?>


<!--crousel and description  --------------------------->
<div class="container" style='margin-top:100px'>
  <div class="row ">

    <div class="col-md-5">
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <!--first image-->
          <div class="carousel-item active"> <img class="d-block w-100" src="<?php echo 'admin/'. $prod_image_location .$row['first_image']?>" alt="First slide"> </div>
          <!--second image-->
          <div class="carousel-item"> <img class="d-block w-100" src="<?php echo 'admin/'. $prod_image_location .$row['second_image']?>" alt="Second slide"> </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
    </div>
    <div class="col-md-6 mx-2">
      <!--name of product-->
      <div class="row">
        <i><h2 class='text-primary'><?php echo $row['Name'] ?></h2></i>
      </div>

      <div class="row">
        <h4 class='text-danger ml-0'>BRAND: <?php echo $row['Brand'] ?></h4>
      </div>


      <div class="row">
        <!--price of product-->
        <h1><i class="fa fa-inr" aria-hidden="true"></i><?php echo $row['Price'] ?></h1>
      </div>
      <!--Specification start-->
      <div class="row">
        <h3>Specification</h3>
      </div>

      <div class="row">
        <p style="font-size:18px;" > <?php echo str_replace("\n","<br>",$row['Description']) ?> </p>
      </div>


      <div class="row mt-4">
        <h3 class="text-info"><i class="fa fa-map-marker" aria-hidden="true"></i></h3>
        <p style="font-size: 20px"> &nbsp; Delivery by <?php echo date('j F', strtotime(' + 5 days')); ?>| &nbsp; <span class="text-success">FREE</span> </p>
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
<?php
##### if we find any result of similar product #########################
if (mysqli_num_rows($result2) > 0) {
?>

<div class="container mt-5">

   	 <h2>Similar Products</h2><br>
    <div class='row jumbotron'>

<?php
############# starting of while loop  ####################
while($row2 = mysqli_fetch_array($result2)) {
?>

      <div class="col-lg-3 col-md-4 col-sm-6 similar col-5 my-1 ">
        <div class="card inside-similar">
        <a  href="<?php echo 'description.php?pid='. $row2['Product_id'] ?>"> <img class="img-fluid img-onsmall" src="<?php echo 'admin/'. $prod_image_location .$row2['first_image']?>" alt="Card image cap" style="height:20vh">

          <div class="card-body" >
            <h5 class="card-title" style='height:25px;overflow-x:hidden;overflow-y:hidden;margin:0px 0px'> <?php echo $row2['Name'] ?> </h5> </a>
            <p class='text-info mt-md-1 mb-0'><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $row2['Price'] ?> </p>
          </div>

          <div class='dontshow px-1'>
            <p class="card-text "> <?php echo $row2['Description'] ?> </p>
          </div>

          <div class='pb-2 pt-1 pb-lg-1 mx-2'>
            <button class='btn btn-success' type="button" name="button">Buy Now</button>
              <button type="button" name="button" class='btn btn-warning' style='float:right'><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
          </div>
        </div>
     </div>

<?php
 }//while closing
?>

</div>
</div>

<?php
}//if close
 ?>

<!---similar products description------------->

<!--review start------------------------------>
<div class="container mt-5 mb-5 m-auto makeItSmall">
	<div>
		<h2 class='m-xs-auto'>Ratings & Reviews</h2>
	</div>

<div class="row mt-5 mb-5">

<?php
###### reviews #########
$result3 = mysqli_query($conn,"SELECT * FROM reviews
                               JOIN customer ON customer_id = cus_id
                               WHERE p_id = {$pid}
                               ORDER BY review_id DESC LIMIT 0, 10") or die("unsuccessfull");

 ?>

<?php
#### while loop for getting top 10 latest Reviews
while($row3 = mysqli_fetch_array($result3)) {
 ?>
  <div class='row my-2'>
      <div class="col-md-3">
        <h3 class='text-info'> <?php echo $row3['Name'] ?> </h3>
      </div>
      <div class="col-md-9">
          <h5 class="mt-0 text-danger"><?php
                                         if($row3['title'] == 1)
                                         echo "Awesome ";
                                         else if($row3['title'] == 2)
                                         echo "good ";
                                         else if($row3['title'] == 3)
                                         echo "Average ";
                                         else if($row3['title'] == 4)
                                         echo "Bad ";

                                        echo "Product";
                                       ?></h5>
         <p>  <?php echo $row3['comment']  ?>   </p>
      </div>
  </div>

<?php
}//while loop closing
?>


 </div>
<!--review ends-->



	<form action='<?php $_SERVER["PHP_SELF"] ;?>' method="GET" >
  <div class="form-group">
          <label for="sel1">Select your experience:</label>
          <select class="form-control" id="sel1" name='title' required>
            <option value="1">Awesome</option>
            <option value="2">Good</option>
            <option value="3">Average</option>
            <option value="4">Bad</option>
          </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Type your Review</label>
    <textarea type="text" class="form-control" id="exampleInputtextarea" placeholder="write your own reviews" rows="3" name='comment' reqiured></textarea>
    <input type="hidden" name="pid" value="<?php echo $pid ?>">
  </div>

  <button type="submit" class="btn btn-primary" name='submit'  <?php if(!isset($_SESSION['id'])) echo 'disabled'  ?> >Submit</button>
</form>

</div>

















<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
