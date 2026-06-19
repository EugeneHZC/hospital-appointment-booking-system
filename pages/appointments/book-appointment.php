<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role != "Patient") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Only patients can view this page.");
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
    <script src="../../scripts/appointments.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System - Book Appointment</title>
</head>

<body>
    <div id="container">
        <?php include("../../components/side-nav.php") ?>
        <main>
            <header>
                <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
                <div>
                    <h1>Book Appointment</h1>
                    <p id="role-view"><?php echo $role; ?>'s View</p>
                </div>
            </header>

            <div id="content">
                <form id="book-appointment-form" action="insert_appointment.php" method="post">
                    <div class="display-cards">

                        <!-- step 1: choose department -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 1: Select a department</h3>
                            </div>
                            <br />
                            <div class="display-card-bottom">
                                <select name="department" id="department" class="form-control">
                                    <option value="" selected disabled>Select a department</option>
                                    <?php
                                    $sql = "SELECT * FROM department";
                                    $result = $conn->query($sql);

                                    if (!$result) {
                                        echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
                                        die("Failed to fetch departments info. Error: $conn->error");
                                    }

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $departmentId = $row["department_id"];
                                            $departmentName = $row["department_name"];
                                            echo "<option value='$departmentId'>$departmentName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- step 2: choose doctor -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 2: Select a doctor</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <select name="doctor" id="doctor" class="form-control">
                                    <option value="" selected disabled>Select a doctor</option>
                                </select>
                            </div>
                        </div>

                        <!-- step 3: choose date -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 3: Select a date</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <input type="date" name="date" id="date" class="form-control" min="<?php echo Date('Y-m-d'); ?>">
                            </div>
                        </div>

                        <!-- step 4: choose time slot -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 4: Select a time slot</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <select name="time" id="time" class="form-control">
                                    <option value="" selected disabled>Select a time slot</option>
                                </select>
                            </div>
                        </div>

                        <!-- step 5: choose appointment type -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 5: Select appointment type</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <select name="appointment_type" id="appointment-type" class="form-control">
                                    <option value="">Select appointment type</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Checkup">Checkup</option>
                                    <option value="Follow-up Appointment">Follow-up Appointment</option>
                                </select>
                            </div>
                        </div>

                        <!-- optional: leave remarks for doctor -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Optional: Remarks for doctor</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <textarea name="remarks_for_doctor" id="remarks-for-doctor" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-secondary" type="button" id="cancel-btn">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-info" id="save-remarks-btn">
                            <i class="fa-solid fa-save"></i> Book
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>