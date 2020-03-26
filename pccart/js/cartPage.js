$(document).ready(function() {
    $('.product-removal').on('click', function() {
      //getting id of remove product so to remove from session
      var product_id = $(this).children(".remove-product").val();
      //moving to another file to remove this product from session
      $.ajax({
        url: "deleteCartProduct.php",
        method: "POST",
        data: {
          product_id: product_id
        },
        success: function(data) {
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
    $('.BUY').on('click', function() {
      $(this).siblings('.modal').addClass("add");
    })
    $('.close').on('click', function() {
      $(this).parent('.modal-content').parent('.modal').removeClass("add");
    })
  })