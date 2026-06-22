<?php
$role = $_SESSION["role"];
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../styles/styles.css" />
  <script src="../scripts/load-page.js"></script>
  <title>Hospital Islam Azzahrah Appointment Booking System</title>
</head>

<body>
  <nav id="side-nav">
    <div id="nav-content">
      <img src="../../images/logo-azzahrah.png" alt="Hostpital Islam Azzahrah Logo" id="logo" />
      <ul class="nav-links">
        <?php
        if ($role != "Patient") {
          echo "<li class='nav-link'><a href='../../pages/dashboard/dashboard.php'><i class='fa-solid fa-chart-pie'></i>Dashboard</a></li>";
        }
        ?>
        <li class="nav-link">
          <a href="../../pages/appointments/appointments.php"><i class="fa-regular fa-clipboard"></i>Appointments</a>
        </li>
        <?php
        if ($role != "Patient") {
          echo "<li class='nav-link'><a href='../../pages/time-slots/time-slots.php'><i class='fa-regular fa-clock'></i>Time Slots</a></li>";
        }
        ?>
        <?php
        if ($role == "Admin") {
          echo "<li class='nav-link'><a href='../../pages/departments/departments.php'><i class='fa-regular fa-building'></i>Departments</a></li>";
        }
        ?>
        <?php
        if ($role == "Admin") {
          echo "<li class='nav-link'><a href='../../pages/doctors/doctor.php'><i class='fa-solid fa-user-doctor'></i>Doctors</a></li>";
        }
        ?>
        <li class="nav-link">
          <a href="../../pages/forum/forum.php"><i class="fa-regular fa-newspaper"></i>Forum</a>
        </li>
        <li class="nav-link">
          <a href="../../pages/profile/profile.php"><i class="fa-regular fa-user"></i>Profile</a>
        </li>
      </ul>
    </div>
  </nav>
</body>

</html>