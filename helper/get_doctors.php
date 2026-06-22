<?php
include('connect.php');

if (!isset($_GET["department_id"]) || $_GET["department_id"] == "") {
    $stmt = $conn->prepare("SELECT * FROM staff");
} else {
    $departmentId = $_GET["department_id"];
    $stmt = $conn->prepare("SELECT * FROM staff WHERE department_id = ?");
    $stmt->bind_param("s", $departmentId);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo json_encode([]);
    exit();
}

$doctors = [];
while ($row = $result->fetch_assoc()) {
    if (!isset($_GET["status"]) || $row["status"] == $_GET["status"]) {
        array_push($doctors, $row);
    }
}

echo json_encode($doctors);
?>