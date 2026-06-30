<?php
include('../../helper/connect.php');
include('../../helper/generate_id.php');
include('../../helper/validate_input.php');

if (!isset($_POST['save'])) {
    echo "
    <script>
        alert('Invalid request method.');
        window.location='add_doctor.php';
    </script>
    ";
    exit();
}

if (
    !isset($_POST["name"]) ||
    !isset($_POST["department_id"]) ||
    !isset($_POST["specialty"]) ||
    !isset($_POST["email"]) ||
    !isset($_POST["phone_no"]) ||
    !isset($_POST["bio"]) ||
    !isset($_POST["status"]) ||
    !isset($_POST["gender"])
) {
    echo "
        <script>
            alert('Please fill in all required fields.');
            window.location='add_doctor.php';
        </script>
        ";
    exit();
}

$staff_id = generateId("staff", 1, 14);

$name = htmlspecialchars($_POST['name']);
$department_id = htmlspecialchars($_POST['department_id']);
$specialty = htmlspecialchars($_POST['specialty']);
$email = htmlspecialchars($_POST['email']);
$phone_no = htmlspecialchars($_POST['phone_no']);
$bio = htmlspecialchars($_POST['bio']);
$status = htmlspecialchars($_POST['status']);
$gender = htmlspecialchars($_POST['gender']);

if (!validatePhone($phone_no)) {
    echo "
        <script>
            alert('Invalid phone format.');
            window.location='add_doctor.php';
        </script>
        ";
    exit();
}

// check if doctor with provided email and phone number exists
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = ? OR phone_no = ?");
$stmt->bind_param("ss", $email, $phone_no);
$stmt->execute();
$result = $stmt->get_result();

// if exists, don't allow the insert
if ($result && $result->num_rows > 0) {
    echo "
        <script>
            alert('Email or phone number already taken.');
            window.location='add_doctor.php';
        </script>
        ";
    exit();
}

$hashedPassword = password_hash("abc123", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO staff (staff_id, name, password, role, email, phone_no, gender, specialty, status, bio, department_id) 
    VALUES (?, ?, ?, 'Doctor', ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $staff_id, $name, $hashedPassword, $email, $phone_no, $gender, $specialty, $status, $bio, $department_id);

$result = $stmt->execute();

if ($result) {
    echo "
        <script>
            alert('Doctor added successfully.');
            window.location='doctor.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Failed to add doctor. Error: $conn->error');
            window.location='add_doctor.php';
        </script>
        ";
}
?>