<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='book-appointment.php';
        </script>
        ";
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM patient WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch user. Error: $conn->error');
            window.location='book-appointment.php';
        </script>
        ";
}

if (!isset($_POST["department"]) || !isset($_POST["doctor"]) || $_POST["date"] == "" || !isset($_POST["time"])) {
    echo "
        <script>
            alert('Please fill in all required fields.');
            window.location='book-appointment.php';
        </script>
        ";
}

$patient = $result->fetch_assoc();
$patient_id = $patient["patient_id"];

$appointment_id = generateId("appointment", 2, 13);
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

if (!$result) {
    echo "
        <script>
            alert('Failed to book appointment. Error: $conn->error');
            window.location='book-appointment.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Appointment saved successfully.');
            window.location='appointments.php';
        </script>
        ";
}

?>