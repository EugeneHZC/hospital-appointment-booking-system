$(document).ready(function () {
  // Get profile data from the hidden input
  let profileDataJSON = document.getElementById('profile-json').value;
  let profileData = JSON.parse(profileDataJSON);
  let role = document.getElementById('role').value;

  function loadProfile() {
    let initials = profileData.name
      .split(" ")
      .map((n) => n[0])
      .join("");
    
    // Display profile picture or initials
    let avatarElement = $(".profile-avatar");
    avatarElement.empty(); // Clear any existing content
    
    if (profileData.profile_picture && profileData.profile_picture !== 'null' && profileData.profile_picture !== '') {
      let img = document.createElement('img');
      img.src = '../../images/profile_pictures/' + profileData.profile_picture;
      img.alt = 'Profile Picture';
      
      // If image fails to load, show initials instead
      img.onerror = function() {
        avatarElement.html(initials.substring(0, 2));
      };
      
      avatarElement.append(img);
    } else {
      // Show initials if no profile picture
      avatarElement.html(initials.substring(0, 2));
    }
    
    $("#profile-name").text(profileData.name || "N/A");
    $("#profile-role").text(role);
    $("#display-email").text(profileData.email || "N/A");
    $("#display-phone").text(profileData.phone && profileData.phone !== 'null' ? profileData.phone : "N/A");
    
    if (role === 'Patient' && profileData.date_of_birth && profileData.date_of_birth !== 'null') {
      let dobDate = new Date(profileData.date_of_birth);
      let formattedDate = dobDate.toLocaleDateString('en-GB');
      $("#display-dob").text(formattedDate);
    }
    
    if (profileData.specialty && profileData.specialty !== 'null') {
      $("#display-specialty").text(profileData.specialty);
    }
    if (profileData.department && profileData.department !== 'null') {
      $("#display-department").text(profileData.department);
    }
    if (profileData.bio && profileData.bio !== 'null') {
      $("#display-bio").text(profileData.bio);
    }
  }

  function populateEditForm() {
    $("#edit-fullname").val(profileData.name);
    $("#edit-email").val(profileData.email);
    $("#edit-phone").val(profileData.phone || "");
    if ($("#edit-dob").length && profileData.date_of_birth) {
      $("#edit-dob").val(profileData.date_of_birth);
    }
    if ($("#edit-specialty").length) {
      $("#edit-specialty").val(profileData.specialty || "");
    }
    if ($("#edit-bio").length) {
      $("#edit-bio").val(profileData.bio || "");
    }
  }

  function saveChanges() {
    let updateData = {
      name: $("#edit-fullname").val(),
      phone: $("#edit-phone").val()
    };
    
    if ($("#edit-specialty").length) {
      updateData.specialty = $("#edit-specialty").val();
    }
    if ($("#edit-bio").length) {
      updateData.bio = $("#edit-bio").val();
    }

    // Send AJAX request to update database
    $.ajax({
      url: './update_profile.php',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(updateData),
      success: function(response) {
        // Update profileData with new values
        profileData.name = updateData.name;
        profileData.phone = updateData.phone;
        if (updateData.specialty !== undefined) {
          profileData.specialty = updateData.specialty;
        }
        if (updateData.bio !== undefined) {
          profileData.bio = updateData.bio;
        }
        
        loadProfile();
        $(".edit-section").removeClass("active");
        $("#view-section").show();
        alert("Profile updated successfully!");
      },
      error: function(xhr, status, error) {
        let errorMsg = 'Error updating profile';
        try {
          const response = JSON.parse(xhr.responseText);
          errorMsg = response.message || errorMsg;
        } catch (e) {
          // Response is not JSON
        }
        alert('Failed to update profile: ' + errorMsg);
      }
    });
  }

  function uploadProfilePicture(file) {
    let formData = new FormData();
    formData.append('profile_picture', file);

    $.ajax({
      url: './upload_profile_picture.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        let result = JSON.parse(response);
        if (result.success) {
          profileData.profile_picture = result.filename;
          loadProfile();
          $("#upload-status").html('<div class="alert alert-success">Profile picture uploaded successfully!</div>').delay(3000).fadeOut();
          $("#edit-profile-picture").val(''); // Clear the input
        } else {
          $("#upload-status").html('<div class="alert alert-danger">' + result.message + '</div>');
        }
      },
      error: function(xhr, status, error) {
        let errorMsg = 'Error uploading profile picture';
        try {
          const response = JSON.parse(xhr.responseText);
          errorMsg = response.message || errorMsg;
        } catch (e) {
          // Response is not JSON
        }
        $("#upload-status").html('<div class="alert alert-danger">' + errorMsg + '</div>');
      }
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

  $("#edit-profile-picture").change(function() {
    let file = this.files[0];
    if (file) {
      uploadProfilePicture(file);
    }
  });

  loadProfile();
});
