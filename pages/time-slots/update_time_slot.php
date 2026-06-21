<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Invalid request method.");
}

if (!isset($_POST["time_slot"])) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
<<<<<<< HEAD
    die("Please select a time slot.");
=======
    die("Time slot required. Redirecting to add time slot page.");
>>>>>>> origin/main
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
<<<<<<< HEAD
    die("Failed to fetch user. Error: $conn->error");
=======
    die("Failed to fetch user. Error: $conn->error. Redirecting to time slots page.");
>>>>>>> origin/main
}

if ($result->num_rows == 0) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
<<<<<<< HEAD
    die("User not found.");
=======
    die("User not found. Redirecting to time slots page.");
>>>>>>> origin/main
}

$user = $result->fetch_assoc();
$timeSlotId = $_POST["time_slot_id"];
$time = $_POST["time_slot"];
$status = $_POST["status"];
$staffId = $user["staff_id"];

$stmt = $conn->prepare("UPDATE time_slot SET time = ?, status = ? WHERE time_slot_id = ?");
$stmt->bind_param("sss", $time, $status, $timeSlotId);
$result = $stmt->execute();

if (!$result) {
<<<<<<< HEAD
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("Failed to update time slot. Error: $conn->error");
} else {
    echo "Time slot updated successfully. Redirecting to appointments page.";
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
=======
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
    echo "Failed to update time slot. Error: $conn->error. Redirecting to add time slot page.";
} else {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    echo "Time slot updated successfully. Redirecting to time slots page.";
>>>>>>> origin/main
}

?>