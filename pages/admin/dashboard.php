<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../scripts/dashboard.js"></script>
    <script src="../../scripts/load-side-bar.js"></script>
    <script src="../../scripts/load-page.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System</title>

    <input type="hidden" value="admin" id="role">
</head>

<body>
    <div id="container">
        <?php include("../../components/admin/side-nav.html") ?>

        <main>
            <header>
                <h1>Dashboard</h1>
                <p>Admin's View</p>
            </header>

            <section id="content">
                <div id="user-info-card" class="card">
                    <h3>Dr. Ali</h3>
                    <div id="user-sub-info">
                        <p><i class="fa-solid fa-envelope"></i>ali@example.com</p>
                        <p><i class="fa-solid fa-phone"></i>+601890987</p>
                        <p>
                            <i class="fa-solid fa-book"></i>Head of Paediatrics Department
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="start-date">Department</label>
                        <select name="department" id="department" class="form-control">
                            <option value="">All Departments</option>
                            <option value="1">Heart Specialist Department</option>
                            <option value="2">Dental Treatment Department</option>
                            <option value="3">Children Healthcare Department</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="end-date">Doctor</label>
                        <select name="doctor" id="doctor" class="form-control">
                            <option value="">All Doctors</option>
                            <option value="1">Dr. Ahmad</option>
                            <option value="2">Dr. Sarah</option>
                            <option value="3">Dr. Ali</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date</label>
                        <input type="date" class="form-control" />
                    </div>
                </div>

                <div id="statistic-card">
                    <div id="total-appointments-card" class="card text-center">
                        <h2>3</h2>
                        <p>Total Appointment</p>
                    </div>
                    <div id="completed-appointments-card" class="card text-center">
                        <h2>3</h2>
                        <p>Completed</p>
                    </div>
                    <div id="cancelled-appointments-card" class="card text-center">
                        <h2>3</h2>
                        <p>Cancelled</p>
                    </div>
                    <div id="total-articles-written-card" class="card text-center">
                        <h2>3</h2>
                        <p>Articles Written</p>
                    </div>
                </div>

                <canvas id="chart"></canvas>
            </section>
        </main>
    </div>
</body>

</html>