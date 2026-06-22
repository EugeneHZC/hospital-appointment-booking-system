<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='appointment-details.php';
        </script>
        ";
}

$role = $_SESSION["role"];
$appointmentId = $_POST["appointment_id"];
$status = $_POST["appointment_status"] ?? null;  // for patients, there is no status update
$appointment = null;

// get the current appointment to be updated
$stmt = $conn->prepare("SELECT * FROM appointment WHERE appointment_id = ?");
$stmt->bind_param("s", $appointmentId);
$stmt->execute();
$result = $stmt->get_result();
if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch appointment. Error: $conn->error');
            window.location='appointment-details.php';
        </script>
        ";
}

$appointment = $result->fetch_assoc();

if ($role == "Patient") {
    $patientRemark = $_POST["patient_remark"];
    $stmt = $conn->prepare("UPDATE appointment SET patient_remark = ? WHERE appointment_id = ?");
    $stmt->bind_param("ss", $patientRemark, $appointmentId);
} else {
    $followUpAppointmentId = null;

    if (isset($_POST["date"]) && isset($_POST["time"])) {
        // insert new follow-up appointment
        $followUpAppointmentId = generateId("appointment", 2, 13);
        $date = $_POST["date"];
        $time = $_POST["time"];
        $staffId = $appointment["staff_id"];
        $patientId = $appointment["patient_id"];

        if (isset($appointment["follow_up_appointment_id"])) {
            // if there is already a follow-up appointment, update the follow-up appointment details
            $followUpAppointmentId = $appointment["follow_up_appointment_id"];
            $stmt = $conn->prepare("UPDATE appointment SET date = ?, time_slot_id = ? WHERE appointment_id = ?");
            $stmt->bind_param("sss", $date, $time, $followUpAppointmentId);
            $result = $stmt->execute();
        } else {
            // if there is no follow-up appointment, insert a new follow-up appointment
            $stmt = $conn->prepare("INSERT INTO appointment (appointment_id, date, status, appointment_type, time_slot_id, patient_id, staff_id)
            VALUES (?, ?, 'Scheduled', 'Follow-up Appointment', ?, ?, ?)");
            $stmt->bind_param("sssss", $followUpAppointmentId, $date, $time, $patientId, $staffId);
            $result = $stmt->execute();
        }

        if (!$result) {
            echo "Failed to save follow-up appointment. Error: $conn->error";
        }
    }
    $doctorRemark = $_POST["doctor_remark"];
    $stmt = $conn->prepare("UPDATE appointment SET doctor_remark = ?, status = ?, follow_up_appointment_id = ? WHERE appointment_id = ?");
    $stmt->bind_param("ssss", $doctorRemark, $status, $followUpAppointmentId, $appointmentId);
}

$result = $stmt->execute();

if ($result) {
    echo "
        <script>
            alert('Appointment saved successfully.');
            window.location='appointments.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Failed to save appointment. Error: $conn->error');
            window.location='appointment-details.php';
        </script>
        ";
}
?>