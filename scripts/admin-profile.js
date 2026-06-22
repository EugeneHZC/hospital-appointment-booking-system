$(document).ready(function () {
  let adminData = {};
  let selectedFile = null;

  // Fetch profile data from database
  function loadProfileFromDatabase() {
    $.ajax({
      url: '../../helper/get_profile_data.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          adminData = response;
          loadProfile();
        } else {
          console.error('Failed to load profile:', response.message);
        }
      },
      error: function(error) {
        console.error('Error loading profile:', error);
      }
    });
  }

  function displayProfileAvatar() {
    let displayElement = $("#profile-avatar-display");
    let previewElement = $("#profile-avatar-preview");
    
    if (adminData.profile_picture && adminData.profile_picture.trim() !== '') {
      // Display actual profile picture
      displayElement.css('background-image', `url('../../${adminData.profile_picture}')`).css('background-size', 'cover').text('');
      previewElement.css('background-image', `url('../../${adminData.profile_picture}')`).css('background-size', 'cover').text('');
    } else {
      // Display initials
      let initials = adminData.name ? adminData.name.split(" ").map((n) => n[0]).join("") : "A";
      displayElement.text(initials.substring(0, 2)).css('background-image', 'none');
      previewElement.text(initials.substring(0, 2)).css('background-image', 'none');
    }
  }

  function loadProfile() {
    displayProfileAvatar();
    $("#profile-name").text(adminData.name || "Admin Name");
    $("#display-name").text(adminData.name || "Admin Name");
    $("#display-email").text(adminData.email || "—");
    $("#display-phone").text(adminData.phone || "—");
    $("#display-bio").text(adminData.bio || "—");
  }

  function populateEditForm() {
    $("#edit-fullname").val(adminData.name || "");
    $("#edit-email").val(adminData.email || "");
    $("#edit-phone").val(adminData.phone || "");
    $("#edit-office").val(adminData.office || "");
    $("#edit-bio").val(adminData.bio || "");
    displayProfileAvatar();
  }

  function uploadProfilePicture() {
    if (!selectedFile) {
      saveProfileChanges();
      return;
    }

    let formData = new FormData();
    formData.append('profileImage', selectedFile);

    $.ajax({
      url: '../../helper/upload_profile_image.php',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          adminData.profile_picture = response.imageUrl;
          saveProfileChanges();
        } else {
          alert('Failed to upload image: ' + response.message);
        }
      },
      error: function(error) {
        console.error('Upload error:', error);
        alert('Error uploading image');
      }
    });
  }

  function saveProfileChanges() {
    adminData.name = $("#edit-fullname").val();
    adminData.email = $("#edit-email").val();
    adminData.phone = $("#edit-phone").val();
    adminData.office = $("#edit-office").val();
    adminData.bio = $("#edit-bio").val();

    // Save to database
    $.ajax({
      url: '../../helper/update_profile.php',
      method: 'POST',
      data: {
        name: adminData.name,
        email: adminData.email,
        phone: adminData.phone,
        bio: adminData.bio || '',
        profile_picture: adminData.profile_picture || ''
      },
      success: function(response) {
        loadProfile();
        $(".edit-section").removeClass("active");
        $("#view-section").show();
        alert("Profile updated successfully!");
        selectedFile = null;
        $("#profile-picture-input").val('');
      },
      error: function(error) {
        console.error('Save error:', error);
      }
    });
  }

  // File input change handler
  $("#profile-picture-input").on('change', function(e) {
    selectedFile = e.target.files[0];
    if (selectedFile) {
      // Preview the image
      let reader = new FileReader();
      reader.onload = function(event) {
        $("#profile-avatar-preview").css('background-image', `url('${event.target.result}')`).css('background-size', 'cover').text('');
      };
      reader.readAsDataURL(selectedFile);
    }
  });

  // Event listeners
  $("#edit-btn").click(function () {
    populateEditForm();
    $("#view-section").hide();
    $(".edit-section").addClass("active");
  });

  $("#cancel-btn").click(function () {
    selectedFile = null;
    $("#profile-picture-input").val('');
    $("#view-section").show();
    $(".edit-section").removeClass("active");
  });

  $("#save-btn").click(uploadProfilePicture);

  loadProfileFromDatabase();
});
