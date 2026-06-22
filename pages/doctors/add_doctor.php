<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

$role = $_SESSION["role"];

if ($role !== "Admin") {
    echo "<meta http-equiv='refresh' content='3;URL=../appointments/appointments.php' />";
    die("Only admins can view this page.");
}

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
    <title>
        Add Doctor
    </title>

    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
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
                    <h1>
                        Add Doctor
                    </h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>

            <section id="content">
                <div class="card">
                    <form method="post" action="insert_doctor.php">
                        <div class="form-group">
                            <label>Doctor Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="" selected disabled>Select a gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Phone Number</label>
                                <input type="text" name="phone_no" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label>
                                    Department
                                </label>

                                <select name="department_id" class="form-control" required>
                                    <option>
                                        Select Department
                                    </option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row['department_id']; ?>">
                                            <?php echo $row['department_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Speciality</label>
                                <input type="text" name="specialty" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" rows="5" class="form-control"></textarea>
                        </div>

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