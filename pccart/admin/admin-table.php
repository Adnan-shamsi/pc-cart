<?php
session_start();
# checking login
if (!isset($_SESSION['person_id']))
  header('Location:https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login-panel.php');
#redirecting dealer to dealer home page
else if ($_SESSION['role'] == 0)
     header('Location:https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/dealer-home.php');
#additional check
else if($_SESSION['role'] != 1)
     die('404 Page not Found');

#included connection file
include_once ('connection.php');

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

#fetching result
$result = mysqli_query($conn,"SELECT * FROM person WHERE Role = 1 ORDER BY person_id DESC");

################ included navbar file ################################################
  include_once ('navbar.php');

  if (mysqli_num_rows($result) > 0) {
?>

    <table>
    <tr>
        <th>AdminID</th>
        <th>Full Name</th>
        <th>EmailID</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php

while($row = mysqli_fetch_array($result)) {
?>
<tr>

    <td><?php echo $row["person_id"]; ?></td>
    <td><?php echo $row["FirstName"]; ?></td>
    <td><?php echo $row["Email"]; ?></td>
    <td><a href='edit.php?pid=<?php echo $row["person_id"]; ?>'><i class="fa fa-pencil-square-o" style="font-size:30px;color:black" aria-hidden="true"></i></a></td>
    <td><button class="fa fa-trash" style="font-size:30px;color:orangered" aria-hidden="true" onClick="delete_me(<?php echo $row['person_id']; ?>)" name="delete_btn" ></button></td>
    </tr>

    <!-- JS for popup on deleting item-->
    <script type="text/javascript">
      function delete_me(del_id)
      {
        if(<?php echo $_SESSION['person_id'] ?> != del_id){
          if(confirm("Do you want to delete admin :" +del_id +'')){
             window.location.href ="delete-data.php?person="+del_id +'';
             return true;
         }
       }
       else {
         alert("You can't delete youself");
       }

      }
    </script>






<?php
}#closing of while loop
?>

</table>
 <?php
}#closing of if loop

#if no entry found
else
    echo "<h1  style='color:red;margin:100px;text-align:center'>No Result Found<h1>";

?>
    </table>

</body>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
