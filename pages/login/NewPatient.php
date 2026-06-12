<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/styles.css" />
    <script
      src="https://kit.fontawesome.com/d29bed84f6.js"
      crossorigin="anonymous"
    ></script>
    <title>Hospital Islam Azzahrah | New Patient</title>
  </head>
  <body class="auth-page">
    <div class="auth-container">
      <section class="card auth-card">
        <div class="auth-header">
          <div class="auth-brand">
            <img
              class="auth-logo"
              src="logo-azzahrah.png"
              alt="Hospital Islam Azzahrah logo"
            />
            <div class="auth-title">
              <h1>Hospital Islam Azzahrah</h1>
              <p>Appointment Booking System</p>
            </div>
          </div>
          <a href="Login.html">
            <i class="fa-solid fa-arrow-left"></i>Back to Login
          </a>
        </div>

        <div class="auth-content">
          <div class="auth-title my-half">
            <h2>New Patient Sign In</h2>
            <p>Create a patient profile so you can request and manage appointments.</p>
          </div>

          <form action="#" method="post">
            <div class="auth-grid">
              <div class="form-group">
                <label for="name">Full Name</label>
                <input
                  class="form-control"
                  type="text"
                  id="name"
                  name="name"
                  placeholder="Enter full name"
                  required
                />
              </div>

              <div class="form-group">
                <label for="ic-number">IC Number</label>
                <input
                  class="form-control"
                  type="text"
                  id="ic-number"
                  name="ic_number"
                  placeholder="Example: 010203101234"
                  required
                />
              </div>

              <div class="form-group">
                <label for="email">Email Address</label>
                <input
                  class="form-control"
                  type="email"
                  id="email"
                  name="email"
                  placeholder="example@email.com"
                  required
                />
              </div>

              <div class="form-group">
                <label for="phone-no">Phone Number</label>
                <input
                  class="form-control"
                  type="tel"
                  id="phone-no"
                  name="phone_no"
                  placeholder="Example: 0123456789"
                  required
                />
              </div>

              <div class="form-group">
                <label for="date-of-birth">Date of Birth</label>
                <input
                  class="form-control"
                  type="date"
                  id="date-of-birth"
                  name="date_of_birth"
                  required
                />
              </div>

              <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                  <option value="">Choose gender</option>
                  <option value="female">Female</option>
                  <option value="male">Male</option>
                </select>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input
                  class="form-control"
                  type="password"
                  id="password"
                  name="password"
                  placeholder="Create password"
                  required
                />
              </div>

              <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input
                  class="form-control"
                  type="password"
                  id="confirm-password"
                  name="confirm_password"
                  placeholder="Confirm password"
                  required
                />
              </div>

              <div class="form-group auth-full">
                <label for="address">Address</label>
                <textarea
                  class="form-control"
                  id="address"
                  name="address"
                  placeholder="Enter home address"
                  rows="4"
                ></textarea>
              </div>
            </div>

            <div class="auth-actions">
              <button class="btn btn-info" type="submit">
                <i class="fa-solid fa-user-plus"></i>Create Patient Account
              </button>
              <p>
                Already registered?
                <a href="Login.php">Login here</a>
              </p>
            </div>
          </form>
        </div>
      </section>
    </div>
  </body>
</html>
