<?php

include_once 'connection.php';
$result = mysqli_query($conn,"SELECT * FROM person WHERE Role=1");
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

  <nav class='nav fixed-top' >
    <a class="navbar-brand " href="#">
      <img src="../icon/logo.png" height='30px' alt="">
      PC-Cart
    </a>
    <div class='navitems'>
     <a  href="admin-panel.html"><i class="fa fa-home" style='font-size:30px;color:black;padding-top:5px' aria-hidden="true"></i><span class="sr-only">(current)</span></a>
     <a class="nav-item nav-link" href="#"><i class="fa fa-truck" style='font-size:25px;color:black' aria-hidden="true"></i></a>
     <a class="nav-item nav-link" href="#">Category</a>

     <a style='position:absolute;right:10px'class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-user-circle-o" style='font-size:25px;color:black' aria-hidden="true"></i>
     </a>
     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
       <a class="dropdown-item" href="passwordchange.html">Password change</a>
       <div class="dropdown-divider"></div>
       <a class="dropdown-item" href="#">Logout</a>
     </div>
   </div>

</nav>
<?php
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
$i=0;
while($row = mysqli_fetch_array($result)) {
?>
<tr>
  
    <td><?php echo $row["person_id"]; ?></td>
    <td><?php echo $row["FirstName"]; ?></td>
    <td><?php echo $row["Email"]; ?></td>
    <td><a href='edit.php?pid=<?php echo $row["person_id"]; ?>'><i class="fa fa-pencil-square-o" style="font-size:30px;color:black" aria-hidden="true"></i></a></td>
    <td><a href='delete.php?pid=<?php echo $row["person_id"]; ?>'><i class="fa fa-trash" style="font-size:30px;color:orangered" aria-hidden="true"></i></a></td>
</tr>
<?php
$i++;
}
?>

</table>
 <?php
}
else{
    echo "No result found";
}
?>
    </table>

</body>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
