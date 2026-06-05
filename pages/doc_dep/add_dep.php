<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Department</title>

    <link rel="stylesheet" href="../../styles/styles.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>

    <input type="hidden" value="admin" id="role">

</head>

<body>

<div id="container">

    <?php include("../../components/admin/side-nav.html"); ?>

    <main>

        <header>

            <h1>Add Department</h1>
            <p id="role-view"></p>

        </header>

        <section id="content">

            <div
                class="card"
                style="
                    max-width:900px;
                    margin:auto;
                    padding:25px;
                ">

                <form action="" method="POST">

                    <div>

                        <label>Department ID</label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="DEP001"
                            required>

                    </div>

                    <br>

                    <div>

                        <label>Department Name</label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter department name"
                            required>

                    </div>

                    <br>

                    <div>

                        <label>Description</label>

                        <textarea
                            class="form-control"
                            rows="5"
                            placeholder="Enter description"
                            required></textarea>

                    </div>

                    <br>

                    <div>

                        <label>Location</label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter location"
                            required>

                    </div>

                    <br>

                    <div
                        class="row"
                        style="
                            justify-content:flex-end;
                            gap:10px;
                        ">

                        <button
                            type="button"
                            class="btn btn-danger"
                            onclick="window.location.href='departments.php'">

                            Cancel

                        </button>

                        <button
                            type="submit"
                            class="btn btn-info">

                            Save Department

                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

</body>

</html>