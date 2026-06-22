<?php
include('../../helper/connect.php');

$departmentId = $_GET["department_id"];
$staffId = $_GET["doctor_id"];
$startDate = $_GET["start_date"];
$endDate = $_GET["end_date"];

$statuses = ["Scheduled", "Completed", "Cancelled"];
$statistics = [];

// get number of total appointments
if ($staffId != "") {
    $sql = "SELECT COUNT(*) as total_appointments FROM appointment WHERE staff_id = '$staffId'";
} else if ($departmentId != "") {
    $sql = "SELECT COUNT(*) as total_appointments FROM appointment
    JOIN staff
    USING (staff_id)
    WHERE staff.department_id = '$departmentId'";
} else {
    $sql = "SELECT COUNT(*) as total_appointments FROM appointment WHERE 1 = 1";
}

if ($startDate != "" && $endDate != "") {
    $sql = $sql . " AND date BETWEEN '$startDate' AND '$endDate'";
}

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $statistics["total_appointments"] = $row["total_appointments"];
}



// get number of appointments for each status
foreach ($statuses as $s) {
    $key = strtolower($s);
    if ($staffId != "") {
        $sql = "SELECT COUNT(*) as " . $key . "_appointments FROM appointment WHERE status = '$s' AND staff_id = '$staffId'";
    } else if ($departmentId != "") {
        $sql = "SELECT COUNT(*) as " . $key . "_appointments FROM appointment
        JOIN staff
        USING (staff_id)
        WHERE status = '$s'
        AND staff.department_id = '$departmentId'";
    } else {
        $sql = "SELECT COUNT(*) as " . $key . "_appointments FROM appointment WHERE status = '$s'";
    }

    if ($startDate != "" && $endDate != "") {
        $sql = $sql . " AND date BETWEEN '$startDate' AND '$endDate'";
    }

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $statistics[$key . "_appointments"] = $row[$key . "_appointments"];
    }
}



// get number of total articles
if ($staffId != "") {
    $sql = "SELECT COUNT(*) as total_articles FROM article WHERE status = 'Approved' AND staff_id = '$staffId'";
} else if ($departmentId != "") {
    $sql = "SELECT COUNT(*) as total_articles FROM article
    JOIN staff
    USING (staff_id)
    JOIN department
    USING (department_id)
    WHERE status = 'Approved'
    AND department_id = '$departmentId'";
} else {
    $sql = "SELECT COUNT(*) as total_articles FROM article WHERE status = 'Approved'";
}

if ($startDate != "" && $endDate != "") {
    $sql = $sql . " AND (publish_datetime BETWEEN '$startDate' AND '$endDate')";
}

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $statistics["total_articles"] = $row["total_articles"];
}

echo json_encode($statistics);
?>