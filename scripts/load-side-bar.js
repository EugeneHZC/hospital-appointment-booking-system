$(document).ready(function () {
  let dashboard = $("#dashboard");
  let timeSlots = $("#time-slots");
  let departments = $("#departments");
  let doctors = $("#doctors");
  let role = $("#role").val();

  if (role == "doctor") {
    dashboard.removeClass("hide");
    timeSlots.removeClass("hide");
  } else if (role == "admin") {
    dashboard.removeClass("hide");
    timeSlots.removeClass("hide");
    departments.removeClass("hide");
    doctors.removeClass("hide");
  }
});
