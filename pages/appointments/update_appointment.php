<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');
include('../../helper/generate_id.php');

$role = $_SESSION["role"];
$appointmentId = $_POST["appointment_id"];
$status = $_POST["appointment_status"];
$appointment = null;

// get the current appointment to be updated
$appointmentSql = "SELECT * FROM appointment WHERE appointment_id = '$appointmentId'";
$appointmentResult = $conn->query($appointmentSql);
if ($appointmentResult && $appointmentResult->num_rows > 0) {
    $appointment = $appointmentResult->fetch_assoc();
} else {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php'>";
    die("Failed to fetch appointment. Error: $conn->error");
}

if ($role == "Patient") {
    $patientRemark = $_POST["patient_remark"];
    $sql = "UPDATE appointment SET patient_remark = '$patientRemark' WHERE appointment_id = '$appointmentId'";
} else {
    $followUpAppointmentId = null;
    if (isset($_POST["appointment_date"]) && isset($_POST["appointment_time"])) {
        // insert new follow-up appointment
        $followUpAppointmentId = generateId("appointment", 2, 3);
        $date = $_POST["appointment_date"];
        $time = $_POST["appointment_time"];
        $staffId = $appointment["staff_id"];
        $patientId = $appointment["patient_id"];

        if (isset($appointment["follow_up_appointment_id"])) {
            // if there is already a follow-up appointment, update the follow-up appointment details
            $followUpAppointmentId = $appointment["follow_up_appointment_id"];
            $followUpAppointmentSql = "UPDATE appointment SET date = '$date', time_slot_id = '$time' WHERE appointment_id = '$followUpAppointmentId'";
            $followUpAppointmentResult = $conn->query($followUpAppointmentSql);
        } else {
            // if there is no follow-up appointment, insert a new follow-up appointment
            $followUpAppointmentSql = "INSERT INTO appointment (appointment_id, date, status, appointment_type, time_slot_id, patient_id, staff_id)
            VALUES ('$followUpAppointmentId', '$date', 'Scheduled', 'Follow-up Appointment', '$time', '$patientId', '$staffId')";
            $followUpAppointmentResult = $conn->query($followUpAppointmentSql);
        }

        if (!$followUpAppointmentResult) {
            echo "Failed to save follow-up appointment. Error: $conn->error";
        }
    }
    $doctorRemark = $_POST["doctor_remark"];
    $sql = "UPDATE appointment SET doctor_remark = '$doctorRemark', status = '$status' WHERE appointment_id = '$appointmentId'";

    if (isset($followUpAppointmentId)) {
        // if there is a follow-up appointment, assign it to the current appointment
        $sql = "UPDATE appointment SET doctor_remark = '$doctorRemark', status = '$status', follow_up_appointment_id = '$followUpAppointmentId' WHERE appointment_id = '$appointmentId'";
    }
}

$result = $conn->query($sql);

if ($result) {
    echo "Appointment saved successfully.";
} else {
    echo "Failed to save appointment. Error: $conn->error";
}
echo "<meta http-equiv='refresh' content='3;URL=appointments.php'>";
?>