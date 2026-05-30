<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href=../../styles.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
  <script src="../../scripts/load-page.js"></script>
  <script src="../../scripts/appointments.js"></script>
  <title>Hospital Islam Azzahrah Appointment Booking System</title>

  <!-- for testing purposes only -->
  <input type="hidden" value="patient" name="role" id="role" />
</head>

<body>
  <div id="container">
    <?php include("../../components/patient/side-nav.html") ?>
    <main>
      <header>
        <h1>Appointments</h1>
        <p id="role-view"></p>
      </header>

      <div id="content">
        <div id="user-info-card" class="card">
          <h3>Patient name</h3>
          <div id="user-sub-info">
            <p><i class="fa-solid fa-envelope"></i>testpatient@example.com</p>
            <p><i class="fa-solid fa-phone"></i>+60142345678</p>
            <p><i class="fa-solid fa-id-card"></i>000000-00-0000</p>
          </div>
        </div>

        <div id="statistic-card">
          <div id="total-appointments-card" class="card text-center">
            <h2>3</h2>
            <p>Total Appointments</p>
          </div>
          <div id="scheduled-appointments-card" class="card text-center">
            <h2>3</h2>
            <p>Scheduled</p>
          </div>
          <div id="completed-appointments-card" class="card text-center">
            <h2>3</h2>
            <p>Completed</p>
          </div>
          <div id="cancelled-appointments-card" class="card text-center">
            <h2>3</h2>
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

        <div class="display-cards">
          <div class="display-card-left-right card">
            <div class="display-card-left">
              <h3>Doctor Name</h3>
              <p class="text-gray">
                <i class="fa-solid fa-user-doctor"></i>Senior Paediatrician
              </p>
              <p class="text-gray">
                <i class="fa-solid fa-calendar"></i>20/05/2026
              </p>
              <p class="text-gray">
                <i class="fa-solid fa-clock"></i>2:00 p.m.
              </p>
            </div>
            <div class="display-card-right">
              <span class="badge badge-info">Scheduled</span>
              <div>
                <button class="btn btn-info view-details-btn">
                  View Details
                </button>
                <button class="btn btn-danger">Cancel Appointment</button>
              </div>
            </div>
          </div>

          <div class="display-card-left-right card">
            <div class="display-card-left">
              <h3>Doctor Name</h3>
              <p class="text-gray">
                <i class="fa-solid fa-user-doctor"></i>Senior Paediatrician
              </p>
              <p class="text-gray">
                <i class="fa-solid fa-calendar"></i>20/05/2026
              </p>
              <p class="text-gray">
                <i class="fa-solid fa-clock"></i>2:00 p.m.
              </p>
            </div>
            <div class="display-card-right">
              <span class="badge badge-danger">Cancelled</span>
            </div>
          </div>

          <div class="display-card-left-right card">
            <div class="display-card-left">
              <h3>Doctor Name</h3>
              <p class="text-gray">
                <i class="fa-solid fa-user-doctor"></i>Senior Paediatrician
              </p>
              <p class="text-gray">
                <i class="fa-solid fa-calendar"></i>20/05/2026
              </p>
              <p class="text-gray">
                <i class="fa-solid fa-clock"></i>2:00 p.m.
              </p>
            </div>
            <div class="display-card-right">
              <span class="badge badge-success">Completed</span>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>