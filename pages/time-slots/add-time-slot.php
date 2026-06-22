<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role === "Patient") {
    echo "
      <script>
          alert('Only admins and doctors can view this page.');
          window.location='../appointments/appointments.php';
      </script>
      ";
    exit();
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
    <script src="../../scripts/time-slot.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System - Add Time Slot</title>
</head>

<body>
    <div id="container">
        <?php include("../../components/side-nav.php") ?>
        <main>
            <header>
                <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
                <div>
                    <h1>Add Time Slot</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>

            <div id="content">
                <form action="insert_time_slot.php" method="post">
                    <div class="display-cards">
                        <div class="display-card-top-bottom card">
                            <div class="display-card-bottom">

                                <div class="form-group">
                                    <label for="time-slot">Time Slot</label>
                                    <input required type="time" name="time_slot" id="time-slot" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select type="text" name="status" id="status" class="form-control">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-secondary" id="cancel-btn" type="button">
                                        Cancel
                                    </button>
                                    <button class="btn btn-info" type="submit" id="save-btn"><i class="fa-solid fa-floppy-disk"></i>
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>

<?php
$conn->close();
?>