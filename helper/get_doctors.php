<?php
include('connect.php');

if (!isset($_GET["department_id"]) || $_GET["department_id"] == "") {
    $sql = "SELECT * FROM staff";
} else {
    $departmentId = $_GET["department_id"];
    $sql = "SELECT * FROM staff WHERE department_id = '$departmentId'";
}

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([]);
    exit;
}

$doctors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($doctors, $row);
    }
}

echo json_encode($doctors);
?>