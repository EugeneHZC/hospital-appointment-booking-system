<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];

$appointmentId = $_GET["appointment_id"];

if ($role == "Patient") {
  $stmt = $conn->prepare("SELECT * FROM appointment
  JOIN time_slot
  USING (time_slot_id)
  JOIN staff
  ON appointment.staff_id = staff.staff_id
  WHERE appointment.appointment_id = ?");
} else {
  $stmt = $conn->prepare("SELECT * FROM appointment as a
  JOIN time_slot as ts
  USING (time_slot_id)
  JOIN patient as p
  USING (patient_id)
  WHERE a.appointment_id = ?");
}

$stmt->bind_param("s", $appointmentId);
$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
  echo "
        <script>
            alert('Failed to fetch departments. Error: $conn->error');
            window.location='appointments.php';
        </script>
        ";
  exit();
}

if ($result->num_rows > 0) {
  $appointment = $result->fetch_assoc();
  ?>
  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <script src="../../scripts/appointments.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System - Appointment Details</title>
  </head>

  <body>
    <div id="container">
      <?php include("../../components/side-nav.php") ?>
      <main>
        <header>
          <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
          <div>
            <h1>Appointment Details</h1>
            <p id="role-view"><?php echo $role; ?>'s View</p>
          </div>
        </header>

        <div id="content">
          <div id="user-info-card" class="card">
            <h3>
              <img src="<?php echo $appointment["profile_picture"] ?? "../../images/circle-user-solid-full.svg"; ?>" alt="Profile Picture" class="text-sm appointment-details-profile-picture">
              <?php echo $appointment["name"]; ?>
              <i class="fa-solid fa-<?php echo $appointment['gender'] == 'M' ? 'mars' : 'venus'; ?> text-<?php echo $appointment['gender'] == 'M' ? 'male-blue' : 'female-pink'; ?>"></i>
            </h3>
            <div id="user-sub-info">
              <p class="text-gray"><i class="fa-solid fa-envelope"></i><?php echo $appointment["email"]; ?></p>
              <p class="text-gray"><i class="fa-solid fa-phone"></i><?php echo $appointment["phone_no"]; ?></p>
              <?php
              if ($role != "Patient") {
                echo "<p class='text-gray'><i class='fa-solid fa-id-card'></i>" . $appointment["ic_number"] . "</p>";
                echo "<p class='text-gray'><i class='fa-solid fa-calendar'></i>" . $appointment["date_of_birth"] . "</p>";
                echo "<p class='text-gray span-4'><i class='fa-solid fa-house'></i>" . $appointment["address"] . "</p>";
              } else {
                echo "<p class='text-gray'><i class='fa-solid fa-id-card'></i>" . $appointment["specialty"] . "</p>";
                echo "<p class='text-gray span-4'><i class='fa-solid fa-book'></i>" . $appointment["bio"] . "</p>";
              }
              ?>
            </div>
          </div>


          <div id="user-info-card" class="card">
            <h3><?php echo $appointment["appointment_type"]; ?></h3>
            <div id="user-sub-info">
              <p class="text-gray">
                <i class="fa-solid fa-calendar"></i><?php echo $appointment["date"]; ?>
              </p>
              <p class="text-gray">
                <i class="fa-solid fa-clock"></i><?php echo $appointment["time"]; ?>
              </p>
            </div>
          </div>

          <form id="remarks-form" action="update_appointment.php" method="post">
            <input type="hidden" name="appointment_id" value="<?php echo $appointment["appointment_id"]; ?>" />
            <div class="display-cards">
              <div class="display-card-top-bottom card">
                <div class="display-card-top">
                  <h3>Remarks from Patient</h3>
                </div>
                <br />
                <div class="display-card-bottom">
                  <textarea name="patient_remark" id="patient-remark" class="form-control" rows="5" <?php echo $role == "Patient" ? "" : "disabled"; ?>
                    placeholder="Write medical remarks, diagnosis, or notes here..."><?php echo $appointment["patient_remark"] ?></textarea>
                </div>
              </div>

              <div class="display-card-top-bottom card">
                <div class="display-card-top">
                  <h3>Doctor Remarks</h3>
                </div>
                <br />
                <div class="display-card-bottom">
                  <textarea name="doctor_remark" id="doctor-remark" class="form-control" rows="5" <?php echo $role == "Patient" ? "disabled" : ""; ?>
                    placeholder="Write medical remarks, diagnosis, or notes here..."><?php echo $appointment["doctor_remark"] ?></textarea>
                  <small class="text-gray" id="remarks-hint">Remarks will be saved and visible to the patient and doctor.</small>
                </div>
              </div>

              <div class="display-card-top-bottom card">
                <div class="display-card-top">
                  <h3>Current Appointment Status</h3>
                </div>
                <br>
                <div class="display-card-bottom">
                  <select name="appointment_status" id="appointment-status" class="form-control" <?php echo $role == "Patient" ? "disabled" : ""; ?>>
                    <option value="Scheduled" <?php echo $appointment["status"] == "Scheduled" ? "selected" : ""; ?>>Scheduled</option>
                    <option value="Completed" <?php echo $appointment["status"] == "Completed" ? "selected" : ""; ?>>Completed</option>
                    <option value="Cancelled" <?php echo $appointment["status"] == "Cancelled" ? "selected" : ""; ?>>Cancelled</option>
                  </select>
                </div>
              </div>

              <div class="display-card-top-bottom card">
                <div class="display-card-top">
                  <h3>Follow-up Appointment</h3>
                </div>

                <br />

                <div class="display-card-bottom">
                  <div class="row">
                    <?php
                    $followUpAppointmentId = $appointment["follow_up_appointment_id"];
                    $sql = "SELECT * FROM appointment WHERE appointment_id = '$followUpAppointmentId'";
                    $followUpAppointmentResult = $conn->query($sql);
                    $followUpAppointment = $followUpAppointmentResult->fetch_assoc();
                    ?>

                    <div class="form-group">
                      <label for="appointment_date">Appointment Date</label>
                      <input type="date" class="form-control" name="date" id="date" min="<?php echo Date('Y-m-d'); ?>" <?php echo $role == "Patient" ? "disabled" : ""; ?>
                        value="<?php echo (isset($followUpAppointment) ? $followUpAppointment['date'] : ''); ?>" />
                    </div>

                    <div class="form-group">
                      <label for="appointment_time">Appointment Time</label>
                      <select name="time" id="time" class="form-control" <?php echo $role == "Patient" ? "disabled" : ""; ?> data-staffid="<?php echo $appointment["staff_id"]; ?>"
                        data-timeslot="<?php echo $followUpAppointment["time_slot_id"]; ?>" data-appointmentid="<?php echo $followUpAppointmentId ?>">
                        <option value="" disabled selected>Select a time slot</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="text-center">
              <button class="btn btn-secondary" type="button" id="cancel-btn">
                Cancel
              </button>
              <button type="submit" class="btn btn-info" id="save-remarks-btn">
                <i class="fa-solid fa-save"></i> Save
              </button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </body>

  </html>

  <?php
} else {
  echo "
        <script>
            alert('Appointment not found.');
            window.location='appointments.php';
        </script>
        ";
  exit();
}
?>