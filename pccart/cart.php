<?php

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
  <link rel="stylesheet" type="text/css" media="screen" href="css/cart.css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" media="screen" href="css/cart.css" />
</head>

<body>
  <div class="main_grid">
    <div class="shopping_cart">
      <h1>Pc-Cart</h1>
      <div class="product">
        <div class="product-details">
          <p>Product Details</p>
        </div>
        <div class="product-quantity">
          Quantity
        </div>
        <div class="product-price">Price</div>
        <div class="product-removal"></div>
        <div class="product-total">Total</div>
      </div>
      <div class="product">
        <div class="product-details">
          <div class="product-image">
            <img src="image/1.jpg" />
          </div>
          <div class="product-title">Gaming Machines</div>
          <div class="product-description">
            Product Code X&R@)PX
          </div>
        </div>
        <div class="product-quantity">
          <button class="decrement">-</button>
          <input type="number" id="proquanta" value="2" max="10" min="1" />
          <button class="increment">+</button>
        </div>
        <div class="product-price">2.99</div>
        <div class="product-removal">
          <button class="remove-product">
            Remove
          </button>
        </div>
        <div class="product-total">

          <p>79</p>
        </div>
      </div>
      <div class="product">
        <div class="product-details">
          <div class="product-image">
            <img src="image/10.jpg" />
          </div>
          <div class="product-title">Gaming Machines</div>
          <div class="product-description">
            Product Code X&R@)PX
          </div>
        </div>
        <div class="product-quantity">
          <button class="decrement">-</button>
          <input type="number" id="proquanta" value="1" max="10" min="1" />
          <button class="increment">+</button>

        </div>
        <div class="product-price">4.67</div>
        <div class="product-removal">
          <button class="remove-product">
            Remove
          </button>
        </div>
        <div class="product-total">79</div>
      </div>
      <div class="product">
        <div class="product-details">
          <div class="product-image">
            <img src="image/2.jpg" />
          </div>
          <div class="product-title">Gaming Machines</div>
          <div class="product-description">
            Product Code X&R@)PX
          </div>
        </div>
        <div class="product-quantity">
          <button class="decrement">-</button>
          <input type="number" id="proquanta" value="2" max="10" min="1" />
          <button class="increment">+</button>
        </div>
        <div class="product-price">4.67</div>
        <div class="product-removal">
          <button class="remove-product">
            Remove
          </button>
        </div>
        <div class="product-total">79</div>
      </div>
    </div>
    <div class="order_summary">
      <h1>Order Summary</h1>
      <div class="order_summary_of_cart">
        <div class="total_items">11 items</div>
        <div class="total_price">Rs 200</div>
        <p>Delivery Fee</p>
        <p>Rs 0.0</p>
      </div>
      <div class="total_summary">
        <p>Total Fee</p>
        <p>Rs 0.0</p>
      </div>
      <div class="Summary_wrap">
        <button>Buy Now</button>
      </div>
    </div>
  </div>
  <style>
    .product-total::after,
    .product-total::before {
      display: none;
    }
  </style>
  <script>
    $(document).ready(function() {
      $('.product-removal').on('click', function() {
        $(this).parent('.product').remove();
        update();
      })

      function update() {
        let total = 0;
        let indi_total = 0;
        let totalItems = 0;
        let i = 0;
        $('.product-total').each(function() {
          if (i != 0) {
            total += Number($(this).text());
            totalItems += Number($(this).siblings('.product-quantity').children('#proquanta').val());
            indi_total = ($(this).siblings('.product-price').text()) * ($(this).siblings('.product-quantity').children('#proquanta').val());
            $(this).html(`${indi_total}`);
          }
          i++;
        })
        $('.total_items').html(`${totalItems} items `);
        $('.total_price').html(`Rs  ${total}`);
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
