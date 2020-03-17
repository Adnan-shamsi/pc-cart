<?php
session_start();

if (!isset($_SESSION['person_id']))
  header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');

include_once('connection.php');

if(!isset($_GET['pid']) || ($_SESSION['person_id'] != $_GET['pid']))
   die("<h2 style='text-align:center;'>Access Denied !!</h2> ");

    $id= $_GET['pid'];
    $qry="SELECT * FROM person WHERE person_id= {$id}";
    $res= mysqli_query($conn,$qry) or die("Unsuccessful");

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/loginstyle.css">
    <title></title>
  </head>
  <body>
    <!--form start-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
        <form class='form-container'>
          <h1 class='text-center'>Update Account</h1>

          <div class="form-group">
           <label>Firstname</label>
           <input type="text" class="form-control"  value="<?php echo  ?>" required>
          </div>

          <div class="form-group">
           <label>Lastname</label>
           <input type="text" class="form-control"  value="<?php  ?>" required>
          </div>

            <div class="form-group">
             <label>Email</label>
             <input type="email" class="form-control"  value="<?php  ?>" required>
            </div>


            <div class="form-group">
             <label>Phone Number</label>
             <input type="text" class="form-control" value="<?php  ?>" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="address" class="form-control" id="address" value="<?php  ?>" required>
               </div>

            <div class="form-group">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <span class='float-right'><a class='btn btn-primary'href="<?php $_SESSION['role'] == 1 ? 'admin-panel.php' : 'dealer-home.php'?>">Cancel</a></span>
        </form>
      </div>

    <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
    </div>
    </div>
   <!--form end-->
  </body>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
