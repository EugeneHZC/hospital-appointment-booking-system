$(document).ready(function () {
  let adminData = {
    fullName: "Dr. Aisyah Binti Hassan",
    role: "Head of Paediatrics Department",
    email: "aisyah.hassan@azzahrah.my",
    phone: "+6012 345 6789",
    department: "Paediatrics",
    joinDate: "15 March 2018",
    officeLocation: "Administration Wing, Level 3",
    bio: "Senior consultant with 12+ years experience in paediatric care. Leads medical education and hospital administration.",
  };

  function loadProfile() {
    let initials = adminData.fullName
      .split(" ")
      .map((n) => n[0])
      .join("");
    $(".profile-avatar").html(initials.substring(0, 2));
    $("#profile-name").text(adminData.fullName);
    $("#profile-role").text(adminData.role);
    $("#display-name").text(adminData.fullName);
    $("#display-email").text(adminData.email);
    $("#display-phone").text(adminData.phone);
    $("#display-department").text(adminData.department);
    $("#display-joinDate").text(adminData.joinDate);
    $("#display-office").text(adminData.officeLocation);
    $("#display-bio").text(adminData.bio);
  }

  function populateEditForm() {
    $("#edit-fullname").val(adminData.fullName);
    $("#edit-email").val(adminData.email);
    $("#edit-phone").val(adminData.phone);
    // $("#edit-department").val(adminData.department);
    $("#edit-office").val(adminData.officeLocation);
    $("#edit-bio").val(adminData.bio);
  }

  function saveChanges() {
    adminData.fullName = $("#edit-fullname").val();
    adminData.email = $("#edit-email").val();
    adminData.phone = $("#edit-phone").val();
    // adminData.department = $("#edit-department").val();
    adminData.officeLocation = $("#edit-office").val();
    adminData.bio = $("#edit-bio").val();

    loadProfile();
    $(".edit-section").removeClass("active");
    $("#view-section").show();
    alert("Profile updated successfully!");
  }

  $("#edit-btn").click(function () {
    populateEditForm();
    $("#view-section").hide();
    $(".edit-section").addClass("active");
  });

  $("#cancel-btn").click(function () {
    $("#view-section").show();
    $(".edit-section").removeClass("active");
  });

  $("#save-btn").click(saveChanges);

  loadProfile();
});
