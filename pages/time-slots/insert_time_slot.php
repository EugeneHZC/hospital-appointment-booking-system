<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Invalid request method. Redirecting to appointments page.");
}

if (!isset($_POST["time_slot"])) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
    die("Please select a time slot. Redirecting to add time slot page.");
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = '$email'");
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("Failed to fetch user. Error: $conn->error. Redirecting to time slots page.");
}

if ($result->num_rows == 0) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("User not found. Redirecting to time slots page.");
}

$user = $result->fetch_assoc();
$timeSlotId = generateId("time_slot", 2, 3);
$time = $_POST["time_slot"];
$status = $_POST["status"];
$staffId = $user["staff_id"];

// check if the current time slot already exists for this staff
$stmt = $conn->prepare("SELECT * FROM time_slot WHERE time = ? AND staff_id = ? AND time_slot_id != ?");
$stmt->bind_param("sss", $time, $staffId, $timeSlotId);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
    die("Time slot already exists. Redirecting to add time slot page.");
}

// if not, proceed to adding the time slot
$stmt = $conn->prepare("INSERT INTO time_slot (time_slot_id, time, status, staff_id)
VALUES (?, ?, ?, ?)");

$stmt->bind_param("ssss", $timeSlotId, $time, $status, $staffId);
$result = $stmt->execute();

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
    die("Failed to add time slot. Error: $conn->error. Redirecting to add time slot page.");
} else {
    echo "Time slot added successfully. Redirecting to time slots page.";
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
}

?>