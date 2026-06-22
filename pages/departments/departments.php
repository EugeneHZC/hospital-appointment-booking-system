<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role !== "Admin") {
    echo "<meta http-equiv='refresh' content='3;URL=../appointments/appointments.php' />";
    die("Only admins can view this page.");
}

$stmt = $conn->prepare("SELECT * FROM department");
$stmt->execute();
$result = $stmt->get_result();

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Management</title>
    <link rel="stylesheet" href="../../styles/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <script src="../../scripts/departments.js"></script>
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
                    <h1>Department Management</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>

            <section id="content">
                <div id="department-search" class="row">
                    <label for="search-bar">Search</label>
                    <input type="search" name="search" id="search-bar" class="form-control" placeholder="Search for departments by department name, location or description" />
                    <?php
                    if ($role != "Patient") {
                        ?>
                        <a type="button" class="btn btn-info" href="add_dep.php">
                            Add Department
                        </a>
                        <?php
                    }
                    ?>
                </div>

                <div class="display-cards">
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $staffStmt = $conn->prepare("SELECT COUNT(*) no_of_staff FROM staff WHERE department_id = ?");
                            $staffStmt->bind_param("s", $row["department_id"]);
                            $staffStmt->execute();
                            $staffResult = $staffStmt->get_result();
                            $staffRow = $staffResult->fetch_assoc();
                            $docCount = $staffRow["no_of_staff"];
                            ?>
                            <div class="display-card-left-right card" data-departmentname="<?php echo $row["department_name"]; ?>" data-location="<?php echo $row["location"]; ?>"
                                data-description="<?php echo $row["description"]; ?>">
                                <div class="display-card-left">
                                    <h3>
                                        <?php echo $row['department_name']; ?>
                                    </h3>

                                    <p class="text-<?php echo $row["status"] == "Active" ? "success" : "danger" ?>">
                                        <i class="fa-solid fa-circle-<?php echo $row["status"] == "Active" ? "check" : "xmark"; ?>"></i><?php echo $row["status"]; ?>
                                    </p>
                                    <p class="text-gray">
                                        <i class="fa-solid fa-people-group"></i>
                                        <?php echo $docCount; ?> doctors
                                    </p>
                                    <p class="text-gray">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <?php echo $row['location']; ?>
                                    </p>
                                    <p class="text-gray">
                                        <i class="fa-solid fa-list"></i>
                                        <?php echo $row['description']; ?>
                                    </p>
                                </div>
                                <div class="display-card-right">
                                    <div class="btns">
                                        <button class="btn btn-info" onclick="window.location.href='edit_dep.php?id=<?php echo $row['department_id']; ?>'">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
<?php
$conn->close();
?>