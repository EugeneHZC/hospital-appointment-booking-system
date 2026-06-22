<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role !== "Admin") {
    echo "
        <script>
            alert('Only admins can view this page.');
            window.location='../appointments/appointments.php';
        </script>
        ";
}

if (!isset($_GET['id'])) {
    header("Location: departments.php");
    exit();
}

$department_id = $_GET['id'];

$stmt = $conn->prepare("SELECT *
FROM department
WHERE department_id = ?");

$stmt->bind_param("s", $department_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch department info.');
        </script>
        ";
    exit();
}

$data = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <title>Hostpital Islam Azzahrah Appointment Booking System - Edit Department</title>
</head>

<body>
    <div id="container">
        <?php include("../../components/side-nav.php"); ?>
        <main>
            <header>
                <button id="nav-toggle" class="btn btn-info">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1>Edit Department</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>
            <section id="content">
                <div class="card">
                    <form method="post" action="update_department.php">
                        <input type="hidden" value="<?php echo $data["department_id"] ?>" name="department_id">
                        <div class="form-group">
                            <label>Department Name</label>
                            <input type="text" name="department_name" class="form-control" value="<?php echo $data['department_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="5" required><?php echo $data['description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="<?php echo $data['location']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Active" <?php echo $data["status"] == "Active" ? "selected" : ""; ?>>Active</option>
                                <option value="Inactive" <?php echo $data["status"] == "Inactive" ? "selected" : ""; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='departments.php'">
                                Cancel
                            </button>
                            <button type="submit" name="update" class="btn btn-info">
                                Update Department
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
<?php
$conn->close();
?>