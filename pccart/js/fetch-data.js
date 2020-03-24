///////////  for applying filter only on clicking apply button

$(document).ready(function () {
    // onclink apply
    $('.ApplyBtn').click(apply_filter);

    // to call apply filter on starting of the page
    apply_filter();

    function apply_filter()
    {
      var search_for =$('#searchText').val();
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


});
