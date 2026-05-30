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
  <title>Hospital Islam Azzahrah Appointment Booking System</title>

  <!-- for testing purposes only -->
  <input type="hidden" value="patient" name="role" id="role" />
</head>

<body>
  <div id="container">
    <?php include("../../components/patient/side-nav.html") ?>
    <main>
      <header>
        <h1>Appointment Details</h1>
        <p id="role-view"></p>
      </header>

      <div id="content">
        <div id="user-info-card" class="card">
          <h3>Doctor name</h3>
          <div id="user-sub-info">
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
        </div>

        <div class="display-cards">
          <div class="display-card-top-bottom card">
            <div class="display-card-top">
              <h3>Remarks</h3>
            </div>
            <br />
            <div class="display-card-bottom">
              <textarea name="remarks" id="remarks" class="form-control" rows="5" disabled placeholder="Doctor's remarks will appear here..."></textarea>
              <small class="text-gray" id="remarks-hint">Medical remarks from your doctor will be shown here.</small>
            </div>
          </div>

          <div class="display-card-top-bottom card">
            <div class="display-card-top">
              <h3>Follow-up Appointment</h3>
            </div>

            <br />

            <div class="display-card-bottom">
              <div class="row">
                <div class="form-group">
                  <label for="appointment-date">Appointment Date</label>
                  <input type="date" class="form-control" name="appointment-date" id="appointment-date" disabled />
                </div>

                <div class="form-group">
                  <label for="appointment-time">Appointment Time</label>
                  <select name="appointment-time" id="appointment-time" class="form-control" disabled>
                    <option value="">No time selected</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="btns">
          <button class="btn btn-secondary" type="button" id="back-btn">
            Back
          </button>
        </div>
      </div>
    </main>
  </div>
</body>

</html>