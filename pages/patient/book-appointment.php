<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <script src="../../scripts/appointments.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System - Book Appointment</title>

    <!-- for testing purposes only -->
    <input type="hidden" value="patient" name="role" id="role" />
</head>

<body>
    <div id="container">
        <?php include("../../components/patient/side-nav.html") ?>
        <main>
            <header>
                <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
                <div>
                    <h1>Book Appointment</h1>
                    <p id="role-view"></p>
                </div>
            </header>

            <div id="content">
                <!-- <div id="user-info-card" class="card">
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
                </div> -->

                <form id="book-appointment-form">
                    <div class="display-cards">

                        <!-- step 1: choose department -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 1: Select a department</h3>
                            </div>
                            <br />
                            <div class="display-card-bottom">
                                <select name="department" id="department" class="form-control">
                                    <option value="">Select a department</option>
                                    <option value="1">Heart Specialist Department</option>
                                    <option value="2">Dental Treatment Department</option>
                                    <option value="3">Children Healthcare Department</option>
                                </select>
                            </div>
                        </div>

                        <!-- step 2: choose doctor -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 2: Select a doctor</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <select name="doctor" id="doctor" class="form-control">
                                    <option value="">Select a doctor</option>
                                    <option value="1">Dr. Ahmad</option>
                                    <option value="2">Dr. Sarah</option>
                                    <option value="3">Dr. Ali</option>
                                </select>
                            </div>
                        </div>

                        <!-- step 3: choose date -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 3: Select a date</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                        </div>

                        <!-- step 4: choose time slot -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 4: Select a time slot</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <input type="time" name="time-slot" id="time-slot" class="form-control">
                            </div>
                        </div>

                        <!-- step 5: choose appointment type -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Step 5: Select appointment type</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <select name="doctor" id="doctor" class="form-control">
                                    <option value="">Select appointment type</option>
                                    <option value="1">Consultation</option>
                                    <option value="2">Checkup</option>
                                    <option value="3">Follow-up Appointment</option>
                                </select>
                            </div>
                        </div>

                        <!-- optional: leave remarks for doctor -->
                        <div class="display-card-top-bottom card">
                            <div class="display-card-top">
                                <h3>Optional: Remarks for doctor</h3>
                            </div>

                            <br />

                            <div class="display-card-bottom">
                                <textarea name="remarks-for-doctor" id="remarks-for-doctor" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="btns">
                        <button class="btn btn-secondary" type="button" id="cancel-btn">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-info" id="save-remarks-btn">
                            <i class="fa-solid fa-save"></i> Book
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>