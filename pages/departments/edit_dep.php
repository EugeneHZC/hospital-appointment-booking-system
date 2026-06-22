<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role !== "Admin") 
{
    echo "<meta http-equiv='refresh' content='3;URL=../appointments/appointments.php' />";
    die("Only admins can view this page.");
}

if(!isset($_GET['id']))
{ 
    header("Location: departments.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT *
     FROM department
     WHERE department_id='$id'"
);

$data = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $department_name = $_POST['department_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    mysqli_query(
        $conn,
        "UPDATE department
         SET
             department_name='$department_name',
             description='$description',
             location='$location'
         WHERE department_id='$id'"
    );

    echo "
    <script>
        alert('Department updated successfully');
        window.location='departments.php';
    </script>
    ";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
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
                <h1>Edit Department</h1>
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
                            value="<?php echo $data['department_id']; ?>"
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
                            value="<?php echo $data['department_name']; ?>"
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
                        ><?php echo $data['description']; ?></textarea>
                    </div>
                    <br>
                    <div>
                        <label>Location</label>
                        <input
                            type="text"
                            name="location"
                            class="form-control"
                            value="<?php echo $data['location']; ?>"
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
                            onclick="window.location.href='departments.php'"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            name="update"
                            class="btn btn-info"
                        >
                            Update Department
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