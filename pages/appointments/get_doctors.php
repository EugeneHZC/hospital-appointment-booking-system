<?php
include('../../helper/connect.php');

if (!isset($_GET["department_id"])) {
    echo json_encode([]);
}

$departmentId = $_GET["department_id"];
$sql = "SELECT * FROM staff WHERE department_id = '$departmentId'";
$result = $conn->query($sql);

if (!$result) {
    json_encode([]);
}

$doctors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($doctors, $row);
    }
}

echo json_encode($doctors);
?>