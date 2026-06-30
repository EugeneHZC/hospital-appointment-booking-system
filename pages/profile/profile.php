<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];

// Fetch user data based on role
if ($role === 'Patient') {
  // $query = "SELECT patient_id as id, name, email, phone_no as phone, date_of_birth, profile_picture, 'Patient' as role, NULL as specialty, NULL as bio, NULL as department FROM patient WHERE email = ?";
  $query = "SELECT * FROM patient WHERE email = ?";
} else if ($role === 'Doctor' || $role === 'Admin') {
  // $query = "SELECT staff_id as id, name, email, phone_no as phone, role, specialty, bio, profile_picture, d.department_name as department FROM staff s LEFT JOIN department d ON s.department_id = d.department_id WHERE s.email = ?";
  $query = "SELECT * FROM staff s JOIN department d ON s.department_id = d.department_id WHERE s.email = ?";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
  echo "
        <script>
            alert('Failed to fetch profile info. Error: $conn->error');
            window.location='../appointments/appointments.php';
        </script>
        ";
  exit();
}

$profileData = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hospital Islam Azzahrah Appointment Booking System - Profile</title>
  <link rel="stylesheet" href="../../styles/styles.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
  <script src="../../scripts/load-page.js"></script>
  <!-- <script src="../../scripts/profile.js"></script> -->
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
        <div id="view-section">
          <div class="card">
            <div class="profile-header">
              <div class="profile-avatar" id="profile-avatar">
                <img src="<?php echo $profileData["profile_picture"] ?>" alt="Profile Picture">
              </div>
              <div>
                <h2 id="profile-name"><?php echo htmlspecialchars($profileData['name']); ?></h2>
                <span class="profile-badge" id="profile-role"><?php echo htmlspecialchars($role); ?></span>
              </div>
            </div>

            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-envelope"></i> Email Address
              </div>
              <div class="info-value"><?php echo htmlspecialchars($profileData['email']); ?></div>
            </div>
            <?php if ($role == "Patient") { ?>
              <div class="info-row">
                <div class="info-label">
                  <i class="fa-solid fa-id-card"></i> IC Number
                </div>
                <div class="info-value"><?php echo htmlspecialchars($profileData['ic_number']); ?></div>
              </div>
            <?php } ?>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-phone"></i> Phone Number
              </div>
              <div class="info-value"><?php echo htmlspecialchars($profileData['phone_no']); ?></div>
            </div>
            <div class="info-row">
              <div class="info-label">
                <i class="fa-solid fa-<?php echo $profileData["gender"] == 'M' ? "mars" : "venus"; ?>"></i> Gender
              </div>
              <div class=" info-value"><?php echo $profileData["gender"] == 'M' ? "Male" : "Female"; ?>
              </div>
            </div>
            <?php if ($role === 'Patient') { ?>
              <div class="info-row">
                <div class="info-label">
                  <i class="fa-solid fa-calendar"></i> Date of Birth
                </div>
                <div class="info-value"><?php echo htmlspecialchars(date('d/m/Y', strtotime($profileData['date_of_birth']))); ?></div>
              </div>

              <div class="info-row">
                <div class="info-label">
                  <i class="fa-solid fa-house"></i> Address
                </div>
                <div class="info-value"><?php echo htmlspecialchars($profileData["address"]); ?></div>
              </div>
            <?php } ?>
            <?php if ($role === 'Doctor' || $role === 'Admin') { ?>
              <div class="info-row">
                <div class="info-label">
                  <i class="fa-solid fa-stethoscope"></i> Specialty
                </div>
                <div class="info-value" id="display-specialty"><?php echo htmlspecialchars($profileData['specialty']); ?></div>
              </div>

              <div class="info-row">
                <div class="info-label">
                  <i class="fa-solid fa-building"></i> Department
                </div>
                <div class="info-value" id="display-department"><?php echo htmlspecialchars($profileData['department_name']); ?></div>
              </div>

              <div class="info-row">
                <div class="info-label">
                  <i class="fa-regular fa-note-sticky"></i> Bio
                </div>
                <div class="info-value" id="display-bio"><?php echo htmlspecialchars($profileData['bio']); ?></div>
              </div>
            <?php } ?>

            <div class="profile-actions">
              <a class="btn btn-info" id="edit-btn" href="edit_profile.php">
                <i class="fa-solid fa-pen-to-square"></i> Edit Profile
              </a>
              <button class="btn btn-danger" id="logout-btn">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
              </button>
            </div>
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