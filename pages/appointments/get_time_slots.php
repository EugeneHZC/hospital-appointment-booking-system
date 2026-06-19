<?php
include('../../helper/connect.php');

if (!isset($_GET["staff_id"])) {
    json_encode([]);
}

$staffId = $_GET["staff_id"];
$selectedDate = $_GET["selected_date"];

$sql = "SELECT * FROM time_slot
WHERE time_slot_id NOT IN (
    SELECT time_slot_id FROM appointment
    WHERE staff_id = '$staffId' 
    AND date = '$selectedDate'
)
AND staff_id = '$staffId' 
ORDER BY time ASC";

$result = $conn->query($sql);

if (!$result) {
    json_encode([]);
}

$timeSlots = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($timeSlots, $row);
    }
}

echo json_encode($timeSlots);
?>