<?php
include('../../helper/connect.php');

$sql = "SELECT * FROM department";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([]);
    exit;
}

$departments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($departments, $row);
    }
}

echo json_encode($departments);
?>