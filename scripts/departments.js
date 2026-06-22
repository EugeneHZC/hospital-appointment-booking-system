$(document).ready(function () {
  $("#search-bar").change(function () {
    let search = $(this).val().trim().toLowerCase();

    $(".display-card-left-right").each(function () {
      let departmentName = $(this).data("departmentname").toLowerCase();
      let location = $(this).data("location").toLowerCase();
      let description = $(this).data("description").toLowerCase();

      if (
        departmentName.includes(search) ||
        location.includes(search) ||
        description.includes(search)
      ) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
});
