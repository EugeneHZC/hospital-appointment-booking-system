<?php
include('../../helper/connect.php');

if (!isset($_GET["staff_id"])) {
    json_encode([]);
}

$staffId = $_GET["staff_id"];
$selectedDate = $_GET["selected_date"];

$stmt = $conn->prepare("SELECT * FROM time_slot
WHERE time_slot_id NOT IN (
    SELECT time_slot_id FROM appointment
    WHERE staff_id = ?
    AND date = ?
    AND status = 'Scheduled'
)
AND staff_id = ? 
AND status = 'Active'
ORDER BY time ASC");

$stmt->bind_param("sss", $staffId, $selectedDate, $staffId);
$stmt->execute();
$result = $stmt->get_result();

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