<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Invalid request method.");
}

if (!isset($_POST["time_slot"])) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
    die("Please select a time slot.");
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = '$email'");
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("Failed to fetch user. Error: $conn->error");
}

if ($result->num_rows == 0) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("User not found.");
}

$user = $result->fetch_assoc();
$timeSlotId = generateId("time_slot", 2, 3);
$time = $_POST["time_slot"];
$status = $_POST["status"];
$staffId = $user["staff_id"];

$stmt = $conn->prepare("INSERT INTO time_slot (time_slot_id, time, status, staff_id)
VALUES (?, ?, ?, ?)");

$stmt->bind_param("ssss", $timeSlotId, $time, $status, $staffId);
$result = $stmt->execute();

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
    die("Failed to add time slot. Error: $conn->error");
} else {
    echo "Time slot added successfully.";
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
}

?>