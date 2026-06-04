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

  <!-- For testing purposes -->
  <input type="hidden" value="admin" id="role" name="role" />
</head>

<body>
  <div id="container">
    <?php include("../../components/admin/side-nav.html") ?>
    <main>
      <header>
        <h1>Time Slots</h1>
        <p id="role-view"></p>
      </header>

      <div id="content">
        <div id="article-search" class="row">
          <label for="search-bar">Search</label>
          <input type="search" name="search-bar" id="search-bar" class="form-control" placeholder="Search for time slots" />
          <button class="btn btn-info" id="add-time-slot-btn">
            Add Time Slot
          </button>
        </div>

        <div class="display-cards">
          <div class="display-card-top-bottom card">
            <div class="display-card-top">
              <p>2.00 p.m.</p>
              <div class="btns">
                <button class="btn btn-info">Edit</button>
                <button class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>

          <div class="display-card-top-bottom card">
            <div class="display-card-top">
              <p>2.00 p.m.</p>
              <div class="btns">
                <button class="btn btn-info">Edit</button>
                <button class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>
          <br />
        </div>
      </div>
    </main>
  </div>
</body>

</html>