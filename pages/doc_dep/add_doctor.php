<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Add Doctor</title>

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
            <h1>Add Doctor</h1>
            <p id="role-view"></p>
        </header>

        <section id="content">

            <div class="card" style="max-width:900px;margin:auto;">

                <form action="" method="POST">

                    <div class="row">

                        <div style="flex:1;">
                            <label>Doctor ID</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="DOC001">
                        </div>

                        <div style="flex:1;">
                            <label>Doctor Name</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Dr. Ahmad Firdaus">
                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div style="flex:1;">
                            <label>Department</label>

                            <select class="form-control">

                                <option>Select Department</option>
                                <option>Cardiology</option>
                                <option>Orthopaedic</option>
                                <option>Paediatrics</option>
                                <option>Neurology</option>

                            </select>
                        </div>

                        <div style="flex:1;">
                            <label>Speciality</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Heart Specialist">
                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div style="flex:1;">
                            <label>Email</label>
                            <input
                                type="email"
                                class="form-control"
                                placeholder="doctor@email.com">
                        </div>

                        <div style="flex:1;">
                            <label>Phone Number</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="+60 12-3456789">
                        </div>

                    </div>

                    <br>

                    <div>

                        <label>Description</label>

                        <textarea
                            rows="5"
                            class="form-control"
                            placeholder="Doctor description"></textarea>

                    </div>

                    <br>

                    <div class="row" style="justify-content:flex-end;gap:10px;">

                        <button
                            type="button"
                            class="btn btn-danger"
                            onclick="window.location.href='doctor.php'">

                            Cancel

                        </button>

                        <button
                            type="submit"
                            class="btn btn-info">

                            Save

                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

</body>
</html>