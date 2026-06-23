<?php
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if (isset($_POST['save'])) {
    $department_id = generateId("department", 1, 7);

    $department_name = $_POST['department_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("SELECT * FROM department WHERE department_name = ?");
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        echo "
        <script>
            alert('Department with provided name already exists.');
            window.location='add_dep.php';
        </script>
        ";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO department (department_id, department_name, description, location, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $department_id, $department_name, $description, $location, $status);
    $result = $stmt->execute();
    if ($result) {
        echo "
        <script>
            alert('Department added successfully.');
            window.location='departments.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Failed to add department. $conn->error');
            window.location='add_dep.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('Invalid request method.');
        window.location='add_dep.php';
    </script>
    ";
}
?>