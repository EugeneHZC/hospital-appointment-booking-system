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
    profileImage: null,
  };

  function displayProfileAvatar() {
    let displayElement = $("#profile-avatar-display");
    let previewElement = $("#edit-avatar-preview");
    
    if (adminData.profileImage) {
      // Display image
      displayElement.css("background-image", `url('${adminData.profileImage}')`);
      displayElement.text("");
      previewElement.css("background-image", `url('${adminData.profileImage}')`);
      previewElement.text("");
    } else {
      // Display initials
      let initials = adminData.fullName
        .split(" ")
        .map((n) => n[0])
        .join("");
      displayElement.text(initials.substring(0, 2));
      previewElement.text(initials.substring(0, 2));
    }
  }

  function loadProfile() {
    displayProfileAvatar();
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
    displayProfileAvatar();
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

  function handleImageUpload(file) {
    // Validate file
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (!allowedTypes.includes(file.type)) {
      alert("Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.");
      return;
    }

    if (file.size > maxSize) {
      alert("File size exceeds 5MB limit.");
      return;
    }

    // Create FormData for upload
    const formData = new FormData();
    formData.append("profileImage", file);

    // Show loading state
    let uploadBtn = $("#upload-btn");
    let originalText = uploadBtn.html();
    uploadBtn.html("<i class='fa-solid fa-spinner fa-spin'></i> Uploading...").prop("disabled", true);

    // Upload file
    $.ajax({
      url: "../../helper/upload_profile_image.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          adminData.profileImage = response.imageUrl;
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

  // Event listeners
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
