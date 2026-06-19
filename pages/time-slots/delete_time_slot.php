<?php
include('../../helper/connect.php');

if (!isset($_GET["time_slot_id"])) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("Time slot id required.");
}

$timeSlotId = $_GET["time_slot_id"];
$sql = "DELETE FROM time_slot WHERE time_slot_id = '$timeSlotId'";
$result = $conn->query($sql);

if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
    die("Failed to delete time slot. Error: $conn->error");
}

echo "<meta http-equiv='refresh' content='3;URL=time-slots.php' />";
echo "Time slot deleted.";
?>