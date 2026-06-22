$(document).ready(function() {
      let doctorData = {
        fullName: "Dr. Ahmad Fauzi Bin Abdullah",
        specialization: "Senior Paediatrician",
        email: "ahmad.fauzi@azzahrah.my",
        phone: "+6019 876 5432",
        department: "Paediatrics",
        experience: "9 years",
        clinicRoom: "Room C-204",
        consultationFee: "RM 150",
        education: "MD (UM), MRCPCH (UK)",
        languages: "English, Malay, Arabic",
        schedule: ["Monday 9AM-1PM", "Wednesday 2PM-5PM", "Friday 9AM-12PM"],
        bio: "Specialised in pediatric cardiology and neonatal intensive care. Passionate about community health outreach.",
        profileImage: null,
      };

      function displayProfileAvatar() {
        let displayElement = $("#profile-avatar-display");
        let previewElement = $("#edit-avatar-preview");
        
        if (doctorData.profileImage) {
          displayElement.css("background-image", `url('${doctorData.profileImage}')`);
          displayElement.text("");
          previewElement.css("background-image", `url('${doctorData.profileImage}')`);
          previewElement.text("");
        } else {
          let initials = doctorData.fullName.split(' ').map(n => n[0]).join('');
          displayElement.text(initials.substring(0,2));
          previewElement.text(initials.substring(0,2));
        }
      }

      function loadProfile() {
        displayProfileAvatar();
        $("#profile-name").text(doctorData.fullName);
        $("#profile-specialization").text(doctorData.specialization);
        $("#display-name").text(doctorData.fullName);
        $("#display-email").text(doctorData.email);
        $("#display-phone").text(doctorData.phone);
        $("#display-department").text(doctorData.department);
        $("#display-experience").text(doctorData.experience);
        $("#display-clinicRoom").text(doctorData.clinicRoom);
        $("#display-fee").text(doctorData.consultationFee);
        $("#display-education").text(doctorData.education);
        $("#display-languages").text(doctorData.languages);
        
        let scheduleHtml = "";
        doctorData.schedule.forEach(slot => {
          scheduleHtml += `<span class="schedule-tag"><i class="fa-regular fa-clock"></i> ${slot}</span>`;
        });
        $("#display-schedule").html(scheduleHtml);
        $("#display-bio").text(doctorData.bio);
      }

      function populateEditForm() {
        $("#edit-fullname").val(doctorData.fullName);
        $("#edit-email").val(doctorData.email);
        $("#edit-phone").val(doctorData.phone);
        $("#edit-experience").val(doctorData.experience);
        $("#edit-clinicRoom").val(doctorData.clinicRoom);
        $("#edit-fee").val(doctorData.consultationFee);
        $("#edit-bio").val(doctorData.bio);
        displayProfileAvatar();
      }

      function saveChanges() {
        doctorData.fullName = $("#edit-fullname").val();
        doctorData.email = $("#edit-email").val();
        doctorData.phone = $("#edit-phone").val();
        doctorData.experience = $("#edit-experience").val();
        doctorData.clinicRoom = $("#edit-clinicRoom").val();
        doctorData.consultationFee = $("#edit-fee").val();
        doctorData.bio = $("#edit-bio").val();
        
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
              doctorData.profileImage = response.imageUrl;
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

      $("#edit-btn").click(function() {
        populateEditForm();
        $("#view-section").hide();
        $(".edit-section").addClass("active");
      });

      $("#cancel-btn").click(function() {
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