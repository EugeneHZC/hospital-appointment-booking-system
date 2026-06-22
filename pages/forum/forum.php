<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];

if ($role != "Patient") {
  $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch user. Error: $conn->error.');
            window.location='../appointments/appointments.php';
        </script>
        ";
  }

  $staff = $result->fetch_assoc();
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
  <script src="../../scripts/forum.js"></script>
  <title>Hospital Islam Azzahrah Appointment Booking System - Forum</title>
</head>

<body>
  <div id="container">
    <?php include("../../components/side-nav.php") ?>
    <main>
      <header>
        <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
        <div>
          <h1>Forum</h1>
          <p id="role-view"><?php echo $role; ?>'s View</p>
        </div>
      </header>

      <div id="content">
        <div id="article-search" class="row">
          <label for="search-bar">Search</label>
          <input type="search" name="search-bar" id="search-bar" class="form-control" placeholder="Search for article names or content" />
          <?php
          if ($role != "Patient") {
            ?>
            <button class="btn btn-info" id="post-article-btn" type="button"><i class="fa-solid fa-plus"></i>
              Post Article
            </button>
            <?php
          }
          ?>
        </div>

        <?php
        if ($role != "Patient") {
          ?>
          <nav class="horizontal-nav" id="articles-horizontal-nav">
            <ul class="nav-links">
              <li class="nav-link active-link" data-status="Approved">
                <a>Approved</a>
              </li>
              <li class="nav-link" data-status="Pending">
                <a>Pending</a>
              </li>
              <li class="nav-link" data-status="Rejected"><a>Rejected</a></li>
            </ul>
          </nav>
          <?php
        }
        ?>

        <div class="display-cards">
          <?php
          $stmt = $conn->prepare("SELECT a.*, s1.staff_id as writer_staff_id, s1.name as writer_name, s2.name as approver_name FROM article as a
          JOIN staff as s1
          USING (staff_id)
          LEFT JOIN staff as s2
          ON a.admin_staff_id = s2.staff_id");

          $stmt->execute();
          $result = $stmt->get_result();

          if (!$result) {
            echo "
              <script>
                  alert('Failed to fetch articles. Error: $conn->error');
                  window.location='../appointments/appointments.php';
              </script>
              ";
          }

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              ?>
              <div class="display-card-top-bottom card" data-status="<?php echo $row["status"]; ?>" data-title="<?php echo $row["title"]; ?>" data-content="<?php echo $row["content"]; ?>">
                <div class="display-card-top">
                  <div>
                    <h3><?php echo $row["title"]; ?></h3>
                    <p class="text-sm text-gray my-half">
                      <i class="fa-solid fa-circle-user"></i>Written by <?php echo $row["writer_name"]; ?>
                    </p>
                    <?php
                    if (isset($row["admin_staff_id"])) {
                      ?>
                      <p class="text-sm text-gray my-half">
                        <i class="fa-solid fa-check"></i>Approved by <?php echo $row["approver_name"]; ?>
                      </p>
                      <?php
                    }
                    ?>
                  </div>

                  <?php
                  if (isset($staff) && $row["writer_staff_id"] == $staff["staff_id"]) {
                    ?>
                    <div class="btns">
                      <a class="btn btn-info" type="button" href="edit-article.php?article_id=<?php echo $row["article_id"]; ?>"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
                      <a class="btn btn-danger delete-btn" type="button" data-id="<?php echo $row["article_id"]; ?>"><i class="fa-solid fa-trash"></i>Delete</a>
                    </div>
                    <?php
                  }
                  ?>
                </div>

                <br />

                <div class="display-card-bottom">
                  <p class="line-height-3"><?php echo $row["content"]; ?></p>

                  <?php
                  if ($row["status"] == "Pending" && $role == "Admin") {
                    ?>
                    <br />

                    <div class="float-right">
                      <button class="btn btn-success approve-article-btn" data-id="<?php echo $row["article_id"]; ?>"><i class="fa-solid fa-check"></i>
                        Approve
                      </button>

                      <button class="btn btn-danger reject-article-btn" data-id="<?php echo $row["article_id"]; ?>"><i class="fa-solid fa-x"></i>
                        Reject
                      </button>
                    </div>
                    <?php
                  }
                  ?>
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