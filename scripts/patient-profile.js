$(document).ready(function () {
  let patientData = {
    fullName: "Nurul Iman Binti Zainal",
    email: "nurul.iman@example.com",
    phone: "+6011 2345 6789",
    icNumber: "010101-10-1234",
    dateOfBirth: "01 January 2001",
    bloodType: "O+",
    emergencyContact: "Ahmed Zainal (+6012 345 6780)",
    emergencyRelation: "Father",
    address: "No 8, Jalan Mawar, Taman Cempaka, 50450 Kuala Lumpur",
    allergies: "Penicillin, Dust mites",
    primaryDoctor: "Dr. Ahmad Fauzi Bin Abdullah",
    medicalHistory: "Asthma (diagnosed 2015), No major surgeries",
    insuranceProvider: "AIA Insurance",
    insuranceNumber: "AIA-87654321",
    bio: "Regular follow-up for asthma management. Prefers morning appointments.",
    profileImage: null,
  };

  function displayProfileAvatar() {
    let displayElement = $("#profile-avatar-display");
    let previewElement = $("#edit-avatar-preview");
    
    if (patientData.profileImage) {
      displayElement.css("background-image", `url('${patientData.profileImage}')`);
      displayElement.text("");
      previewElement.css("background-image", `url('${patientData.profileImage}')`);
      previewElement.text("");
    } else {
      let initials = patientData.fullName.split(" ").map((n) => n[0]).join("");
      displayElement.text(initials.substring(0, 2));
      previewElement.text(initials.substring(0, 2));
    }
  }

  function loadProfile() {
    displayProfileAvatar();
    $("#profile-name").text(patientData.fullName);
    $("#display-name").text(patientData.fullName);
    $("#display-email").text(patientData.email);
    $("#display-phone").text(patientData.phone);
    $("#display-ic").text(patientData.icNumber);
    $("#display-dob").text(patientData.dateOfBirth);
    $("#display-blood").text(patientData.bloodType);
    $("#display-emergency").text(patientData.emergencyContact);
    $("#display-emergencyRelation").text(patientData.emergencyRelation);
    $("#display-address").text(patientData.address);
    $("#display-allergies").text(patientData.allergies);
    $("#display-primaryDoctor").text(patientData.primaryDoctor);
    $("#display-medicalHistory").text(patientData.medicalHistory);
    $("#display-insurance").text(
      `${patientData.insuranceProvider} - ${patientData.insuranceNumber}`,
    );
    $("#display-bio").text(patientData.bio);
  }

  function populateEditForm() {
    $("#edit-fullname").val(patientData.fullName);
    $("#edit-email").val(patientData.email);
    $("#edit-phone").val(patientData.phone);
    $("#edit-address").val(patientData.address);
    $("#edit-emergencyContact").val(patientData.emergencyContact);
    $("#edit-allergies").val(patientData.allergies);
    $("#edit-bio").val(patientData.bio);
    $("#edit-ic").val(patientData.icNumber);
    displayProfileAvatar();
  }

  function saveChanges() {
    patientData.fullName = $("#edit-fullname").val();
    patientData.email = $("#edit-email").val();
    patientData.phone = $("#edit-phone").val();
    patientData.address = $("#edit-address").val();
    patientData.emergencyContact = $("#edit-emergencyContact").val();
    patientData.allergies = $("#edit-allergies").val();
    patientData.bio = $("#edit-bio").val();

    loadProfile();
    $(".edit-section").removeClass("active");
    $("#view-section").show();
    alert("Profile updated successfully!");
  }

  function handleImageUpload(file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 5 * 1024 * 1024;

    if (!allowedTypes.includes(file.type)) {
      alert("Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.");
      return;
    }

    if (file.size > maxSize) {
      alert("File size exceeds 5MB limit.");
      return;
    }

    const formData = new FormData();
    formData.append("profileImage", file);

    let uploadBtn = $("#upload-btn");
    let originalText = uploadBtn.html();
    uploadBtn.html("<i class='fa-solid fa-spinner fa-spin'></i> Uploading...").prop("disabled", true);

    $.ajax({
      url: "../../helper/upload_profile_image.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          patientData.profileImage = response.imageUrl;
          displayProfileAvatar();
          alert("Profile picture updated successfully!");
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("An error occurred while uploading the file.");
      },
      complete: function () {
        uploadBtn.html(originalText).prop("disabled", false);
      },
    });
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

  $("#upload-btn").click(function () {
    $("#profile-image-input").click();
  });

  $("#edit-avatar-btn").click(function () {
    $("#profile-image-input").click();
  });

  $("#change-avatar-btn").click(function (e) {
    e.preventDefault();
    $("#profile-image-input").click();
  });

  $("#profile-image-input").change(function () {
    const file = this.files[0];
    if (file) {
      handleImageUpload(file);
    }
  });

  loadProfile();
});
