<?php
include('verify_auth.php');
include('connect.php');

header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Check if file is uploaded
if (!isset($_FILES['profileImage'])) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['profileImage'];
$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

// Validate user session
if (!$userId || !$role) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Validate file
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxSize = 5 * 1024 * 1024; // 5MB

if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed']);
    exit;
}

if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'File size exceeds 5MB limit']);
    exit;
}

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'File upload error: ' . $file['error']]);
    exit;
}

// Create uploads directory if it doesn't exist
$uploadsDir = __DIR__ . '/../images/';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

// Generate unique filename
$fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $role . '_' . $userId . '_' . time() . '.' . $fileExtension;
$filePath = $uploadsDir . $filename;
$relativePath = 'images/' . $filename;

// Move uploaded file
if (!move_uploaded_file($file['tmp_name'], $filePath)) {
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
    exit;
}

// Update database with image path
if ($role === 'doctor' || $role === 'admin') {
    $query = "UPDATE staff SET profile_picture = ? WHERE staff_id = ?";
} elseif ($role === 'patient') {
    $query = "UPDATE patient SET profile_picture = ? WHERE patient_id = ?";
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid role']);
    exit;
}

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$stmt->bind_param('si', $relativePath, $userId);
if (!$stmt->execute()) {
    // Delete uploaded file if database update fails
    unlink($filePath);
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    exit;
}

$stmt->close();

echo json_encode([
    'success' => true,
    'message' => 'Profile image uploaded successfully',
    'imageUrl' => $relativePath
]);

$conn->close();
?>
