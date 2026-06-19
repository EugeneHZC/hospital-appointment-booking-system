<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
// include('../../helper/generate_id.php');

$email = $_SESSION["email"];
$userSql = "SELECT * FROM staff WHERE email = '$email'";
$userResult = $conn->query($userSql);

if (!$userResult) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("Failed to fetch user. Error: $conn->error");
}

if ($userResult->num_rows == 0) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("User not found.");
}

if (!isset($_POST["time_slot"])) {
    echo "<meta http-equiv='refresh' content='3;URL=add-time-slot.php' />";
    die("Please select a time slot.");
}

$user = $userResult->fetch_assoc();
$timeSlotId = $_POST["time_slot_id"];
$time = $_POST["time_slot"];
$status = $_POST["status"];
$staffId = $user["staff_id"];

$sql = "UPDATE time_slot SET time = '$time', status = '$status' WHERE time_slot_id = '$timeSlotId'";
$result = $conn->query($sql);

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("Failed to update time slot. Error: $conn->error");
} else {
    echo "Time slot updated successfully.";
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
}

?>