<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];
$tableName = strtolower($role) == "patient" ? strtolower($role) : "staff";

$stmt = $conn->prepare("SELECT * FROM $tableName WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

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

          $appointmentsStats = [];
          $appointmentStatusTypes = ["Scheduled", "Completed", "Cancelled"];

          // total appointments
          $sql = "SELECT COUNT(*) AS total_appointments FROM appointment WHERE " . $tableName . "_id = '$userId'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $appointmentsStats["total_appointments"] = $row["total_appointments"];
          }

          // get statistics for each appointment status (Scheduled, Completed, Cancelled)
          foreach ($appointmentStatusTypes as $status) {
            $sql = "SELECT COUNT(*) AS " . strtolower($status) . "_appointments FROM appointment WHERE " . $tableName . "_id = '$userId' AND status = '$status'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $appointmentsStats[strtolower($status) . "_appointments"] = $row[strtolower($status) . "_appointments"];
            }
          }
          ?>

          <div class="horizontal-cards">
            <div id="total-appointments-card" class="card text-center">
              <h2><?php echo $appointmentsStats["total_appointments"]; ?></h2>
              <p>Total Appointment</p>
            </div>
            <div id="scheduled-appointments-card" class="card text-center">
              <h2><?php echo $appointmentsStats["scheduled_appointments"]; ?></h2>
              <p>Scheduled</p>
            </div>
            <div id="completed-appointments-card" class="card text-center">
              <h2><?php echo $appointmentsStats["completed_appointments"]; ?></h2>
              <p>Completed</p>
            </div>
            <div id="cancelled-appointments-card" class="card text-center">
              <h2><?php echo $appointmentsStats["cancelled_appointments"]; ?></h2>
              <p>Cancelled</p>
            </div>
          </div>

          <nav class="horizontal-nav" id="appointments-horizontal-nav">
            <ul class="nav-links">
              <li class="nav-link active-link" data-status="">
                <a>All Appointments</a>
              </li>
              <li class="nav-link" data-status="Scheduled">
                <a>Scheduled</a>
              </li>
              <li class="nav-link" data-status="Completed"><a>Completed</a></li>
              <li class="nav-link" data-status="Cancelled"><a>Cancelled</a></li>
            </ul>
          </nav>

          <select name="appointments-status-dropdown" id="appointments-status-dropdown" class="form-control">
            <option value="">All Appointments</option>
            <option value="Scheduled">Scheduled</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
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
                ?>
                <div class="display-card-left-right card" data-status="<?php echo $row["status"]; ?>">
                  <div class="display-card-left">
                    <h3><?php echo $row["name"]; ?></h3>
                    <?php
                    if ($role == "Patient") {
                      ?>
                      <p class="text-gray"><i class="fa-solid fa-user-doctor"></i><?php echo $row["specialty"] ?></p>
                      <?php
                    } else {
                      ?>
                      <p class="text-gray"><i class="fa-solid fa-book-medical"></i><?php echo $row["appointment_type"] ?></p>
                      <?php
                    }
                    ?>
                    <p class="text-gray"><i class="fa-solid fa-calendar"></i><?php echo $row["date"] ?></p>
                    <p class="text-gray"><i class="fa-solid fa-clock"></i><?php echo $row["time"] ?></p>
                  </div>

                  <div class="display-card-right">
                    <span class="badge badge-<?php echo $row["status"] == "Scheduled" ? "info" : ($row["status"] == "Completed" ? "success" : "danger") ?>"><?php echo $row["status"] ?></span>
                    <div class="btns">
                      <a class="btn btn-info view-details-btn" href="appointment-details.php?appointment_id=<?php echo $row["appointment_id"]; ?>"><i class="fa-solid fa-clipboard"></i>View Details</a>
                      <?php
                      if ($row["status"] == "Scheduled") {
                        $appointmentId = $row["appointment_id"];
                        echo "<a class='btn btn-danger' id='cancel-appointment-btn' data-id='$appointmentId'><i class='fa-solid fa-ban'></i>Cancel Appointment</a>";
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <?php
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