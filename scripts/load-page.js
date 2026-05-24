$(document).ready(function () {
  let role = $("#role").val();

  if (role == "") {
    return;
  }

  switch (role) {
    case "admin":
      fetch("../../components/admin/side-nav.html")
        .then((response) => response.text())
        .then((data) => {
          $("#container").append(data);
        });

      $("#role-view").html("Admin's View");
      break;
    case "doctor":
      fetch("../../components/doctor/side-nav.html")
        .then((response) => response.text())
        .then((data) => {
          $("#container").append(data);
        });

      $("#role-view").html("Doctor's View");
      break;
    case "patient":
      fetch("../../components/patient/side-nav.html")
        .then((response) => response.text())
        .then((data) => {
          $("#container").append(data);
        });

      $("#role-view").html("Patient's View");
      break;
    default:
      break;
  }
});
