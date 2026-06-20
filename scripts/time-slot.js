$(document).ready(function () {
  $("#add-time-slot-btn").click(function () {
    window.location.href = "add-time-slot.php";
  });

  $("#cancel-btn").click(function () {
    window.location.href = "time-slots.php";
  });

  $("#search-bar").change(function () {
    let searchKey = $(this).val().trim().toLowerCase();

    $(".display-card-left-right").each(function () {
      if ($(this).data("time").includes(searchKey)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
});
