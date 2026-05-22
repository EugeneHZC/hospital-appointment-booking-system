$(document).ready(function () {
  $("#appointments-horizontal-nav ul li").click(function (e) {
    e.preventDefault();

    $(this)
      .siblings()
      .each(function (i, e) {
        e.classList.remove("active-link");
      });
    $(this).addClass("active-link");
  });
});
