///////////  for applying filter only on clicking apply button

//this script is meant for add to cart and buy now
$(document).ready(function () {
   // onclink apply
   $('.buyBtn').click(add_to_cart);
   $('.buyBtn').click(function(){
   window.location.href='cart.php';
   })

   $('.cartBtn').click(add_to_cart);

   function add_to_cart(){

     var product_id =$(this).val();
     $.ajax({
           url:"addToCart.php",
           method:"POST",
           data:{   product_id:product_id
                },
           success:function(data){
             $('.alert').html(data);
           }
     });
   };
});
