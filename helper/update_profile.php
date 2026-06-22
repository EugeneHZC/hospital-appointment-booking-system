<?php
include('verify_auth.php');
include('connect.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

if (!$userId || !$role) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

try {
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $bio = $_POST['bio'] ?? null;
    $profile_picture = $_POST['profile_picture'] ?? null;

    if ($role === 'patient') {
        $query = "UPDATE patient SET name = ?, email = ?, phone_no = ?, profile_picture = ? WHERE patient_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param('sssss', $name, $email, $phone, $profile_picture, $userId);
        
    } else if ($role === 'doctor' || $role === 'admin') {
        $query = "UPDATE staff SET name = ?, email = ?, phone_no = ?, bio = ?, profile_picture = ? WHERE staff_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param('ssssss', $name, $email, $phone, $bio, $profile_picture, $userId);
        
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid role']);
        exit;
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile: ' . $stmt->error]);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

$conn->close();
?>
