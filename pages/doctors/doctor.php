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
    exit();
}

$stmt = $conn->prepare(
    "SELECT
    s.staff_id,
    s.name,
    s.specialty,
    d.department_name,
    s.status,
    s.gender
    FROM staff s
    LEFT JOIN department d
    ON s.department_id = d.department_id
    WHERE s.role = 'Doctor'
    ORDER BY s.staff_id ASC"
);

$stmt->execute();
$result = $stmt->get_result();

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Hospital Islam Azzahrah Appointment Booking System - Doctor Management
    </title>

    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <script src="../../scripts/doctors.js"></script>

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
                    <h1>Doctor Management</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>

            <section id="content">
                <div class="row" id="article-search">
                    <label for="search-bar">
                        Search
                    </label>
                    <input type="search" name="search" id="search-bar" class="form-control" placeholder="Search fpr doctor by ID, name, department or speciality">

                    <?php
                    if ($role == "Admin") {
                        ?>
                        <button type="button" class="btn btn-info" onclick="window.location.href='add_doctor.php'">
                            Add Doctor
                        </button>
                        <?php
                    }
                    ?>
                </div>

                <div class="display-cards">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="display-card-left-right card" data-name="<?php echo $row["name"]; ?>" data-specialty="<?php echo $row["specialty"]; ?>"
                            data-departmentname="<?php echo $row["department_name"]; ?>" data-gender="<?php echo $row["gender"] == "M" ? "Male" : "Female"; ?>">
                            <div class="display-card-left">
                                <h3>
                                    <?php echo $row['name']; ?>
                                </h3>
                                <p class="text-<?php echo $row["status"] == "Active" ? "success" : "danger"; ?>">
                                    <i class="fa-solid fa-circle-<?php echo $row["status"] == "Active" ? "check" : "xmark"; ?>"></i><?php echo $row['status']; ?>
                                </p>
                                <p class="text-gray">
                                    <i class="fa-solid fa-<?php echo $row['gender'] == 'M' ? 'mars' : 'venus'; ?>"></i><?php echo $row['gender'] == 'M' ? "Male" : "Female"; ?>
                                </p>
                                <p class=" text-gray">
                                    <i class="fa-solid fa-building"></i><?php echo $row['department_name']; ?>
                                </p>
                                <p class="text-gray">
                                    <i class='fa-solid fa-id-card'></i><?php echo $row['specialty']; ?>
                                </p>
                            </div>

                            <div class="display-card-right">
                                <div class="btns">
                                    <button class="btn btn-info" onclick="window.location.href='edit_doctor.php?staff_id=<?php echo $row['staff_id']; ?>'">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger" onclick="return confirm('Delete this doctor?')">
                                        Delete
                                    </button>
                                </div>
                            </div>

                        </div>

                        <?php
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