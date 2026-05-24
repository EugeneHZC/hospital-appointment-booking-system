$(document).ready(function () {
  let role = $("#role").val();

  if (role == "") {
    return;
  }

  function loadAdminPage() {
    // load the side navbar file from the components folder
    fetch("../../components/admin/side-nav.html")
      .then((response) => response.text())
      .then((data) => {
        // add the side navbar into the container
        $("#container").append(data);

        // after the side navbar is loaded, update the navbar's active nav
        updateActiveNav();
      });

    // show the current role of this user in the header part
    $("#role-view").html("Admin's View");
  }

  function loadDoctorPage() {
    // load the side navbar file from the components folder
    fetch("../../components/doctor/side-nav.html")
      .then((response) => response.text())
      .then((data) => {
        // add the side navbar into the container
        $("#container").append(data);

        // after the side navbar is loaded, update the navbar's active nav
        updateActiveNav();
      });

    // show the current role of this user in the header part
    $("#role-view").html("Doctor's View");
  }

  function loadPatientPage() {
    // load the side navbar file from the components folder
    fetch("../../components/patient/side-nav.html")
      .then((response) => response.text())
      .then((data) => {
        // add the side navbar into the container
        $("#container").append(data);

        // after the side navbar is loaded, update the navbar's active nav
        updateActiveNav();
      });

    // show the current role of this user in the header part
    $("#role-view").html("Patient's View");
  }

  function updateActiveNav() {
    // gets the current page of the website
    let currentPage = window.location.href.split("/").pop();

    // gets all the links in the side nav
    let navLinks = $("#nav-content .nav-links .nav-link");

    // loops through all the links (<li> tag)
    navLinks.each(function () {
      // gets the <a> tag in the <li> tag
      let currentLink = $(this).find("a");

      // gets the href from the <a> tag and gets the path for that <a> tag
      // ex: http://127.0.0.1:5500/pages/patient/appointments.html -> appointments.html
      let currentFilePath = currentLink.attr("href").split("/").pop();

      // if the <a> tag href path is the same as the current web page path
      if (currentFilePath == currentPage) {
        // make it as active link (indicating user is currently in this page)
        $(this).addClass("active-link");
      }
    });
  }

  switch (role) {
    case "admin":
      loadAdminPage();
      break;
    case "doctor":
      loadDoctorPage();
      break;
    case "patient":
      loadPatientPage();
      break;
    default:
      break;
  }
});
