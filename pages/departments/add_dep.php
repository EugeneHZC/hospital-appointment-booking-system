<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

$role = $_SESSION["role"];

if ($role !== "Admin") 
{
    echo "<meta http-equiv='refresh' content='3;URL=../appointments/appointments.php' />";
    die("Only admins can view this page.");
}

if(isset($_POST['save']))
{
    $department_id = generate_id(
        "department",
        "department_id",
        "DEP"
    );

    $department_name = $_POST['department_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    $sql = "
    INSERT INTO department
    (
        department_id,
        department_name,
        description,
        location
    )
    VALUES
    (
        '$department_id',
        '$department_name',
        '$description',
        '$location'
    )
    ";

    if(mysqli_query($conn,$sql))
    {
        echo "
        <script>
            alert('Department added successfully');
            window.location='departments.php';
        </script>
        ";
    }
}
?>
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
</head>
<body>
<div id="container">
    <?php include("../../components/side-nav.php"); ?>
    <main>
        <header>
            <button id="nav-toggle" class="btn btn-info">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <h1>Add Department</h1>
                <p id="role-view">
                    <?php echo $role; ?>'s View
                </p>
            </div>
        </header>
        <section id="content">
            <div class="card"
            style="
                max-width:900px;
                margin:auto;
                padding:25px;
            ">
            <form method="POST">
                <div>
                    <label>Department ID</label>
                    <input
                        type="text"
                        class="form-control"
                        value="Auto Generate"
                        readonly
                    >
                </div>
                <br>
                <div>
                    <label>Department Name</label>
                    <input
                        type="text"
                        name="department_name"
                        class="form-control"
                        required
                    >
                </div>
                <br>
                <div>
                    <label>Description</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="5"
                        required>
                    </textarea>
                </div>
                <br>
                <div>
                    <label>Location</label>
                    <input
                        type="text"
                        name="location"
                        class="form-control"
                        required
                    >
                </div>
                <br>
                <div class="row"
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
                        name="save"
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
<?php
$conn->close();
?>