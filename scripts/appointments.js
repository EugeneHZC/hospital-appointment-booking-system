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
      url: "get_doctors.php",
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
});
