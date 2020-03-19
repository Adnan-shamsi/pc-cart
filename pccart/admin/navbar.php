<nav class='nav fixed-top' >
  <a class="navbar-brand " href="#">
    <!--logo-------------------------------->
    <img src="../icon/logo.png" height='30px' alt="">
    PC-Cart
  </a>
  <div class='navitems'>

  <!--home page icon------------->
   <a  href="<?php echo ($_SESSION['role'] == 1 ? 'admin-panel.php' : 'dealer-home.php') ?>"><i class='fa fa-home' style='font-size:30px;color:black;padding-top:5px' aria-hidden='true'></i><span class="sr-only">(current)</span></a>

  <?php
   #showing order icon and product to dealer
   if ($_SESSION['role'] == 0)
   {
      echo "<a class='nav-item nav-link' href='order.php'><i class='fa fa-truck' style='font-size:25px;color:black' aria-hidden='true'></i></a>";
      echo "<a class='nav-item nav-link' href='product-table.php'>Product</a> ";
   }
   #showing category to admin
   else
      echo "<a class='nav-item nav-link' href='category.php'>Category</a> ";
  ?>
  <!--drop down--------------------------------------------------------------->
   <a style='position:absolute;right:10px'class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-user-circle-o" style='font-size:25px;color:black' aria-hidden="true"></i>
   </a>
   <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
     <a class="dropdown-item" href="account-update.php?">Update Details</a>
     <a class="dropdown-item" href="password-change.php?">Password change</a>
     <div class="dropdown-divider"></div>
     <a class="dropdown-item" href="logout.php">Logout</a>
   </div>
 </div>
</nav>
