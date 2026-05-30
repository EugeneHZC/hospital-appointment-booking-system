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
        bio: "Specialised in pediatric cardiology and neonatal intensive care. Passionate about community health outreach."
      };

      function loadProfile() {
        let initials = doctorData.fullName.split(' ').map(n => n[0]).join('');
        $(".profile-avatar").html(initials.substring(0,2));
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

      loadProfile();
    });