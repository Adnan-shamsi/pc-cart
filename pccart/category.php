<?php
####################  included connection.php ###################
include_once('admin/connection.php');


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title></title>
  </head>
  <body>


<?php
############## included navbar.php #################
include_once('navbar.php');

 ?>




<!--image collection-->
    <div class="container-fluid">
     <div class="jumbotron text-center py-5">
       <h1 class='mt-4'>CATEGORY</h1>
    </div>
   <!--image display-->
   <style>
    .border{
      border-radius: 5px;
    }
   </style>
  <div class="container">
    <div class="row">



<?php
  # for getting CATEGORY
  $query = "SELECT * FROM category ";

  $result = mysqli_query($conn,$query) or die('Query failed');

 if (mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
 ?>
      <div class="col-lg-3 col-md-4 col-sm-6 col-6 border border-primary">
        <a href ="search.php?search=<?php echo $row['cat_name'] ?>" >
          <img src="<?php echo 'admin/'.$cat_image_location .$row['cat_img'] ?>" class='img-fluid' alt="">
          <span class='overlay btn btn-danger' style="position:absolute;left:0;bottom:0" > <?php echo $row['cat_name'] ?> </span>
        </a>
      </div>

<?php
   }//while closing
}//if loop close

#if no result found
else{
  echo "<h1 style='color:purple;text-align:center;margin:auto'>No Result Found<h1></div>";
}
 ?>


    </div>
  </div>
  </div>

  </body>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <script>
  $(document).ready(function(){
     $('.overlay').mouseenter(function(){
       $(this).hide();
     });
     $('.overlay').mouseout(function(){
       $(this).show();
     });
  })
  </script>
  </html>
