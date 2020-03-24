
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
