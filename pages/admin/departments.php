<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Management</title>

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

            <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
            <header>
                <div>
                    <h1>Department Management</h1>
                    <p id="role-view"></p>
                </div>
            </header>

            <section id="content">

                <div class="row">

                    <label>Search</label>

                    <input type="search" class="form-control" placeholder="Search by department name">
                    <button class="btn btn-info" onclick="window.location.href='add_dep.php'">
                        Add Department
                    </button>

                </div>

                <div class="display-cards">

                    <!-- Department 1 -->

                    <div class="display-card-top-bottom card">

                        <div class="display-card-top">

                            <h3>Cardiology</h3>
                            <div class="btns">

                                <button class="btn btn-info" onclick="window.location.href='add_dep.php?id=DEP001'">

                                    Edit

                                </button>

                                <button class="btn btn-danger">

                                    Delete

                                </button>

                            </div>

                        </div>

                        <div class="display-card-bottom">
                            <div>


                                <p><strong>ID:</strong> DEP001</p>

                                <p><strong>Location:</strong> Level 2, Block A</p>

                                <p>
                                    Responsible for diagnosis and treatment of
                                    heart-related diseases.
                                </p>

                            </div>
                        </div>

                    </div>

                    <!-- Department 2 -->

                    <div class="display-card-top-bottom card">

                        <div class="display-card-top">

                            <h3>Orthopaedic</h3>

                            <div class="btns">

                                <button class="btn btn-info" onclick="window.location.href='add_dep.php?id=DEP002'">

                                    Edit

                                </button>

                                <button class="btn btn-danger">

                                    Delete

                                </button>

                            </div>

                        </div>

                        <div class="display-card-bottom">
                            <div>

                                <p><strong>ID:</strong> DEP002</p>

                                <p><strong>Location:</strong> Level 3, Block B</p>

                                <p>
                                    Treatment for bone, joint and muscle conditions.
                                </p>

                            </div>
                        </div>

                    </div>

                    <!-- Department 3 -->

                    <div class="display-card-top-bottom card">

                        <div class="display-card-top">

                            <h3>Paediatrics</h3>

                            <div class="btns">

                                <button class="btn btn-info" onclick="window.location.href='add_dep.php?id=DEP003'">

                                    Edit

                                </button>

                                <button class="btn btn-danger">

                                    Delete

                                </button>

                            </div>

                        </div>

                        <div class="display-card-bottom">
                            <div>

                                <p><strong>ID:</strong> DEP003</p>

                                <p><strong>Location:</strong> Level 1, Block C</p>

                                <p>
                                    Healthcare services for infants and children.
                                </p>

                            </div>
                        </div>

                    </div>

                </div>

            </section>

        </main>

    </div>

</body>

</html>