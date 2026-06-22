<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('get_user.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo "
        <script>
            alert('Failed to fetch profile info. Error: $conn->error');
            window.location='../appointments/appointments.php';
        </script>
        ";
  exit();
}

if (!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["phone_no"]) || !isset($_POST["gender"])) {
  echo "
      <script>
          alert('Please fill in all required fields.');
          window.location='edit_profile.php';
      </script>
      ";
  exit();
}

$name = $_POST["name"];
$newEmail = $_POST["email"];
$phone_no = $_POST["phone_no"];
$gender = $_POST["gender"];

if ($role == "Patient") {
  if (!isset($_POST["ic_number"]) || !isset($_POST["date_of_birth"]) || !isset($_POST["address"])) {
    echo "
      <script>
          alert('Please fill in all required fields.');
          window.location='edit_profile.php';
      </script>
      ";
    exit();
  }

  if (!validateUnique("patient", "email", $newEmail)) {
    echo "
      <script>
          alert('Email already taken.');
          window.location='edit_profile.php';
      </script>
      ";
    exit();
  }

  if (!validateUnique("patient", "phone_no", $phone_no)) {
    echo "
      <script>
          alert('Email already taken.');
          window.location='edit_profile.php';
      </script>
      ";
    exit();
  }

  $ic_number = $_POST["ic_number"];
  $date_of_birth = $_POST["date_of_birth"];
  $address = $_POST["address"];

  $stmt = $conn->prepare("UPDATE patient
  SET name = ?, email = ?, phone_no = ?, date_of_birth = ?, ic_number = ?, gender = ?, address = ?
  WHERE email = ?");

  $stmt->bind_param("ssssssss", $name, $newEmail, $phone_no, $date_of_birth, $ic_number, $gender, $address, $email);
} else {
  if (!isset($_POST["specialty"])) {
    echo "
      <script>
          alert('Please fill in all required fields.');
          window.location='edit_profile.php';
      </script>
      ";
    exit();
  }

  $specialty = $_POST["specialty"];
  $bio = $_POST["bio"];

  if (!validateUnique("staff", "email", $newEmail)) {
    echo "
      <script>
          alert('Email already taken.');
          window.location='edit_profile.php';
      </script>
      ";
    exit();
  }

  if (!validateUnique("staff", "phone_no", $phone_no)) {
    echo "
      <script>
          alert('Email already taken.');
          window.location='edit_profile.php';
      </script>
      ";
    exit();
  }

  $stmt = $conn->prepare("UPDATE staff
  SET name = ?, email = ?, phone_no = ?, specialty = ?, bio = ?, gender = ?
  WHERE email = ?");
  $stmt->bind_param("sssssss", $name, $newEmail, $phone_no, $specialty, $bio, $gender, $email);
}

$result = $stmt->execute();

if (!$result) {
  echo "
    <script>
        alert('Failed to update profile. Error: $conn->error');
        window.location='profile.php';
    </script>
    ";
  exit();
}

// update session's email in case user changed email
$_SESSION["email"] = $newEmail;


// upload profile picture
if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] > 0) {
  echo "
      <script>
          alert('Failed to upload profile picture. Error: $conn->error');
          window.location='edit_profile.php';
      </script>
      ";
  exit();
}

$file = $_FILES['profile_picture'];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Validate file type
if (!in_array($file['type'], $allowed_types)) {
  echo "
      <script>
          alert('Invalid file type.');
          window.location='edit_profile.php';
      </script>
      ";
  exit();
}

// Create uploads directory if it doesn't exist
$upload_dir = '../../images/profile_pictures/';
if (!is_dir($upload_dir)) {
  mkdir($upload_dir, 0755, true);
}

// Generate unique filename
$originalName = basename($file['name']);
$filename = uniqid('profile_') . '.' . $originalName;
$filepath = $upload_dir . $filename;

// Move uploaded file
if (!move_uploaded_file($file['tmp_name'], $filepath)) {
  echo "
      <script>
          alert('Failed to upload file.');
          window.location='edit_profile.php';
      </script>
      ";
  exit();
}

// Update database
if ($role === 'Patient') {
  $query = "UPDATE patient SET profile_picture = ? WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $filepath, $email);
} else {
  $query = "UPDATE staff SET profile_picture = ? WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $filepath, $email);
}

$result = $stmt->execute();

if (!$result) {
  echo "
      <script>
          alert('Failed to upload file.');
          window.location='edit_profile.php';
      </script>
      ";
  exit();
}

echo "
  <script>
      alert('Profile updated successfully.');
      window.location='profile.php';
  </script>
  ";

$conn->close();
?>