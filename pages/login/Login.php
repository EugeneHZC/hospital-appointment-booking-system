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
    <title>Hospital Islam Azzahrah | Login</title>
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
        </div>

        <div class="auth-content">
          <div class="auth-title my-half">
            <h2>Login</h2>
            <p>Sign in with your registered email and password.</p>
          </div>

          <form action="#" method="post">
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
              <label for="password">Password</label>
              <input
                class="form-control"
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
              />
            </div>

            <div class="form-group">
              <label for="account-type">Account Type</label>
              <select
                class="form-control"
                id="account-type"
                name="account_type"
                required
              >
                <option value="">Choose account type</option>
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
                <option value="admin">Admin</option>
              </select>
            </div>

            <div class="auth-actions">
              <label class="remember-me">
                <input type="checkbox" name="remember" />
                Remember me
              </label>
              <a href="#">Forgot password?</a>
            </div>

            <button class="btn btn-info my-half" type="submit">
              <i class="fa-solid fa-right-to-bracket"></i>Sign In
            </button>
          </form>

          <p class="auth-footer">
            New patient?
            <a href="NewPatient.php">Create your patient account</a>
          </p>
        </div>
      </section>
    </div>
  </body>
</html>
