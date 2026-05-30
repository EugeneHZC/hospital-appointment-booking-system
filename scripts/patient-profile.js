$(document).ready(function() {
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
        bio: "Regular follow-up for asthma management. Prefers morning appointments."
      };

      function loadProfile() {
        let initials = patientData.fullName.split(' ').map(n => n[0]).join('');
        $(".profile-avatar").html(initials.substring(0,2));
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
        $("#display-insurance").text(`${patientData.insuranceProvider} - ${patientData.insuranceNumber}`);
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