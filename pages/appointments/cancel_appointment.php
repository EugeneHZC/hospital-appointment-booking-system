<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Invalid request method.");
}

$appointmentId = $_POST["appointment_id"];
$stmt = $conn->prepare("UPDATE appointment SET status = 'Cancelled' WHERE appointment_id = ?");
$stmt->bind_param("s", $appointmentId);
$result = $stmt->execute();

if (!$result) {
    echo json_encode("Failed to cancel appointment. Error: $conn->error");
    exit();
}

echo json_encode("Appointment cancelled. Redirecting to appointments page.");
?>