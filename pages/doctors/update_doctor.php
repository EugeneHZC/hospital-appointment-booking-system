<?php
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if (!isset($_POST['save'])) {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='edit_doctor.php';
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
            window.location='edit_doctor.php';
        </script>
        ";
    exit();
}

$staff_id = $_POST["staff_id"];
$name = $_POST['name'];
$department_id = $_POST['department_id'];
$specialty = $_POST['specialty'];
$email = $_POST['email'];
$phone_no = $_POST['phone_no'];
$bio = $_POST['bio'];
$status = $_POST['status'];
$gender = $_POST['gender'];

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
$stmt = $conn->prepare("SELECT * FROM staff WHERE (email = ? OR phone_no = ?) AND staff_id != ?");
$stmt->bind_param("sss", $email, $phone_no, $staff_id);
$stmt->execute();
$result = $stmt->get_result();

// if exists, don't allow the update
if ($result && $result->num_rows > 0) {
    echo "
        <script>
            alert('Email or phone number already taken.');
            window.location='doctor.php';
        </script>
        ";
    exit();
}

$stmt = $conn->prepare("UPDATE staff
    SET name = ?, email = ?, phone_no = ?, gender = ?, specialty = ?, bio = ?, department_id = ?, status = ?
    WHERE staff_id = ?");

$stmt->bind_param("sssssssss", $name, $email, $phone_no, $gender, $specialty, $bio, $department_id, $status, $staff_id);
$result = $stmt->execute();

if ($result) {
    echo "
        <script>
            alert('Doctor updated successfully.');
            window.location='doctor.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Failed to add doctor. Error: $conn->error');
            window.location='edit_doctor.php';
        </script>
        ";
}
?>