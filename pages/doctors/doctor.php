<?php

include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role !== "Admin") 
{
    echo "<meta http-equiv='refresh' content='3;URL=../appointments/appointments.php' />";
    die("Only admins can view this page.");
}


if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM staff
        WHERE staff_id='$id'
        AND role='Doctor'"
    );

    header("Location: doctor.php");
    exit();
}

$search = "";

if(isset($_GET['search']))
{
    $search = $_GET['search'];
}



$search = mysqli_real_escape_string($conn,$search);

$sql = "

SELECT
    s.staff_id,
    s.name,
    s.specialty,
    d.department_name
FROM staff s
LEFT JOIN department d
ON s.department_id = d.department_id
WHERE s.role='Doctor'
AND

(

    s.staff_id LIKE '%$search%'
    OR
    s.name LIKE '%$search%'
    OR
    s.specialty LIKE '%$search%'
    OR
    d.department_name LIKE '%$search%'
)

ORDER BY s.staff_id ASC

";

$result = mysqli_query($conn,$sql);

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
                        Doctor Management
                    </h1>

                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>

                </div>

            </header>

            <section id="content">

                <form method="GET">
                    <div class="row" id="article-search">

                        <label for="search-bar">
                            Search
                        </label>

                        <input
                            type="search"
                            name="search"
                            id="search-bar"
                            class="form-control"
                            placeholder="Search doctor by ID, name, department or speciality"
                            value="<?php echo $search; ?>"
                        >


                        <button
                            type="submit"
                            class="btn btn-info">
                            Search
                        </button>

                        <button
                            type="button"
                            class="btn btn-info"
                            onclick="window.location.href='add_doctor.php'">
                            Add Doctor
                        </button>

                    </div>

                </form>

                <div class="display-cards">

                    <?php
                    while($row = mysqli_fetch_assoc($result))
                    {

                    ?>

                    <div class="display-card-top-bottom card">
                        <div class="display-card-top">
                            <div>
                                <h3>
                                    <?php echo $row['name']; ?>
                                </h3>

                                <p>
                                    Doctor ID :
                                    <?php echo $row['staff_id']; ?>
                                </p>

                                <p>
                                    Department :
                                    <?php echo $row['department_name']; ?>
                                </p>

                                <p>
                                    Speciality :
                                    <?php echo $row['specialty']; ?>
                                </p>

                            </div>
                            <div class="btns">

                                <button
                                    class="btn btn-info"
                                    onclick="window.location.href='edit_doctor.php?id=<?php echo $row['staff_id']; ?>'">
                                    Edit
                                </button>

                                <button
                                    class="btn btn-danger"
                                    onclick="return confirm('Delete this doctor?')">
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