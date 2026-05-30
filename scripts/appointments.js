$(document).ready(function () {
  // used for the horizontal nav for different appointment status
  $("#appointments-horizontal-nav ul li").click(function (e) {
    e.preventDefault();

    $(this)
      .siblings()
      .each(function (index, element) {
        element.classList.remove("active-link");
      });

    $(this).addClass("active-link");
  });

  $(".view-details-btn").click(function () {
    location.href = "appointment-details.php";
  });
});
