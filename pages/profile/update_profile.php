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

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
  exit;
}

try {
  // Validate input
  if (empty($data['name'])) {
    throw new Exception("Name is required");
  }

  if ($role === 'Patient') {
    $query = "UPDATE patient SET name = ?, phone_no = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
      throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $phone = $data['phone'] ?? '';
    $stmt->bind_param("sss", $data['name'], $phone, $email);
    
    if (!$stmt->execute()) {
      throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $stmt->close();
  } else if ($role === 'Doctor' || $role === 'Admin') {
    $query = "UPDATE staff SET name = ?, phone_no = ?, specialty = ?, bio = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
      throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $phone = $data['phone'] ?? '';
    $specialty = $data['specialty'] ?? '';
    $bio = $data['bio'] ?? '';
    
    $stmt->bind_param("sssss", $data['name'], $phone, $specialty, $bio, $email);
    
    if (!$stmt->execute()) {
      throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $stmt->close();
  } else {
    throw new Exception("Invalid user role");
  }
  
  echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
