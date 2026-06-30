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

if (!isset($_GET["time_slot_id"])) {
    echo "
      <script>
          alert('Time slot id required.');
          window.location='time-slots.php';
      </script>
      ";
    exit();
}

$timeSlotId = $_GET["time_slot_id"];
$stmt = $conn->prepare("SELECT * FROM time_slot WHERE time_slot_id = ?");
$stmt->bind_param("s", $timeSlotId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "
      <script>
          alert('Failed to fetch time slot. Error: $conn->error.');
          window.location='time-slots.php';
      </script>
      ";
    exit();
}

$timeSlot = $result->fetch_assoc();
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
    <title>Hospital Islam Azzahrah Appointment Booking System - Edit Time Slot</title>
</head>

<body>
    <div id="container">
        <?php include("../../components/side-nav.php") ?>
        <main>
            <header>
                <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
                <div>
                    <h1>Edit Time Slot</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>

            <div id="content">
                <form action="update_time_slot.php" method="post">
                    <input type="hidden" name="time_slot_id" value="<?php echo $timeSlot["time_slot_id"]; ?>">
                    <div class="display-cards">
                        <div class="display-card-top-bottom card">
                            <div class="display-card-bottom">

                                <div class="form-group">
                                    <label for="time-slot">Time Slot</label>
                                    <input required type="time" name="time_slot" id="time-slot" class="form-control" value="<?php echo $timeSlot["time"] ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select type="text" name="status" id="status" class="form-control">
                                        <option value="Active" <?php echo $timeSlot["status"] == "Active" ? "selected" : "" ?>>Active</option>
                                        <option value="Inactive" <?php echo $timeSlot["status"] == "Inactive" ? "selected" : "" ?>>Inactive</option>
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