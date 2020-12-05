<?php
 ################################# login check #######################################
  session_start();
  include_once ('connection.php');
  #checking for login
  if (!isset($_SESSION['person_id']))
     header('Location: https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');
 ?>

 <?php
################# getting data to use as input in form ######################################
    $id = $_SESSION['person_id'];
    $query = "SELECT * FROM person WHERE person_id = $id";
    $result = mysqli_query($conn,$query) or die("Unsuccessful");
    $row = mysqli_fetch_array($result);

    #checking if there is any result
    if(mysqli_num_rows($result) == 0)
      die('Unsuccessfull');


   if(isset($_POST['submit']))
   {
      $firstname = mysqli_real_escape_string($conn,trim($_POST['fname']));
      $lastname = mysqli_real_escape_string($conn,trim($_POST['lname']));
      $email = mysqli_real_escape_string ($conn,trim($_POST['email']));
      $address = mysqli_real_escape_string($conn,trim($_POST['address']));
      $phone_number = trim($_POST['Phone']);

      #checking if name consist of  only alphabets and not empty after trim
      if($firstname!='' && $lastname!='' && $address !='')
      {
        # removing +91 from phone number
        if($phone_number[0] == '+')
           echo substr($phone_number,3,10);

        if(ctype_digit($phone_number) && strlen($phone_number) == 10 && $phone_number[0]!='-')
        {
           $phone_number = mysqli_real_escape_string($conn,$phone_number);

           #checking if phone number is unique or not
           $validate_phone = "SELECT username FROM person
                              WHERE  Phone = '{$phone_number}' AND NOT person_id = {$_SESSION['person_id']} ";
           $result = mysqli_query($conn,$validate_phone) or die('Query failed');

           if(mysqli_num_rows($result)> 0)
             echo "<h4 style='color:red;text-align:center;margin-top:10px;'>Phone number has already been registered<br>Type another Phone number!!</h4>";

           else
           {
                #checking if email unique or not
                $validate_email = "SELECT username FROM person  WHERE BINARY email = '{$email}' AND  NOT person_id = {$_SESSION['person_id']} ";
                $result = mysqli_query($conn,$validate_email) or die('Query failed');

                if(mysqli_num_rows($result)> 0)
                  echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Email already exist!!</h2>";
                else
                {
                   $query = "UPDATE person
                             SET `FirstName`='$firstname', `LastName`='$lastname', `Email`='$email', `Address`='$address', `Phone`=$phone_number
                             WHERE person_id = {$_SESSION['person_id']} ";

                  $result = mysqli_query($conn,$query) or die('Updation failed');

                  #moving person to their respective home page
                  $home_url = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/'
                    . ($row['Role'] == 1 ? 'admin-panel.php' : 'dealer-home.php');

                  header("Location:" . $home_url);

               }
           }
        }
      }#if close for checking any input empty
      else
        echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Invalid entry!!</h2>";
   }#if isset(summit)
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
         <h1 class='text-center'>Update Account</h1>

         <form class='form-container'  action='<?php $_SERVER["PHP_SELF"] ;?>' method="post">

          <div class="form-group">
           <label>Firstname</label>
           <input type="text" class="form-control" name='fname' value="<?php echo $row['FirstName'] ?>" required>
          </div>

          <div class="form-group">
           <label>Lastname</label>
           <input type="text" class="form-control" name='lname' value="<?php echo $row['LastName']  ?>" required>
          </div>

            <div class="form-group">
             <label>Email</label>
             <input type="email" class="form-control" name='email' value="<?php echo $row['Email'] ?>" required>
            </div>


            <div class="form-group">
             <label>Phone Number</label>
             <input type="text" class="form-control" name='Phone' value="<?php echo $row['Phone']  ?>" required>
            </div>

            <div class="form-group">
              <label>Address</label>
              <input type="address" class="form-control" name='address' value="<?php echo $row['Address'] ?>" required>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              <span class='float-right'><a class='btn btn-primary' href="<?php echo ($_SESSION['role'] == 1 ? 'admin-panel.php' : 'dealer-home.php')?>">Cancel</a></span>
            </div>

         </form>

   <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
    </div>
    </div>
   <!--form end-->
  </body>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
