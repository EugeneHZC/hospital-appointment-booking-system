<?php
include('../../helper/connect.php');

$stmt = $conn->prepare("SELECT * FROM department");
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo json_encode([]);
    exit();
}

$departments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($departments, $row);
    }
}

echo json_encode($departments);
?>