<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$appointmentId = $_GET["appointment_id"];
$sql = "UPDATE appointment SET status = 'Cancelled' WHERE appointment_id = '$appointmentId'";
$result = $conn->query($sql);

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Failed to cancel appointment. Error: $conn->error");
}

echo "Appointment cancelled.";
echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
?>