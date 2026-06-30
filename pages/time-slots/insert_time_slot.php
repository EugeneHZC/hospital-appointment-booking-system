<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='add-time-slot.php';
        </script>
        ";
    exit();
}

if (!isset($_POST["time_slot"])) {
    echo "
        <script>
            alert('Please select a time slot.');
            window.location='add-time-slot.php';
        </script>
        ";
    exit();
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = '$email'");
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch user. Error: $conn->error.');
            window.location='time-slots.php';
        </script>
        ";
    exit();
}

$user = $result->fetch_assoc();
$timeSlotId = generateId("time_slot", 2, 8);
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
            window.location='add-time-slot.php';
        </script>
        ";
    exit();
}

// if not, proceed to adding the time slot
$stmt = $conn->prepare("INSERT INTO time_slot (time_slot_id, time, status, staff_id)
VALUES (?, ?, ?, ?)");

$stmt->bind_param("ssss", $timeSlotId, $time, $status, $staffId);
$result = $stmt->execute();

if (!$result) {
    echo "
        <script>
            alert('Failed to add time slot. Error: $conn->error');
            window.location='add-time-slot.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Time slot added successfully.');
            window.location='time-slots.php';
        </script>
        ";
}

?>