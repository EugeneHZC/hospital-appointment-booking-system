<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hospital Islam Azzahrah Appointment Booking System - Doctor Management</title>

    <link rel="stylesheet" href="../../styles/styles.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>

    <input type="hidden" value="admin" id="role" />
</head>

<body>

    <div id="container">

        <?php include("../../components/admin/side-nav.html"); ?>

        <main>

            <header>
                <h1>Doctor Management</h1>
                <p id="role-view"></p>
            </header>

            <section id="content">

                <!-- Search + Add Button -->

                <div class="row" id="article-search">

                    <div style="flex:1;">
                        <label for="search-bar">Search</label>

                        <input
                            type="search"
                            id="search-bar"
                            class="form-control"
                            placeholder="Search doctor by ID, name, department or speciality">
                    </div>

                    <div>
                        <button
                            class="btn btn-info"
                            onclick="window.location.href='add_doctor.php'">
                            Add Doctor
                        </button>
                    </div>

                </div>

                <!-- Doctor Cards -->

                <div class="display-cards">

                    <!-- Doctor 1 -->

                    <div class="display-card-top-bottom card">

                        <div class="display-card-top">

                            <div>

                                <h3>Dr. Ahmad Firdaus</h3>

                                <p>
                                    Doctor ID : DOC001
                                </p>

                                <p>
                                    Department : Cardiology
                                </p>

                                <p>
                                    Speciality : Heart Specialist
                                </p>

                            </div>

                            <div class="btns">

                                <button
                                    class="btn btn-info"
                                    onclick="window.location.href='add_doctor.php?id=DOC001'">
                                    Edit
                                </button>

                                <button
                                    class="btn btn-danger">
                                    Delete
                                </button>

                            </div>

                        </div>

                    </div>

                    <!-- Doctor 2 -->

                    <div class="display-card-top-bottom card">

                        <div class="display-card-top">

                            <div>

                                <h3>Dr. Nur Aisyah</h3>

                                <p>
                                    Doctor ID : DOC002
                                </p>

                                <p>
                                    Department : Paediatrics
                                </p>

                                <p>
                                    Speciality : Child Healthcare
                                </p>

                            </div>

                            <div class="btns">

                                <button
                                    class="btn btn-info"
                                    onclick="window.location.href='add_doctor.php?id=DOC002'">
                                    Edit
                                </button>

                                <button
                                    class="btn btn-danger">
                                    Delete
                                </button>

                            </div>

                        </div>

                    </div>

                    <!-- Doctor 3 -->

                    <div class="display-card-top-bottom card">

                        <div class="display-card-top">

                            <div>

                                <h3>Dr. Siti Hajar</h3>

                                <p>
                                    Doctor ID : DOC003
                                </p>

                                <p>
                                    Department : Orthopaedic
                                </p>

                                <p>
                                    Speciality : Bone & Joint Specialist
                                </p>

                            </div>

                            <div class="btns">

                                <button
                                    class="btn btn-info"
                                    onclick="window.location.href='add_doctor.php?id=DOC003'">
                                    Edit
                                </button>

                                <button
                                    class="btn btn-danger">
                                    Delete
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </main>

    </div>

</body>

</html>