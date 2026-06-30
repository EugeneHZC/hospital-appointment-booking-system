<?php
include('../../helper/connect.php');

if (!isset($_POST["department_id"])) {
    echo "
    <script>
        alert('Department ID required.');
        window.location='edit_dep.php';
    </script>
    ";
    exit();
}

if (isset($_POST['update'])) {
    if (!isset($_POST["department_name"]) || !isset($_POST["description"]) || !isset($_POST["location"])) {
        echo "
            <script>
                alert('Please provide all the required fields.');
                window.location='edit_dep.php';
            </script>
        ";
        exit();
    }

    $department_id = htmlspecialchars($_POST['department_id']);
    $department_name = htmlspecialchars($_POST['department_name']);
    $description = htmlspecialchars($_POST['description']);
    $location = htmlspecialchars($_POST['location']);
    $status = htmlspecialchars($_POST['status']);

    $stmt = $conn->prepare("SELECT * FROM department WHERE department_name = ? AND department_id != ?");
    $stmt->bind_param("ss", $department_name, $department_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        echo "
        <script>
            alert('Department with provided name already exists.');
            window.location='edit_dep.php';
        </script>
        ";
        exit();
    }

    $stmt = $conn->prepare("UPDATE department
        SET department_name = ?,
        description = ?,
        location = ?,
        status = ?
        WHERE department_id = ?");

    $stmt->bind_param("sssss", $department_name, $description, $location, $status, $department_id);
    $result = $stmt->execute();

    if (!$result) {
        echo "
        <script>
            alert('Failed to update department. Error: $conn->error');
            window.location='edit_dep.php';
        </script>
        ";
        exit();
    }

    echo "
    <script>
        alert('Department updated successfully.');
        window.location='departments.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('Invalid request method.');
        window.location='edit_dep.php';
    </script>
    ";
}
?>