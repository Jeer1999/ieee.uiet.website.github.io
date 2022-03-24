jQuery(document).ready(function ($) {
  travel_ocean_slick_slider()

  function travel_ocean_slick_slider() {
    $(".slider").slick({
      lazyLoad: 'ondemand', // ondemand progressive anticipated
      infinite: true
    });
  }

  $('.grid-slider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    centerPadding: '40px',
    slidesToScroll: 1,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 700,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });
  /**
   * =========================
   * Accessibility codes start
   * =========================
   */
  $(document).on('mousemove', 'body', function (e) {
    $(this).removeClass('keyboard-nav-on');
  });
  $(document).on('keydown', 'body', function (e) {
    if (e.which == 9) {
      $(this).addClass('keyboard-nav-on');
    }
  });

})