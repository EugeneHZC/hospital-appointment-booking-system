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
    <title>Hospital Islam Azzahrah Appointment Booking System - Doctor Dashboard</title>

    <input type="hidden" value="doctor" id="role">
</head>

<body>
    <div id="container">
        <?php include("../../components/doctor/side-nav.html") ?>

        <main>
            <header>
                <h1>Dashboard</h1>
                <p id="role-view"></p>
            </header>

            <section id="content">
                <div id="user-info-card" class="card">
                    <h3>Dr. Ahmad</h3>
                    <div id="user-sub-info">
                        <p><i class="fa-solid fa-envelope"></i>ahmad@example.com</p>
                        <p><i class="fa-solid fa-phone"></i>+60154325658</p>
                        <p><i class="fa-solid fa-book"></i>Senior Paediatrician</p>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" name="start-date" id="start-date" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date</label>
                        <input type="date" name="end-date" id="end-date" class="form-control" />
                    </div>
                </div>

                <div class="horizontal-cards">
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