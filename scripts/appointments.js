$(document).ready(function () {
  // used for the horizontal nav for different appointment status
  $("#appointments-horizontal-nav ul li").click(function (e) {
    e.preventDefault();

    $(this)
      .siblings()
      .each(function (index, element) {
        element.classList.remove("active-link");
      });

    $(this).addClass("active-link");
  });

  $(".view-details-btn").click(function () {
    location.href = "appointment-details.php";
  });

  $("#save-remarks-btn").click(function (e) {
    e.preventDefault();
    
    let remarks = $("#remarks").val();
    let followupDate = $("#appointment-date").val();
    let followupTime = $("#appointment-time").val();
    
    if (!remarks.trim()) {
      alert("Please enter remarks before saving.");
      return;
    }
    
    let role = $("#role").val();
    
    let appointmentData = {
      remarks: remarks,
      followupDate: followupDate,
      followupTime: followupTime,
      updatedBy: role,
      updatedAt: new Date().toISOString()
    };
    
    let appointmentId = new URLSearchParams(window.location.search).get('id') || '1';
    localStorage.setItem(`appointment_${appointmentId}_remarks`, JSON.stringify(appointmentData));
    
    alert("Remarks saved successfully!");
  });

  function loadExistingRemarks() {
    let appointmentId = new URLSearchParams(window.location.search).get('id') || '1';
    let savedData = localStorage.getItem(`appointment_${appointmentId}_remarks`);
    
    if (savedData) {
      let data = JSON.parse(savedData);
      $("#remarks").val(data.remarks);
      if (data.followupDate) $("#appointment-date").val(data.followupDate);
      if (data.followupTime) $("#appointment-time").val(data.followupTime);
    }
  }
  
  if (window.location.pathname.includes("appointment-details.html")) {
    loadExistingRemarks();
  }
  
  $("#cancel-btn, #back-btn").click(function (e) {
    e.preventDefault();
    window.location.href = "appointments.html";
  });
});