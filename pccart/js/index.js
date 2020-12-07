window.addEventListener("load", function () {
  new Glider(document.querySelector(".glider"), {
    slidesToShow: 1,
    slidesToScroll: "auto",
    draggable: true,
    dots: ".dots",
    duration: 0.5,
    itemWidth: 200,
    scrollLock: true,
    arrows: {
      prev: ".glider-prev",
      next: ".glider-next",
    },
    responsive: [
      {
        // screens greater than >= 775px
        breakpoint: 225,
        settings: {
          // Set to `auto` and provide item width to adjust to viewport
          slidesToShow: 1,
          slidesToScroll: "auto",
          itemWidth: 150,
          duration: 1,
        },
      },
      {
        // screens greater than >= 775px
        breakpoint: 775,
        settings: {
          // Set to `auto` and provide item width to adjust to viewport
          slidesToShow: 1.5,
          slidesToScroll: "auto",
          itemWidth: 150,
          duration: 1,
        },
      },
      {
        // screens greater than >= 1024px
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: "auto",
          itemWidth: 150,
          duration: 1,
        },
      },
      {
        // screens greater than >= 1024px
        breakpoint: 1800,
        settings: {
          slidesToShow: 2.5,
          slidesToScroll: "auto",
          itemWidth: 150,
          duration: 0.25,
        },
      },
    ],
  });
});
ScrollOut({
  threshold: 0.5,
});
$(document).ready(function () {
  $(".dropdown").on("click", function () {
    $(this).siblings(".dropdown-content").toggleClass("show");
  });
  $(".menu_icon button").click(function () {
    $("nav .ul-pc").toggleClass("activex");
  });
});
