<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
<<<<<<< HEAD
    die("Invalid request method.");
=======
    die("Invalid request method. Redirecting to appointments page.");
>>>>>>> origin/main
}

if (!isset($_POST["time_slot"])) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
<<<<<<< HEAD
    die("Please select a time slot.");
=======
    die("Please select a time slot. Redirecting to add time slot page.");
>>>>>>> origin/main
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = '$email'");
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
<<<<<<< HEAD
    die("Failed to add time slot. Error: $conn->error");
} else {
    echo "Time slot added successfully. Redirecting to appointments page.";
=======
    die("Failed to add time slot. Error: $conn->error. Redirecting to add time slot page.");
} else {
    echo "Time slot added successfully. Redirecting to time slots page.";
>>>>>>> origin/main
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
}

?>