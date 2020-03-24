<?php
 session_start();
 require_once('admin/connection.php');
?>

<?php

  $error_msg = "";
  if (!isset($_SESSION['customer_id']) && isset($_POST['submit']))
  {
      $user_username = mysqli_real_escape_string($conn, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($conn, trim($_POST['password']));

      #checking if username or password is not empty
      if (!empty($_POST['username']) && !empty($_POST['password']))
      {
        $user_password = md5($user_password);
        $query = "SELECT * FROM customer WHERE UserName ='$user_username' AND Password = '$user_password' ";
        $data = mysqli_query($conn, $query) or die('Query failed');

        if (mysqli_num_rows($data) == 1)
        {
          // if the num.of rows of data returned is 0
          $row = mysqli_fetch_array($data);
          $_SESSION['customer_id'] = $row['Customer_id'];
          $_SESSION['username'] = $row['UserName'];
        }
        else
          $error_msg = "<h2 style='color:red;text-align:center;margin-top:10px;'>Sorry enter the valid username and password</h2>";
      }
      else
        $error_msg = "<h2 style='color:red;text-align:center;margin-top:10px;'>Username or password fields Empty</h2>";
  }
  if(isset($_SESSION['customer_id']))
  {
    #moving customer to  home page if login
    $home_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/'
                ."home-page.php" ;

    header("Location:" . $home_url);
  }

?>

<?php
if (empty($_SESSION['customer_id'])) {
  echo '' . $error_msg . '';
}
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
        <div class=" col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
        <form class='form-container' method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <h1 class='text-center'>Login</h1>
            <div class="form-group">
             <label for="username">Username</label>
             <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
            </div>

            <div class="form-group">
             <label for="exampleInputPassword1">Password</label>
             <input type="password" class="form-control" id="exampleInputPassword1" name='password' placeholder="Password" reqiured>
            </div>
            <div>
              <a  class='float-right text-muted ' href="signup.php">New User</a><br>
            </div>
            <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
            <span class='float-right'><a class='btn btn-primary mt-3'href="home-page.php">Cancel</a></span>
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
