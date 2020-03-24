<?php

###included connection.php which is in admin
include("admin/connection.php");

$search = '';

if(isset($_GET['search']))
{
   ## to break search products at space
   $search = explode(" ",mysqli_real_escape_string($conn,trim($_GET['search'])));
   #for regular expression
   $search = implode("|", $search);
   $q = "SELECT Distinct(BRAND)  FROM category JOIN product ON cat_id = category_id WHERE cat_name REGEXP '{$search}' OR name REGEXP '{$search}' OR description REGEXP '{$search}' ORDER BY BRAND ASC ";
   $r = mysqli_query($conn,$q) or die('Query failed');

}
else{
  ##redirecting to home page if search submit is not set
  die('STOP');
  $home_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' .'home-page.php';
  header("Location:" . $home_url);
}

 ?>




<!DOCTYPE html>
<html>
<title>Search-Items</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="jqueryui/jquery-ui.min.css">
<link rel="stylesheet" href="css/style.css">

<script src="jqueryui/external/jquery/jquery.js"></script>
<script src='jqueryui/jquery-ui.min.js'></script>

<body>


<?php
############## included navbar.php  ##################
include_once('navbar.php');

 ?>




  <!-- Sidebar ------------------------------->
  <div class="w3-sidebar w3-bar-block w3-animate-left col-lg-4 col-md-5 col-6 mt-5" style="display:none;z-index:5;top:0px" id="mySidebar">
    <button id='rightShift' class="w3-bar-item w3-button w3-xxlarge" onclick="w3_close()" style='text-align:right'>&times;</button>
    <input  type='hidden' id='minPrice'></input>
    <input  type='hidden' id='maxPrice'></input><br>
    <h4>Price:</h4><span id="spanOutput"></span><br>

    <div id="slider"></div>
  <!-- Sidebar ------------------------------->


<?php
 ## if we find any result then only show brand name
 if (mysqli_num_rows($r) > 0){
?>
       <div class='list-group mt-3'>
         <h4>Brand</h4>

         <div class='mr-5' style='height:140px;overflow-y:auto;overflow-x:hidden;border:1px solid grey;'>
            <div class="list-group-item checkbox">


             <?php
               #while loop startings
              while($row = mysqli_fetch_array($r)){
             ?>

              <label><input type='checkbox' class='common_selector brand' value =<?php echo $row['BRAND']  ?> > <?php echo $row['BRAND']  ?> </label><br>

              <?php
              }#while closing
              ?>


            </div>
         </div>
<?php

}#closing of if statement
 ?>
       </div><br>
       <button  class='btn btn-success ApplyBtn' name="ApplyBtn"  style="float:right">Apply</button>
     </div>
  <!--sidebar ends----------------------------------------->




  <!-- Page Content --------------------------------------->
  <div class="w3-overlay w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

     <button class="btn btn-dark mt-5" onclick="w3_open()" style="position:absolute;top:20px;right:15px;border:3px solid grey">Filter &#977; </button>

  <!-- item List by ajax -------------------------------------------------------->
    <div class="container-fluid" style='margin-top:20vh'>
      <div class='jumbotron m-lg-3 p-lg-5'>
      <div class="row filter_data">


      </div>
    </div>
    </div>
<!--item list close------------------------------------------------------------------>

</body>

<script type="text/javascript">
//for opening sidebar
  function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
  };
//for closing sidebar
  function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
  };
//for slider
  $(document).ready(function () {
    var outputSpan = $('#spanOutput');
    var sliderDiv = $('#slider');

    sliderDiv.slider({
        range: true,
        min: 100,
        max: 100000,
        values: [1, 100000],
        slide: function (event, ui) {
            outputSpan.html(ui.values[0] + ' - ' + ui.values[1] + ' Rupees');
            $('#minPrice').val(ui.values[0]);
            $('#maxPrice').val(ui.values[1]);
        },
    });

    outputSpan.html(sliderDiv.slider('values', 0) + ' - '
        + sliderDiv.slider('values', 1) + ' Rupees');
    $('#minPrice').val(sliderDiv.slider('values', 0));
    $('#maxPrice').val(sliderDiv.slider('values', 1));
//to focus side bar and fading of background
     $('.card').on({
        mouseenter:function(){
            $(this).css('background','#e0ebeb')
        },
        mouseleave:function(){
            $(this).css('background','')
        },
     });
  });
</script>




<script type="text/javascript">
///////////  for applying filter only on clicking apply button

$(document).ready(function () {
    // onclink apply
    $('.ApplyBtn').click(apply_filter);

    // to call apply filter on starting of the page
    apply_filter();

    function apply_filter()
    {
      var search_for = "<?php echo $search ?>";
      var brand = get_filter('brand');
      var minimum_price = $('#minPrice').val();
      var maximum_price = $('#maxPrice').val();
      $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{search_for:search_for , minimum_price:minimum_price,
                  maximum_price:maximum_price , brand:brand
            },
            success:function(data){
              $('.filter_data').html(data);
            }
      });

     w3_close();
    };

    function get_filter(class_name)
    {
      var filter = [];
      $('.'+class_name +":checked").each(function()
      {
            filter.push($(this).val());
      });
      return filter;
    };


})
</script>

</html>
