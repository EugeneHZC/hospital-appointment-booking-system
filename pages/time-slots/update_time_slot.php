<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='edit-time-slot.php';
        </script>
        ";
    exit();
}

if (!isset($_POST["time_slot"])) {
    echo "
        <script>
            alert('Time slot required.');
            window.location='edit-time-slot.php';
        </script>
        ";
    exit();
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch user. Error: $conn->error');
            window.location='edit-time-slot.php';
        </script>
        ";
    exit();
}

$user = $result->fetch_assoc();
$timeSlotId = htmlspecialchars($_POST["time_slot_id"]);
$time = htmlspecialchars($_POST["time_slot"]);
$status = htmlspecialchars($_POST["status"]);
$staffId = $user["staff_id"];

// check if the current time slot already exists for this staff
$stmt = $conn->prepare("SELECT * FROM time_slot WHERE time = ? AND staff_id = ? AND time_slot_id != ?");
$stmt->bind_param("sss", $time, $staffId, $timeSlotId);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    echo "
        <script>
            alert('Time slot already exists.');
            window.location='edit-time-slot.php';
        </script>
        ";
    exit();
}

$stmt = $conn->prepare("UPDATE time_slot SET time = ?, status = ? WHERE time_slot_id = ?");
$stmt->bind_param("sss", $time, $status, $timeSlotId);
$result = $stmt->execute();

if (!$result) {
    echo "
        <script>
            alert('Failed to update time slot. Error: $conn->error');
            window.location='edit-time-slot.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Time slot updated successfully.');
            window.location='time-slots.php';
        </script>
        ";
}

?>