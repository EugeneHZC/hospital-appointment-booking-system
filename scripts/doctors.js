$(document).ready(function () {
  $("#search-bar").change(function () {
    let search = $(this).val().trim().toLowerCase();

    $(".display-card-left-right").each(function () {
      let departmentName = $(this).data("departmentname").toLowerCase();
      let staffName = $(this).data("name").toLowerCase();
      let gender = $(this).data("gender").toLowerCase();
      let specialty = $(this).data("specialty").toLowerCase();

      if (
        departmentName.includes(search) ||
        staffName.includes(search) ||
        gender.includes(search) ||
        specialty.includes(search)
      ) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
});
