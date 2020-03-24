<?php
session_start();
###included connection.php which is in admin
include("admin/connection.php");/*

if (isset($_SESSION['customer_id'])) {
  $query = 'SELECT or.product_id from order as or';
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.html');
}*/

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="css/cart.css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>

  <div class="main_grid">
    <!--table heading--------------->
    <div class="shopping_cart">
      <h1>Pc-Cart</h1>
      <div class="product">
        <div class="product-quantity">Name</div>
        <div class="product-quantity">Quantity</div>
        <div class="product-price">Price</div>
        <div class="product-removal"></div>
        <div class="product-total">Total</div>
      </div>
<!--table heading ends------------->

<?php
foreach($_SESSION['cart'] as $value)
{
  $query = "SELECT * FROM product WHERE product_id = $value ";
  $result = mysqli_query($conn,$query) or die('Unsuccessful');
  $row = mysqli_fetch_array($result);


?>

<!--product ----------------------->
      <div class="product">

        <div class="product-details">
          <!--product image-->
          <div class="product-image">
            <img src="<?php echo 'admin/'. $prod_image_location . $row['first_image'] ?>" />
          </div>
          <!--product name-->
          <div class="product-title"> <?php echo $row['Name'] ?></div>
        </div>
        <!--product quantity-->
        <div class="product-quantity">
          <button class="decrement">-</button>
          <input type="number" id="proquanta" value='1' max="10" min="1" />
          <button class="increment">+</button>
        </div>
        <!--product price-->
        <div class="product-price"><?php echo $row['Price'] ?></div>
        <!--remove btn-->
        <div class="product-removal" >
          <button class="remove-product" value ="<?php echo $row['Product_id'] ?>">
            Remove
          </button>
        </div>
        <!--product total-->
        <div class="product-total">

          <p><?php $row['Price'] ?></p>
        </div>
      </div>


<?php
}// foreach loop closing
 ?>

  <div class="order_summary">
      <h1>Order Summary</h1>
      <div class="order_summary_of_cart">
        <!--total item-->
        <div class="total_items"></div>
        <!--total price-->
        <div class="total_price">Rs 200</div>
        <p>Delivery Fee</p>
        <p>Rs 0.0</p>
      </div>
      <div class="total_summary">
        <p>Total Fee</p>
        <p>Rs 0.0</p>
      </div>
      <div class="Summary_wrap">
        <button class="BUY">Buy Now</button>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('.product-removal').on('click', function() {
        //getting id of remove product so to remove from session
        var product_id = $(this).children(".remove-product").val();
        //moving to another file to remove this product from session
        $.ajax({
              url:"deleteCartProduct.php",
              method:"POST",
              data:{   product_id:product_id
                   },
              success:function(data){
                alert('Successfully removed product')
              }
        });

         $(this).parent('.product').remove();
         update();

      })
      $('.product').ready(function() {
        update();
      })

      function update() {
        let total = 0;
        let indi_total = 0;
        let totalItems = 0;
        let i = 0;
        $('.product-total').each(function() {
          if (i != 0) {
            totalItems += Number($(this).siblings('.product-quantity').children('#proquanta').val());
            indi_total = ($(this).siblings('.product-price').text()) * ($(this).siblings('.product-quantity').children('#proquanta').val());
            $(this).html(`${indi_total.toFixed(2)}`);
            total += Number($(this).text());
          }
          i++;
        })
        $('.total_items').html(`${totalItems} items `);
        $('.total_price').html(`Rs  ${total.toFixed(2)}`);
        $('.total_summary p:nth-child(2)').html(`Rs  ${total.toFixed(2)}`);
      }
      $('.increment').on('click', function() {
        // console.log($(this).siblings('#proquanta')[0].value);
        $(this).siblings('#proquanta')[0].value >= 10 ? $(this).siblings('#proquanta')[0].value = 10 : $(this).siblings('#proquanta')[0].value++;
        update();
      })
      $('.decrement').on('click', function() {
        // console.log($(this).siblings('#proquanta')[0].value);
        $(this).siblings('#proquanta')[0].value > 0 ? $(this).siblings('#proquanta')[0].value-- : $(this).siblings('#proquanta')[0].value = 0;
        update();
      })
      // console.log($('#proquanta').val());
    })
  </script>


</body>

</html>
