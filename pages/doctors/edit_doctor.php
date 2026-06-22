<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

$role = $_SESSION["role"];

if ($role !== "Admin") {
    echo "
        <script>
            alert('Only admins can view this page.');
            window.location='../appointments/appointments.php';
        </script>
        ";
}

if (!isset($_GET["staff_id"])) {
    echo "
        <script>
            alert('Staff ID required.');
            window.location='doctor.php';
        </script>
        ";
}

$staffId = $_GET["staff_id"];

$stmt = $conn->prepare("SELECT * FROM staff WHERE staff_id = ? LIMIT 1");
$stmt->bind_param("s", $staffId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch doctor info.');
            window.location='doctor.php';
        </script>
        ";
}

$doctor = $result->fetch_assoc();

$stmt = $conn->prepare("SELECT * FROM department ORDER BY department_name");
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch departments.');
            window.location='doctor.php';
        </script>
        ";
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System - Edit Doctor</title>
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
                    <h1>Edit Doctor</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>
            <section id="content">
                <div class="card">
                    <form method="post" action="update_doctor.php">
                        <input type="hidden" name="staff_id" value="<?php echo $doctor["staff_id"]; ?>">
                        <div class="form-group">
                            <label>Doctor Name</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo $doctor["name"]; ?>">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" required value="<?php echo $doctor["email"]; ?>">
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="" disabled>Select a gender</option>
                                    <option value="M" <?php echo $doctor["gender"] == 'M' ? "selected" : "" ?>>Male</option>
                                    <option value="F" <?php echo $doctor["gender"] == 'F' ? "selected" : "" ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_no" class="form-control" required value="<?php echo $doctor["phone_no"] ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>Department</label>
                                <select name="department_id" class="form-control" required>
                                    <option>Select Department</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row['department_id']; ?>" <?php echo $doctor["department_id"] == $row["department_id"] ? "selected" : "" ?>>
                                            <?php echo $row['department_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Speciality</label>
                                <input type="text" name="specialty" class="form-control" required value="<?php echo $doctor["specialty"]; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Active" <?php $doctor["status"] == "Active" ? "selected" : "" ?>>Active</option>
                                <option value="Inactive" <?php $doctor["status"] == "Inactive" ? "selected" : "" ?>>Inactive</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" rows="5" class="form-control"><?php echo $doctor["bio"]; ?></textarea>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='doctor.php'">
                                Cancel
                            </button>
                            <button type="submit" name="save" class="btn btn-info">
                                <i class="fa-solid fa-save"></i>Save
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