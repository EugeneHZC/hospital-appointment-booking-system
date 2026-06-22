<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$email = $_SESSION["email"];
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

$stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
  echo "
      <script>
          alert('Failed to fetch user. Error: $conn->error');
          window.location='../dashboard/dashboard.php';
      </script>
      ";
  exit();
}

$user = $result->fetch_assoc();
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
  <title>Hospital Islam Azzahrah Appointment Booking System - Time Slots</title>
</head>

<body>
  <div id="container">
    <?php include("../../components/side-nav.php") ?>
    <main>
      <header>
        <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
        <div>
          <h1>Time Slots</h1>
          <p id="role-view">
            <?php echo $role; ?>'s View
          </p>
        </div>
      </header>

      <div id="content">
        <div id="article-search" class="row">
          <label for="search-bar">Search</label>
          <input type="search" name="search-bar" id="search-bar" class="form-control" placeholder="Search for time slots" />
          <button class="btn btn-info" id="add-time-slot-btn"><i class="fa-solid fa-plus"></i>
            Add Time Slot
          </button>
        </div>

        <div class="display-cards">
          <?php
          $staffId = $user["staff_id"];
          $stmt = $conn->prepare("SELECT * FROM time_slot WHERE staff_id = ? ORDER BY time_slot_id DESC");
          $stmt->bind_param("s", $staffId);
          $stmt->execute();
          $result = $stmt->get_result();

          if (!$result) {
            echo "
              <script>
                  alert('Failed to fetch time slots. Error: $conn->error');
                  window.location='../dashboard/dashboard.php';
              </script>
              ";
            exit();
          }

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $timeSlotId = $row["time_slot_id"];
              ?>
              <div class="display-card-left-right card" data-time="<?php echo $row["time"]; ?>">
                <div class="display-card-left">
                  <h3><?php echo $row["time"]; ?></h3>
                  <p class="text-<?php echo $row["status"] == "Active" ? "success" : "danger" ?>"><i
                      class="fa-solid fa-circle-<?php echo $row["status"] == "Active" ? "check" : "xmark"; ?>"></i><?php echo $row["status"]; ?></p>
                </div>

                <div class="display-card-right">
                  <div>
                    <a class="btn btn-info" href="edit-time-slot.php?time_slot_id=<?php echo $timeSlotId; ?>"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
                  </div>
                </div>
              </div>

              <?php
            }
          }
          ?>
        </div>
      </div>
    </main>
  </div>
</body>

</html>

<?php
$conn->close();
?>