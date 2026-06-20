<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$appointmentId = $_POST["appointment_id"];
$sql = "UPDATE appointment SET status = 'Cancelled' WHERE appointment_id = '$appointmentId'";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode("Failed to cancel appointment. Error: $conn->error");
    exit;
}

echo json_encode("Appointment cancelled.");
?>