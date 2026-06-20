<?php
session_start();

if(isset($_POST['submit'])){
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $servername = "localhost:3301";
  $username = "root";
  $dbPassword = "1234";
  $dbname = "azzahrahappointmentsystem";

  $conn = new mysqli($servername, $username, $dbPassword, $dbname);

  if($conn->connect_error){
    echo "<script>alert('Database connection failed. Please try again later.');</script>";
  } else {
    $patientSql = "SELECT email FROM patient WHERE email = ? AND password = ?";
    $patientStmt = $conn->prepare($patientSql);
    $patientStmt->bind_param("ss", $email, $password);
    $patientStmt->execute();
    $patientResult = $patientStmt->get_result();

    if($patientResult->num_rows == 1){
      $_SESSION["email"] = $email;
      $_SESSION["role"] = "Patient";
      header("Location: ../patient/appointments.php");
      exit();
    }

    $staffSql = "SELECT role FROM staff WHERE email = ? AND password = ?";
    $staffStmt = $conn->prepare($staffSql);
    $staffStmt->bind_param("ss", $email, $password);
    $staffStmt->execute();
    $staffResult = $staffStmt->get_result();

    if($staffResult->num_rows == 1){
      $staff = $staffResult->fetch_assoc();
      $role = ucfirst(strtolower(trim($staff["role"])));

      if($role == "Doctor"){
        $_SESSION["email"] = $email;
        $_SESSION["role"] = "Doctor";
        header("Location: ../doctor/dashboard.php");
        exit();
      } else if($role == "Admin"){
        $_SESSION["email"] = $email;
        $_SESSION["role"] = "Admin";
        header("Location: ../admin/dashboard.php");
        exit();
      }
    }

    session_unset();
    echo "<script>alert('Invalid username or password. Please try again.');</script>";
    $conn->close();
  }
}
?>


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

          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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

            <div class="auth-actions">
              <label class="remember-me">
                <input type="checkbox" name="remember" />
                Remember me
              </label>
              <a href="#">Forgot password?</a>
            </div>

            <button class="btn btn-info my-half" type="submit" name="submit">
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
