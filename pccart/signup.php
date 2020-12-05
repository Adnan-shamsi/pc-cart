<?php
session_start();
#included connection.php
include_once ('admin/connection.php');
# if login send to home page
if (isset($_SESSION['customer_id']))
  header('Location: https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/home-page.php');

?>

<?php
#####################  php code for adding admin or dealer   ######################################
if(isset($_POST['submit']) )
{
   $username = mysqli_real_escape_string($conn,trim($_POST['uname']));
   $firstname = mysqli_real_escape_string($conn,trim($_POST['fname']));
   $lastname = mysqli_real_escape_string($conn,trim($_POST['lname']));
   $password = mysqli_real_escape_string($conn,md5(trim($_POST['psw'])));
   $email =mysqli_real_escape_string ($conn,trim($_POST['email']));
   $phone_number = trim($_POST['Phone']);
   $empty_pass = md5('');

   # removing +91 from phone number
   if($phone_number[0] == '+')
      echo substr($phone_number,3,10);

   #checking if  anything  empty
   if($username !='' && $password != $empty_pass)
   {
     # checking if username is unique or not
     $validate_username = "SELECT username FROM customer WHERE  username = '{$username}'  ";
     $result = mysqli_query($conn,$validate_username) or die('Query failed');

     if(mysqli_num_rows($result)> 0)
       echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Username already exist!!</h2>";

     else
     {
       #checking for valid phone number
       if(ctype_digit($phone_number) && strlen($phone_number) == 10 && $phone_number[0]!='-')
       {
         $phone_number = mysqli_real_escape_string($conn,$phone_number);

         #checking if phone number is unique or not
         $validate_phone = "SELECT username FROM customer WHERE  Phone = '{$phone_number}'  ";
         $result = mysqli_query($conn,$validate_phone) or die('Query failed');

         if(mysqli_num_rows($result)> 0)
           echo "<h4 style='color:red;text-align:center;margin-top:10px;'>Phone number has already been registered<br>Type another Phone number!!</h4>";

         else
         {
                #checking if email unique or not
                $validate_email = "SELECT username FROM customer  WHERE BINARY email = '{$email}'  ";
                $result = mysqli_query($conn,$validate_email) or die('Query failed');

                if(mysqli_num_rows($result)> 0)
                  echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Email already exist!!</h2>";

                else
                {
                    #insertion in the table for person
                    $sql1 = "INSERT INTO `customer` (`FirstName`, `LastName`, `UserName`, `Password`, `Phone`, `Email`)
                             VALUES ('{$firstname}','{$lastname}','{$username}','{$password}','{$phone_number}','{$email}')";


                   mysqli_query($conn,$sql1) or die('Unsuccessfull');
                   header('Location: https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php');
                }
            }
         }
         else
         echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Incorrect Phone Number!!</h2>";
       }

   }
   else
   echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Invalid Entry!!</h2>";


}#if isset button
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
        <form class='form-container' action='<?php $_SERVER["PHP_SELF"] ;?>' method="post">
          <h1 class='text-center'>Sign Up</h1>

          <div class="form-group">
           <label for="first-name">Firstname</label>
           <input type="text" class="form-control" id="first-name" name="fname" placeholder="Enter Firstname" required>
          </div>

          <div class="form-group">
           <label for="last-name">Lastname</label>
           <input type="text" class="form-control" id="last-name" name="lname" placeholder="Enter Lastname" required>
          </div>

          <div class="form-group">
           <label for="username">Username</label>
           <input type="text" class="form-control" id="username" name="uname" placeholder="Enter Username" required>
          </div>

            <div class="form-group">
             <label for="Password">Password</label>
             <input type="password" class="form-control" id="Password" name="psw" placeholder="Password"  required>
            </div>

            <div class="form-group">
             <label for="email">Email</label>
             <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
            </div>


            <div class="form-group">
             <label for="Phone" >Phone Number</label>
             <input type="text" class="form-control" id="Phone" name="Phone" placeholder="Enter Phone Number" required>
            </div>

            <div class="form-group">

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <span class='float-right'><a class='btn btn-primary'href="home-page.php">Cancel</a></span>
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
