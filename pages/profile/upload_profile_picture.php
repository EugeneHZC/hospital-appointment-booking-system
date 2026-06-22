<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'message' => 'Method not allowed']);
  exit;
}

if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
  exit;
}

$file = $_FILES['profile_picture'];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$max_size = 5 * 1024 * 1024; // 5MB

// Validate file type
if (!in_array($file['type'], $allowed_types)) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.']);
  exit;
}

// Validate file size
if ($file['size'] > $max_size) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'File size exceeds 5MB limit.']);
  exit;
}

try {
  // Create uploads directory if it doesn't exist
  $upload_dir = '../../images/profile_pictures/';
  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
  }

  // Generate unique filename
  $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $filename = uniqid('profile_') . '.' . $file_extension;
  $filepath = $upload_dir . $filename;

  // Move uploaded file
  if (!move_uploaded_file($file['tmp_name'], $filepath)) {
    throw new Exception("Failed to move uploaded file");
  }

  // Update database
  if ($role === 'Patient') {
    $query = "UPDATE patient SET profile_picture = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
      throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $filename, $email);
  } else if ($role === 'Doctor' || $role === 'Admin') {
    $query = "UPDATE staff SET profile_picture = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
      throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $filename, $email);
  } else {
    throw new Exception("Invalid user role");
  }

  if (!$stmt->execute()) {
    // Delete the file if database update fails
    unlink($filepath);
    throw new Exception("Execute failed: " . $stmt->error);
  }

  $stmt->close();

  echo json_encode([
    'success' => true,
    'message' => 'Profile picture uploaded successfully',
    'filename' => $filename
  ]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
