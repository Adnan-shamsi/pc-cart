<!--navbar start-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark ">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
 </button>
  <a class="navbar-brand mx-auto" href=''>
    <!--logo icon-->
    <img src="icon/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
    PC-Cart
  </a>
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
      <!--home page icon -->
        <a class="nav-link" href="home-page.php"><img src="icon/Home.png" width="30" height="30" alt="home"> <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item">
      <!--cart icon --->
        <a class="nav-link" href="cart.php"><img src="icon/cart.png" width="30" height="30" alt="cart"> </a>
      </li>
    </ul>
    <!--search form  ----------->
    <form class="form-inline my-2 my-lg-0" action='search.php' method="get" >
      <input class="form-control mr-sm-2" type="search" name='search' placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name='s'>Search</button>
    </form>
    <!--search form close ------>
  </div>
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="icon/login.png" width="30" height="30" alt="cart"></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="login.html">login</a>
          <a class="dropdown-item" href="admin/passwordchange.html">Password change</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Logout</a>
        </div>
</nav>
<!--navbar end------------------------->
