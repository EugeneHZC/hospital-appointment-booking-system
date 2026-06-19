<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];
$tableName = strtolower($role) == "patient" ? strtolower($role) : "staff";

$sql = "SELECT * FROM $tableName WHERE email = '$email'";

$result = $conn->query($sql);

if (!$result) {
  die("Failed to get user info. Error: $conn->error");
}

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
  ?>

  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <script src="../../scripts/appointments.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System - Appointments</title>
  </head>

  <body>
    <div id="container">
      <?php include("../../components/side-nav.php") ?>
      <main>
        <header>
          <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
          <div>
            <h1>Appointments</h1>
            <p id="role-view"><?php echo "$role's view" ?></p>
          </div>
        </header>

        <div id="content">
          <div id="user-info-card" class="card">
            <h3><?php echo $user["name"]; ?></h3>
            <div id="user-sub-info">
              <p><i class="fa-solid fa-envelope"></i><?php echo $user["email"]; ?></p>
              <p><i class="fa-solid fa-phone"></i><?php echo $user["phone_no"]; ?></p>
              <?php
              if ($role == "Patient") {
                echo "<p><i class='fa-solid fa-id-card'></i>" . $user["ic_number"] . "</p>";
              } else {
                echo "<p><i class='fa-solid fa-id-card'></i>" . $user["specialty"] . "</p>";
              }
              ?>
            </div>
          </div>

          <?php
          // get statistics for booking
          $userId = $user[$tableName . "_id"];
          $totalAppointments = 0;
          $scheduledAppointments = 0;
          $completedAppointments = 0;
          $cancelledAppointments = 0;

          // total appointments
          $sql = "SELECT COUNT(*) AS total_appointments FROM appointment WHERE " . $tableName . "_id = '$userId'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalAppointments = $row["total_appointments"];
          }

          // scheduled appointments
          $sql = "SELECT COUNT(*) AS scheduled_appointments FROM appointment WHERE " . $tableName . "_id = '$userId' AND status = 'Scheduled'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $scheduledAppointments = $row["scheduled_appointments"];
          }

          // completed appointments
          $sql = "SELECT COUNT(*) AS completed_appointments FROM appointment WHERE " . $tableName . "_id = '$userId' AND status = 'Completed'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $completedAppointments = $row["completed_appointments"];
          }

          // cancelled appointments
          $sql = "SELECT COUNT(*) AS cancelled_appointments FROM appointment WHERE " . $tableName . "_id = '$userId' AND status = 'Cancelled'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cancelledAppointments = $row["cancelled_appointments"];
          }

          ?>

          <div class="horizontal-cards">
            <div id="total-appointments-card" class="card text-center">
              <h2><?php echo $totalAppointments; ?></h2>
              <p>Total Appointment</p>
            </div>
            <div id="scheduled-appointments-card" class="card text-center">
              <h2><?php echo $scheduledAppointments; ?></h2>
              <p>Scheduled</p>
            </div>
            <div id="completed-appointments-card" class="card text-center">
              <h2><?php echo $completedAppointments; ?></h2>
              <p>Completed</p>
            </div>
            <div id="cancelled-appointments-card" class="card text-center">
              <h2><?php echo $cancelledAppointments; ?></h2>
              <p>Cancelled</p>
            </div>
          </div>

          <nav class="horizontal-nav" id="appointments-horizontal-nav">
            <ul class="nav-links">
              <li class="nav-link active-link">
                <a href="">All Appointments</a>
              </li>
              <li class="nav-link">
                <a href="">Scheduled</a>
              </li>
              <li class="nav-link"><a href="">Completed</a></li>
              <li class="nav-link"><a href="">Cancelled</a></li>
            </ul>
          </nav>

          <select name="appointments-status-dropdown" id="appointments-status-dropdown" class="form-control">
            <option value="all-appointments">All Appointments</option>
            <option value="scheduled">Scheduled</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>

          <div class="display-cards">
            <?php
            if ($role == "Patient") {
              $id = $user["patient_id"];
              $sql = "SELECT staff.name, staff.specialty, appointment.*, time_slot.time FROM appointment
              JOIN staff
              USING (staff_id)
              JOIN time_slot
              USING (time_slot_id)
              WHERE patient_id = '$id'
              ORDER BY appointment_id DESC";
            } else {
              $id = $user["staff_id"];
              $sql = "SELECT patient.name, appointment.*, time_slot.time FROM appointment
              JOIN patient
              USING (patient_id)
              JOIN time_slot
              USING (time_slot_id)
              WHERE appointment.staff_id = '$id'
              ORDER BY appointment_id DESC";
            }

            $result = $conn->query($sql);

            if (!$result) {
              die("Failed to fetch appointments. Error: $conn->error");
            }

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<div class='display-card-left-right card'>";
                echo "<div class='display-card-left'>";

                $name = $row["name"];
                echo "<h3>$name</h3>";

                if ($role == "Patient") {
                  $specialty = $row["specialty"];
                  echo "<p class='text-gray'>";
                  echo "<i class='fa-solid fa-user-doctor'></i>$specialty";
                  echo "</p>";
                } else {
                  $appointmentType = $row["appointment_type"];
                  echo "<p class='text-gray'>";
                  echo "<i class='fa-solid fa-book-medical'></i>$appointmentType";
                  echo "</p>";
                }

                $date = $row["date"];
                echo "<p class='text-gray'>";
                echo "<i class='fa-solid fa-calendar'></i>$date";
                echo "</p>";

                $timeSlot = $row["time"];
                echo "<p class='text-gray'>";
                echo "<i class='fa-solid fa-clock'></i>$timeSlot";
                echo "</p>";
                echo "</div>";  // close .display-card-left
          
                echo "<div class='display-card-right'>";

                $status = $row["status"];
                $appointmentId = $row["appointment_id"];
                echo "<span class='badge badge-" . (($status == "Scheduled") ? "info" : (($status == "Completed") ? "success" : "danger")) . "'>$status</span>";
                echo "<div class='btns'>";
                echo "<a class='btn btn-info view-details-btn' href='appointment-details.php?appointment_id=$appointmentId'>View Details</a>";
                if ($status == "Scheduled") {
                  echo "<a class='btn btn-danger' id='cancel-appointment-btn' href='cancel_appointment.php?appointment_id=$appointmentId'>Cancel Appointment</a>";
                }
                echo "</div>";  // close .btns
          
                echo "</div>";  // close .display-card-right
          
                echo "</div>";  // close .display-cards
              }
            }
            ?>
          </div>
        </div>

        <?php
        if ($role == "Patient") {
          echo "<button class='btn btn-info' id='book-appointment-btn'>Book Appointment</button>";
        }
        ?>
      </main>
    </div>
  </body>

  </html>

  <?php

} else {
  echo "User not found.";
}

$conn->close();
?>