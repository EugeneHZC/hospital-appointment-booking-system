<?php
include('verify_auth.php');
include('connect.php');

header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

if (!$userId || !$role) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

try {
    if ($role === 'patient') {
        $query = "SELECT patient_id, name, email, phone_no, profile_picture FROM patient WHERE patient_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'id' => $data['patient_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone_no'],
                'profile_picture' => $data['profile_picture'] ?? '',
                'role' => $role
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Patient not found']);
        }
        $stmt->close();
        
    } else if ($role === 'doctor' || $role === 'admin') {
        $query = "SELECT staff_id, name, email, phone_no, profile_picture, specialty, bio, role FROM staff WHERE staff_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'id' => $data['staff_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone_no'],
                'profile_picture' => $data['profile_picture'] ?? '',
                'specialty' => $data['specialty'] ?? '',
                'bio' => $data['bio'] ?? '',
                'role' => $data['role']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Staff not found']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid role']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>
