<?php
session_start();
include_once ('connection.php');


    $id= $_GET['pid'];

    echo "SELECT * from person WHERE person_id='" . $_SESSION["person_id"] . "'";
    if (count($_POST) > 0) {
      $result = mysqli_query($conn, "SELECT * from person WHERE person_id='" . $_SESSION["person_id"] . "'");
      $row = mysqli_fetch_array($result);
      if (md5(trim($_POST["currentPassword"])) == $row["Password"]) {
          mysqli_query($conn, "UPDATE person set password='" . md5(trim($_POST["newPassword"])) . "' WHERE person_id='" . $_SESSION["person_id"] . "'");
          $message = "Password Changed";
      } else
      $message = "Current Password is not correct";
   
      if($_SESSION['role'] != 1)
      header("Location: http://localhost/pc-cart/pccart/admin/admin-panel.php");
      else if($_SESSION['role'] != 0)
      header("Location: http://localhost/pc-cart/pccart/admin/dealer-home.php");    
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
        <form class='form-container' method="POST" action="" onSubmit="return validatePassword()">
          <h1 class='text-center'>Change password</h1>
            <div class="form-group">
             <input type="hidden" class="form-control" id="username" value="<?php echo $id; ?>"">
            </div>

            <div class="form-group">
             <label for="exampleInputPassword1">Old Password</label>
             <input type="password" class="form-control" name="currentPassword" placeholder="Old Password"><span id="currentPassword" class="required"></span>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">New Password</label>
                <input type="password" class="form-control" name="newPassword" placeholder="New Password"><span id="newPassword" class="required"></span>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password"><span id="confirmPassword" class="required"></span>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <span class='float-right'><a class='btn btn-primary'href="index.html">Cancel</a></span>
        </form>
      </div>

      <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
    </div>
    </div>
   <!--form end-->
  </body>

  <script>
function validatePassword() {
var currentPassword,newPassword,confirmPassword,output = true;

currentPassword = document.frmChange.currentPassword;
newPassword = document.frmChange.newPassword;
confirmPassword = document.frmChange.confirmPassword;

if(!currentPassword.value) {
currentPassword.focus();
document.getElementById("currentPassword").innerHTML = "required";
output = false;
}
else if(!newPassword.value) {
newPassword.focus();
document.getElementById("newPassword").innerHTML = "required";
output = false;
}
else if(!confirmPassword.value) {
confirmPassword.focus();
document.getElementById("confirmPassword").innerHTML = "required";
output = false;
}
if(newPassword.value != confirmPassword.value) {
newPassword.value="";
confirmPassword.value="";
newPassword.focus();
document.getElementById("confirmPassword").innerHTML = "not same";
output = false;
} 	
return output;
}
</script>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
