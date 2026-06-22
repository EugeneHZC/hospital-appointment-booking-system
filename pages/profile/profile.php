<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hospital Islam Azzahrah Appointment Booking System - Admin Profile</title>
  <link rel="stylesheet" href="../../styles/styles.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
  <script src="../../scripts/load-page.js"></script>
  <?php
    if ($role === 'doctor') {
      echo '<script src="../../scripts/doctor-profile.js"><\/script>';
    } elseif ($role === 'patient') {
      echo '<script src="../../scripts/patient-profile.js"><\/script>';
    } else {
      echo '<script src="../../scripts/admin-profile.js"><\/script>';
    }
  ?>
  <script src="../../scripts/logout.js"></script>
</head>

<body>
  <div id="container">
    <?php include("../../components/side-nav.php") ?>
    <main>
      <header>
        <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
        <div>
          <h1>Profile</h1>
          <p id="role-view">
            <?php echo $role; ?>'s View
          </p>
        </div>
      </header>
      <div id="content">
        <input type="hidden" value="admin" id="role" name="role" />
        <input type="file" id="profile-image-input" style="display: none;" accept="image/*" />

        <div id="view-section">
          <div class="card">
            <div class="profile-header">
              <div class="profile-avatar-container">
                <div class="profile-avatar" id="profile-avatar-display"></div>
                <button class="btn btn-sm btn-secondary" id="change-avatar-btn" title="Click to change profile picture">
                  <i class="fa-solid fa-camera"></i>
                </button>
              </div>
              <div>
                <h2 id="profile-name">Admin Name</h2>
                <span class="profile-badge" id="profile-role">Administrator</span>
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
                <i class="fa-solid fa-building"></i> Department
              </div>
              <div class="info-value" id="display-department">Paediatrics</div>
            </div>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-location-dot"></i> Location
              </div>
              <div class="info-value" id="display-office">Administration Wing, Level 3</div>
            </div>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-regular fa-note-sticky"></i> Bio
              </div>
              <div class="info-value" id="display-bio">—</div>
            </div>

            <div class="profile-actions">
              <button class="btn btn-info" id="edit-btn">
                <i class="fa-regular fa-pen-to-square"></i> Edit Profile
              </button>
              <button class="btn btn-danger" id="logout-btn">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
              </button>
            </div>
          </div>
        </div>

        <div class="edit-section card">
          <h3><i class="fa-regular fa-pen-to-square"></i> Edit Profile</h3>
          <div class="form-row">
            <label>Profile Picture</label>
            <div class="profile-upload-preview">
              <div class="profile-avatar-container">
                <div class="profile-avatar" id="edit-avatar-preview"></div>
                <button type="button" class="btn btn-sm btn-secondary" id="edit-avatar-btn" title="Click to change profile picture">
                  <i class="fa-solid fa-pen"></i>
                </button>
              </div>
            </div>
            <small class="form-text">Supported formats: JPG, PNG, GIF, WebP (Max 5MB)</small>
          </div>
          <div class="form-row">
            <label></label>Full Name</label>
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
            <label>Department</label>
            <select name="edit-department" id="edit-department" class="form-control">
              <option value="1" selected>Paediatrics</option>
            </select>
          </div>
          <div class="form-row">
            <label>Location</label>
            <input type="text" id="edit-office" class="form-control" />
          </div>
          <div class="form-row">
            <label>Bio</label>
            <textarea id="edit-bio" rows="5" class="form-control"></textarea>
          </div>
          <div class="profile-actions">
            <button class="btn btn-secondary" id="cancel-btn">Cancel</button>
            <button class="btn btn-success" id="save-btn">
              <i class="fa-regular fa-floppy-disk"></i> Save Changes
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>

<?php
$conn->close();
?>