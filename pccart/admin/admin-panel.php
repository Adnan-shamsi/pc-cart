<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="css/adminstyle.css">
</head>

<body>

  <?php
  #####################  php code for adding admin or dealer   ######################################
  if(isset($_POST['add_admin']) || isset($_POST['add_dealer']) )
  {
     include 'connection.php';
     $username = mysqli_real_escape_string($conn,$_POST['uname']);
     $firstname = mysqli_real_escape_string($conn,$_POST['fname']);
     $lastname = mysqli_real_escape_string($conn,$_POST['lname']);
     $password = mysqli_real_escape_string($conn,md5($_POST['psw']));
     $email =mysqli_real_escape_string ($conn,$_POST['email']);
     $address =mysqli_real_escape_string($conn,$_POST['address']);
     $phone_number = $_POST['Phone'];

     # removing +91 from phone number
     if($phone_number[0] == '+')
        echo substr($phone_number,3,10);

     # checking if username is unique or not
     $validate_username = "SELECT username FROM person WHERE  username = '{$username}'  ";
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
         $validate_phone = "SELECT username FROM person WHERE  Phone = '{$phone_number}'  ";
         $result = mysqli_query($conn,$validate_phone) or die('Query failed');

         if(mysqli_num_rows($result)> 0)
           echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Phone number has already been registered<br>Type another Phone number!!</h2>";

         else
         {
                #checking in email unique or not
                $validate_email = "SELECT username FROM person WHERE email = '{$email}'  ";
                $result = mysqli_query($conn,$validate_email) or die('Query failed');

                if(mysqli_num_rows($result)> 0)
                  echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Email already exist!!</h2>";

                else
                {
                    #insertion in the table for person
                    $sql1 = "INSERT INTO person (FirstName, LastName, Username, Password, Email, Address,Phone, Role) VALUES ('{$firstname}','{$lastname}','{$username}','{$password}','{$email}','{$address}','{$phone_number}',";

                    if(isset($_POST['add_admin']))
                      $sql1 .= "1);";
                    else
                      $sql1 .= "0);";

                   mysqli_query($conn,$sql1) or die('insertion failed');
                   echo "<h2 style='color:slateblue;text-align:center;margin-top:10px;'>SuccessFull!!</h2>";
                }
            }
         }
         else
         echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Incorrect Phone Number!!</h2>";
       }
  }#if isset button
   ?>

 <?php
   ######################## php code for adding category ##########################################
   include ('connection.php');

   if(isset($_POST['add_category']))
   {
     $title = strtoupper($_POST['catname']);

     #checking if category name is unique or not
     $validate_category = "SELECT cat_id FROM category WHERE cat_name = '{$title}' ";
     $result = mysqli_query($conn,$validate_category) or die('Query failed');

     if(mysqli_num_rows($result)> 0)
       echo "<h2 style='color:red;text-align:center;margin-top:10px;'>Category already exist!!</h2>";
    else
    {
       # validate image
       if(isset($_FILES['filephoto']))
       {
          $errors = array();
          $file_name = $_FILES['filephoto']['name'];
          $file_size = $_FILES['filephoto']['size'];
          $file_tmp = $_FILES['filephoto']['tmp_name'];
          $file_type = $_FILES['filephoto']['type'];
          $temp = explode('.',$file_name);
          $file_ext = strtolower(end($temp));
          $extensions = array('jpeg','jpg','png');

          #checking file extension
          if(in_array($file_ext,$extensions) == false)
            $errors[] = "Extension not allowed, Please choose a jpeg or png";

          #checking size of file
          if($file_size > 2097152 )
            $errors[] = 'File must be 2MB or lower';

          #reducing name conflict by adding date to name and extension to the end
          $file_name = date("dmyhis") . (substr($temp[0],0,30)) . '.' . $file_ext ;

          if(empty($errors)  == true)
          {
            #insert category into the table
            move_uploaded_file($file_tmp,$cat_image_location . $file_name);
            $insert_category ="INSERT INTO category(cat_name,cat_img) VALUES ('{$title}','{$file_name}')" ;
            mysqli_query($conn,$insert_category) or die('Unable to save category to Database');
            echo "<h2 style='color:slateblue;text-align:center;margin-top:10px;'>SuccessFull!!</h2>";
          }
          else
          {
            foreach($errors as $value)
              echo "<h2 style='color:red;text-align:center;margin-top:10px;'>{$value}</h2>";
          }

       }

    }

   }

  ?>





<!--sidebar start---------------------------------------------------->
  <div id="mySidenav" class="sidenav" >
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="passwordchange.html">Change Password</a>
    <a href="accountinfo.html">Change account info</a>
    <a href="#">Contact</a>
  </div>
<!--sidebar end------------------------------------------------------>



  <span style="font-size:30px;cursor:pointer;margin-left:1%" onclick="openNav()">&#9776;</span>
  <br>
  <button class='buttonClass' onclick="document.getElementById('id01').style.display='block'" type="button" style="width:80%;">Add admin</button>
<!--add admin form--------------------------------------------------->
  <div id="id01" class="modal">
    <form class="modal-content animate" action='<?php $_SERVER["PHP_SELF"] ;?>' method="post">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      </div>

       <h1><b>ADD ADMIN</b></h1>
      <div class="container">

        <label for="uname"><b>Admin Username</b></label>
        <input type="text" placeholder="Enter admin Username" name='uname' required>

        <label for="psw"><b>Admin Password</b></label>
        <input type="password" placeholder="Enter admin Password" name="psw" required>

        <label for="fname"><b>Admin FirstName</b></label>
        <input type="text" placeholder="Enter admin Firstname" name='fname' required>

        <label for="lname"><b>Admin LastName</b></label>
        <input type="text" placeholder="Enter admin Lastname" name='lname' required>

        <label for="Email"><b>Admin Email</b></label>
        <input type="email" style='display:block;width:100%;height:45px' placeholder="xyz@gmail.com" name="email" required>

        <label for="Address"><b>Admin Address</b></label>
        <input type="text" placeholder="Enter admin address" name="address" required>

        <label for="Phone"><b>Phone No.</b></label>
        <input type="text" id='num' placeholder="Enter admin Phone No." name="Phone" required>

        <input type="submit" class='btn btn-success' style='width:100%' name='add_admin' >Submit
      </div>
    </form>
  </div>

  <button class='buttonClass' type="button" onclick="document.getElementById('id02').style.display='block'"  style="width:80%;">Add dealer</button>
  <!--end of add admin form --------------------------------------------------->


  <!--add dealer form--------------------------------------------------->
  <div id="id02" class="modal">

    <form class="modal-content animate" action='<?php $_SERVER["PHP_SELF"] ;?>' method="post">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      </div>

     <h1><b>ADD DEALER</b></h1>
      <div class="container">
        <label for="uname"><b>Dealer Username</b></label>
        <input type="text" placeholder="Enter dealer Username" name="uname" required>

        <label for="psw"><b>Dealer Password</b></label>
        <input type="password" placeholder="Enter dealer Password" name="psw" required>

        <label for="fname"><b>Dealer Firstname</b></label>
        <input type="text" placeholder="Enter dealer Firstname" name="fname" required>

        <label for="lname"><b>Dealer Lastname</b></label>
        <input type="text" placeholder="Enter dealer Lastname" name="lname" required>

        <label for="Email"><b>Dealer Email</b></label>
        <input type="email" style='display:block;width:100%;height:45px' placeholder="xyz@gmail.com" name="email" required>

        <label for="Address"><b>Dealer Address</b></label>
        <input type="text" placeholder="Enter dealer address" name="address" required>

        <label for="Phone"><b>Phone No:</b></label>
        <input type="text" id='num' placeholder="Enter admin Phone No." name="Phone" required>

        <input type="submit" class='btn btn-success' style='width:100%' name='add_dealer'>Submit

      </div>
    </form>
  </div>
  <!--end of add dealer form --------------------------------------------------->


  <button class='buttonClass' onclick="window.location.href='admin-table.html';" style="width:80%;">Delete admin</button>
  <button class='buttonClass' onclick="window.location.href='dealer-table.html';" style="width:80%;">Delete dealer</button>

  <button class='buttonClass' onclick="document.getElementById('id03').style.display='block'" type="button" style="width:80%;">Add Category</button>



  <!--add category form --------------------------------------------------->
  <div id="id03" class="modal">

    <form class="modal-content animate" action='<?php $_SERVER["PHP_SELF"] ;?>' method="post" enctype="multipart/form-data">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
      </div>

      <h1><b>ADD CATEGORY<br></b></h1>

      <div class="container">
        <label for="catname"><b>Category Name</b></label>
        <input type="text" placeholder="Enter Catagory Name" name="catname" required>

        <label for="catimg" class = "labelimg mt-3">Select Image:</label>
        <input type="file" id="catimg" name="filephoto" class = "labelimg" required>

        <input type="submit" class='btn btn-success' style='width:100%' name='add_category'>Submit
      </div>

    </form>
  </div>
  <!-- end of add category form --------------------------------------------------->


  <button class='buttonClass' onclick="window.location.href='Category.html';" style="width:80%;">View Category</button>

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
