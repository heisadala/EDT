$(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $(".edt-back-to-top").fadeIn("slow");
    } else {
      $(".edt-back-to-top").fadeOut("slow");
    }
  });
  $(".edt-back-to-top").click(function() {
    $("html, body").animate({ scrollTop: 0 }, 1500);
    return false;
  });
