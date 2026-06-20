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

  $("#cancel-btn, #back-btn").click(function () {
    window.location.href = "appointments.php";
  });

  // if patient clicks on the book appointment button
  $("#book-appointment-btn").click(function () {
    window.location.href = "book-appointment.php";
  });

  $("#department").change(function () {
    let doctorDropdown = $("#doctor");
    doctorDropdown.empty();
    doctorDropdown.append(
      "<option value='' selected disabled>Select a doctor</option>",
    );

    $.ajax({
      type: "GET",
      url: "../../helper/get_doctors.php",
      data: {
        department_id: $(this).val(),
      },
      success: function (response) {
        let doctors = JSON.parse(response);

        doctors.forEach((doctor) => {
          doctorDropdown.append(
            "<option value='" +
              doctor["staff_id"] +
              "'>" +
              doctor["name"] +
              "</option>",
          );
        });
      },
    });
  });

  $("#doctor").change(function () {
    $("#date").val("");
    $("#date").trigger("change");
  });

  $("#date").change(function () {
    let timeSlotDropdown = $("#time");
    timeSlotDropdown.empty();
    timeSlotDropdown.append(
      "<option value='' selected disabled>Select a time slot</option>",
    );

    if ($(this).val() == "") {
      return;
    }

    let selectedDate = new Date($(this).val());

    $.ajax({
      type: "GET",
      url: "get_time_slots.php",
      data: {
        staff_id: $("#doctor").val(),
        selected_date: selectedDate.toISOString().split("T")[0],
      },
      success: function (response) {
        let timeSlots = JSON.parse(response);
        timeSlots.forEach((timeSlot) => {
          timeSlotDropdown.append(
            "<option value='" +
              timeSlot["time_slot_id"] +
              "'>" +
              timeSlot["time"] +
              "</option>",
          );
        });
      },
    });
  });

  function filterAppointments(status) {
    $(".display-card-left-right").each(function () {
      if ($(this).data("status") == status || status == "") {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }

  filterAppointments("");

  $("#appointments-horizontal-nav .nav-links .nav-link").click(function () {
    // filter appointments based on horizontal nav
    let statusSelected = $(this).data("status");
    filterAppointments(statusSelected);
  });

  $("#appointments-status-dropdown").change(function () {
    // filter appointments based on status filter dropdown (for smaller devices)
    let statusSelected = $(this).val();
    filterAppointments(statusSelected);
  });

  $("#cancel-appointment-btn").click(function () {
    if (confirm("Are you sure you want to cancel this appointment?")) {
      $.ajax({
        type: "POST",
        url: "cancel_appointment.php",
        data: {
          appointment_id: $(this).data("id"),
        },
        success: function (response) {
          alert(JSON.parse(response));
          window.location.reload();
        },
      });
    }
  });
});
