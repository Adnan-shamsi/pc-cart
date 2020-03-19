<?php
session_start();
#################### login check
if (!isset($_SESSION['person_id']))
  header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');

#if role 0 redirecting to dealer
else if ($_SESSION['role'] == 0)
    header('Location:http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/dealer-home.php');
#additional check
else if($_SESSION['role'] != 1)
    die('404 Page not Found');
?>

<?php
######### included connection.php
include_once ('connection.php');
$result = mysqli_query($conn,"SELECT * FROM person WHERE Role = 0");

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/style.css">
    <title></title>
  </head>
<body>


<?php
################ included navbar file ################################################
  include_once ('navbar.php');

if (mysqli_num_rows($result) > 0) {
?>


    <table>
    <tr>
        <th>DealerID</th>
        <th>Full Name</th>
        <th>EmailID</th>
        <th>Delete</th>
    </tr>


<?php
###### php code
while($row = mysqli_fetch_array($result)) {
?>



    <tr>
    <td><?php echo $row["person_id"]; ?></td>
    <td><?php echo $row["FirstName"]; ?></td>
    <td><?php echo $row["Email"]; ?></td>
    <td><button class="fa fa-trash" style="font-size:30px;color:orangered" aria-hidden="true" onClick="delete_me(<?php echo $row['person_id']; ?>)" name="delete_btn" ></button></td>
    </tr>

    <!-- JS for popup on deleting item-->
    <script type="text/javascript">
      function delete_me(del_id)
      {
        if(confirm("Do you want to delete dealer :" + del_id +'')){
           window.location.href = "delete-data.php?person="+del_id +'';
           return true;
         }
      }
    </script>




<?php
########### php code
}
?>
    </table>


<?php
########### php code
}

#if no result found
else
      echo "<h1  style='color:red;margin:100px;text-align:center'>No Result Found<h1>";
?>





</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
