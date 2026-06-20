<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Invalid request method.");
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM patient WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=book-appointment.php' />";
    die("Failed to fetch user. Error: $conn->error");
}

if ($result->num_rows == 0) {
    echo "<meta http-equiv='refresh' content='3;URL=book-appointment.php' />";
    die("User not found.");
}

if (!isset($_POST["department"]) || !isset($_POST["doctor"]) || $_POST["date"] == "" || !isset($_POST["time"])) {
    echo "<meta http-equiv='refresh' content='3;URL=book-appointment.php' />";
    die("Please fill in all required fields.");
}

$patient = $result->fetch_assoc();
$patient_id = $patient["patient_id"];

$appointment_id = generateId("appointment", 2, 3);
if ($appointment_id == "") {
    echo "<meta http-equiv='refresh' content='3;URL=book-appointment.php' />";
    die("Failed to generate ID for new appointment.");
}

$department = $_POST["department"];
$doctor = $_POST["doctor"];
$date = $_POST["date"];
$time_slot = $_POST["time"];
$appointment_type = $_POST["appointment_type"];
$remarks_for_doctor = $_POST["remarks_for_doctor"];

$stmt = $conn->prepare("INSERT INTO appointment (appointment_id, date, status, appointment_type, patient_remark, time_slot_id, patient_id, staff_id)
VALUES (?, ?, 'Scheduled', ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $appointment_id, $date, $appointment_type, $remarks_for_doctor, $time_slot, $patient_id, $doctor);
$result = $stmt->execute();

echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";

if (!$result) {
    die("Failed to book appointment. Error: $conn->error");
} else {
    echo "Appointment saved successfully. Redirecting to appointments page.";
}

?>