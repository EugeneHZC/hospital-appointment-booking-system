<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hospital Islam Azzahrah Appointment Booking System - Patient Profile</title>
  <link rel="stylesheet" href="../../styles/styles.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
  <script src="../../scripts/load-page.js"></script>
  <script src="../../scripts/patient-profile.js"></script>
  <script src="../../scripts/logout.js"></script>
</head>

<body>
  <div id="container">
    <?php include("../../components/patient/side-nav.html") ?>
    <main>
      <header>
        <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
        <div>
          <h1>My Profile</h1>
          <p id="role-view"></p>
        </div>
      </header>
      <div id="content">
        <input type="hidden" value="patient" id="role" name="role" />

        <div id="view-section">
          <div class="card">
            <div class="profile-header">
              <div class="profile-avatar"></div>
              <div>
                <h2 id="profile-name">Patient Name</h2>
              </div>
            </div>

            <div class="info-row">
              <div class="info-label">
                <i class="fa-regular fa-envelope"></i> Email Address
              </div>
              <div class="info-value" id="display-email">—</div>
            </div>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-phone"></i> Phone Number
              </div>
              <div class="info-value" id="display-phone">—</div>
            </div>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-regular fa-address-card"></i> IC / Passport
              </div>
              <div class="info-value" id="display-ic">—</div>
            </div>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-regular fa-cake-candles"></i> Date of Birth
              </div>
              <div class="info-value" id="display-dob">—</div>
            </div>

            <div class="profile-actions">
              <button class="btn btn-info" id="edit-btn"><i class="fa-regular fa-pen-to-square"></i> Edit Profile</button>
              <button class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
            </div>
          </div>
        </div>
        <div class="edit-section card">
          <h3><i class="fa-regular fa-pen-to-square"></i> Edit Profile</h3>
          <div class="form-row">
            <label>Full Name</label>
            <input type="text" id="edit-fullname" class="form-control" />
          </div>
          <div class="form-row">
            <label>Email Address</label>
            <input type="email" id="edit-email" class="form-control" />
          </div>
          <div class="form-row">
            <label>Phone Number</label>
            <input type="text" id="edit-phone" class="form-control" />
          </div>
          <div class="form-row">
            <label>IC / Passport</label>
            <input type="text" id="edit-ic" class="form-control" />
          </div>
          <div class="profile-actions">
            <button class="btn btn-secondary" id="cancel-btn">Cancel</button>
            <button class="btn btn-success" id="save-btn">
              <i class="fa-regular fa-floppy-disk"></i> Save Changes
            </button>
          </div>
        </div>
    </main>
  </div>
</body>

</html>