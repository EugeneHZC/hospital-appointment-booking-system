<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];
$profileData = null;

// Fetch user data based on role
if ($role === 'Patient') {
  $query = "SELECT patient_id as id, name, email, phone_no as phone, date_of_birth, profile_picture, 'Patient' as role, NULL as specialty, NULL as bio, NULL as department FROM patient WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $profileData = $result->fetch_assoc();
  }
  $stmt->close();
} else if ($role === 'Doctor' || $role === 'Admin') {
  $query = "SELECT staff_id as id, name, email, phone_no as phone, role, specialty, bio, profile_picture, d.department_name as department FROM staff s LEFT JOIN department d ON s.department_id = d.department_id WHERE s.email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $profileData = $result->fetch_assoc();
  }
  $stmt->close();
}

// Default values if no data found
if (!$profileData) {
  $profileData = [
    'name' => 'User',
    'email' => $email,
    'phone' => 'N/A',
    'specialty' => 'N/A',
    'bio' => 'N/A',
    'department' => 'N/A'
  ];
}
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
  <script src="../../scripts/profile.js"></script>
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
        <input type="hidden" value="<?php echo htmlspecialchars($role); ?>" id="role" name="role" />
        <input type="hidden" value="<?php echo htmlspecialchars(json_encode($profileData)); ?>" id="profile-json" />

        <div id="view-section">
          <div class="card">
            <div class="profile-header">
              <div class="profile-avatar" id="profile-avatar">
              </div>
              <div>
                <h2 id="profile-name"><?php echo htmlspecialchars($profileData['name']); ?></h2>
                <span class="profile-badge" id="profile-role"><?php echo htmlspecialchars($role); ?></span>
              </div>
            </div>

            <div class="info-row">
              <div class="info-label">
                <i class="fa-regular fa-envelope"></i> Email Address
              </div>
              <div class="info-value" id="display-email"><?php echo htmlspecialchars($profileData['email']); ?></div>
            </div>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-phone"></i> Phone Number
              </div>
              <div class="info-value" id="display-phone"><?php echo htmlspecialchars($profileData['phone'] ?? 'N/A'); ?></div>
            </div>
            <?php if ($role === 'Patient' && isset($profileData['date_of_birth']) && $profileData['date_of_birth']): ?>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-calendar"></i> Date of Birth
              </div>
              <div class="info-value" id="display-dob"><?php echo htmlspecialchars(date('d/m/Y', strtotime($profileData['date_of_birth']))); ?></div>
            </div>
            <?php endif; ?>
            <?php if ($profileData['specialty'] && $profileData['specialty'] !== 'N/A'): ?>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-stethoscope"></i> Specialty
              </div>
              <div class="info-value" id="display-specialty"><?php echo htmlspecialchars($profileData['specialty']); ?></div>
            </div>
            <?php endif; ?>
            <?php if ($profileData['department'] && $profileData['department'] !== 'N/A'): ?>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-building"></i> Department
              </div>
              <div class="info-value" id="display-department"><?php echo htmlspecialchars($profileData['department']); ?></div>
            </div>
            <?php endif; ?>
            <?php if (($role === 'Doctor' || $role === 'Admin') && $profileData['bio'] && $profileData['bio'] !== 'N/A'): ?>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-regular fa-note-sticky"></i> Bio
              </div>
              <div class="info-value" id="display-bio"><?php echo htmlspecialchars($profileData['bio']); ?></div>
            </div>
            <?php endif; ?>

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
            <input type="file" id="edit-profile-picture" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" />
            <small class="text-muted">Accepted formats: JPEG, PNG, GIF, WebP (Max 5MB)</small>
            <div id="upload-status"></div>
          </div>
          <div class="form-row">
            <label>Profile Picture</label>
            <input type="file" id="edit-profile-picture" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" />
            <small class="text-muted">Accepted formats: JPEG, PNG, GIF, WebP (Max 5MB)</small>
            <div id="upload-status"></div>
          </div>
          <div class="form-row">
            <label>Profile Picture</label>
            <div class="profile-upload-container">
              <div class="profile-avatar" id="profile-avatar-preview"></div>
              <input type="file" id="profile-picture-input" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" />
              <small class="form-text text-muted">JPG, PNG, GIF, or WebP (Max 5MB)</small>
            </div>
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
          <?php if ($role === 'Patient'): ?>
          <div class="form-row">
            <label>Date of Birth</label>
            <input type="date" id="edit-dob" class="form-control" readonly />
          </div>
          <?php endif; ?>
          <?php if ($role === 'Doctor' || $role === 'Admin'): ?>
          <div class="form-row">
            <label>Specialty</label>
            <input type="text" id="edit-specialty" class="form-control" />
          </div>
          <?php endif; ?>
          <?php if ($role === 'Doctor' || $role === 'Admin'): ?>
          <div class="form-row">
            <label>Bio</label>
            <textarea id="edit-bio" rows="5" class="form-control"></textarea>
          </div>
          <?php endif; ?>
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