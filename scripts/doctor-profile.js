$(document).ready(function() {
  let doctorData = {};
  let selectedFile = null;

  // Fetch profile data from database
  function loadProfileFromDatabase() {
    $.ajax({
      url: '../../helper/get_profile_data.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          doctorData = response;
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
    
    if (doctorData.profile_picture && doctorData.profile_picture.trim() !== '') {
      // Display actual profile picture
      displayElement.css('background-image', `url('../../${doctorData.profile_picture}')`).css('background-size', 'cover').text('');
      previewElement.css('background-image', `url('../../${doctorData.profile_picture}')`).css('background-size', 'cover').text('');
    } else {
      // Display initials
      let initials = doctorData.name ? doctorData.name.split(" ").map((n) => n[0]).join("") : "D";
      displayElement.text(initials.substring(0, 2)).css('background-image', 'none');
      previewElement.text(initials.substring(0, 2)).css('background-image', 'none');
    }
  }

  function loadProfile() {
    displayProfileAvatar();
    $("#profile-name").text(doctorData.name || "Doctor Name");
    $("#display-name").text(doctorData.name || "Doctor Name");
    $("#display-email").text(doctorData.email || "—");
    $("#display-phone").text(doctorData.phone || "—");
    $("#display-bio").text(doctorData.bio || "—");
  }

  function populateEditForm() {
    $("#edit-fullname").val(doctorData.name || "");
    $("#edit-email").val(doctorData.email || "");
    $("#edit-phone").val(doctorData.phone || "");
    $("#edit-bio").val(doctorData.bio || "");
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
          doctorData.profile_picture = response.imageUrl;
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
    doctorData.name = $("#edit-fullname").val();
    doctorData.email = $("#edit-email").val();
    doctorData.phone = $("#edit-phone").val();
    doctorData.bio = $("#edit-bio").val();

    // Save to database
    $.ajax({
      url: '../../helper/update_profile.php',
      method: 'POST',
      data: {
        name: doctorData.name,
        email: doctorData.email,
        phone: doctorData.phone,
        bio: doctorData.bio || '',
        profile_picture: doctorData.profile_picture || ''
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

  $("#edit-btn").click(function() {
    populateEditForm();
    $("#view-section").hide();
    $(".edit-section").addClass("active");
  });

  $("#cancel-btn").click(function() {
    selectedFile = null;
    $("#profile-picture-input").val('');
    $("#view-section").show();
    $(".edit-section").removeClass("active");
  });

  $("#save-btn").click(uploadProfilePicture);

  loadProfileFromDatabase();
});