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
    <title>Hostpital Islam Azzahrah Appointment Booking System - Add Department</title>
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
                    <h1>Add Department</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>
            <section id="content">
                <div class="card">
                    <form method="post" action="insert_dep.php">
                        <div class="form-group">
                            <label>Department Name</label>
                            <input type="text" name="department_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="btns">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='departments.php'">
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