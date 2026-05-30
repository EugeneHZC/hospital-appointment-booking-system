<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href=../../styles.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
  <script src="../../scripts/load-page.js"></script>
  <title>Hospital Islam Azzahrah Appointment Booking System</title>

  <!-- for testing purposes only -->
  <input type="hidden" value="admin" name="role" id="role" />
</head>

<body>
  <div id="container">
    <?php include("../../components/admin/side-nav.html") ?>
    <main>
      <header>
        <h1>Appointment Details</h1>
        <p id="role-view"></p>
      </header>

      <div id="content">
        <div id="user-info-card" class="card">
          <h3>Patient name</h3>
          <div id="user-sub-info">
            <p class="text-gray">
              <i class="fa-solid fa-book-medical"></i>Appointment Type
            </p>
            <p class="text-gray">
              <i class="fa-solid fa-calendar"></i>20/05/2026
            </p>
            <p class="text-gray">
              <i class="fa-solid fa-clock"></i>2:00 p.m.
            </p>
          </div>
        </div>

        <form>
          <div class="display-cards">
            <div class="display-card-top-bottom card">
              <div class="display-card-top">
                <h3>Remarks</h3>
              </div>
              <br />
              <div class="display-card-bottom">
                <textarea name="remarks" id="remarks" class="form-control" rows="5"></textarea>
              </div>
            </div>

            <div class="display-card-top-bottom card">
              <div class="display-card-top">
                <h3>Follow-up Appointment</h3>
              </div>

              <br />

              <div class="display-card-bottom">
                <div class="row">
                  <div class="form-group">
                    <label for="appointment-date">Appointment Date</label>
                    <input type="date" class="form-control" name="appointment-date" id="appointment-date" />
                  </div>

                  <div class="form-group">
                    <label for="appointment-time">Appointment Time</label>
                    <select name="appointment-time" id="appointment-time" class="form-control">
                      <option value="" disabled selected>
                        Select a time slot
                      </option>
                      <option value="2.00p.m.">2.00p.m.</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="btns">
            <button class="btn btn-info" type="submit" id="appointment-details-save-btn">
              Save
            </button>
            <button class="btn btn-secondary" type="reset" id="appointment-details-cancel-btn">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>