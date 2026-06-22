<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role !== "Admin") 
{
    echo "<meta http-equiv='refresh' content='3;URL=../appointments/appointments.php' />";
    die("Only admins can view this page.");
}

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM department
        WHERE department_id='$id'"
    );

    header("Location: departments.php");
    exit();
}

$search = "";

if(isset($_GET['search']))
{
    $search=$_GET['search'];
}

$search=mysqli_real_escape_string($conn,$search);

$result=mysqli_query(
    $conn,
    "SELECT *
     FROM department
     WHERE department_name LIKE '%$search%'
     OR department_id LIKE '%$search%'
     ORDER BY department_name"
);
?>
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
                <h1>Department Management</h1>
                <p id="role-view">
                    <?php echo $role; ?>'s View
                </p>
            </div>
        </header>
        <section id="content">
            <form method="GET">
                <div class="row">
                    <label>Search</label>
                    <input
                        type="search"
                        name="search"
                        class="form-control"
                        placeholder="Search department"
                        value="<?php echo $search; ?>"
                    >
                    <button
                        type="submit"
                        class="btn btn-info"
                    >
                        Search
                    </button>
                    <button
                        type="button"
                        class="btn btn-info"
                        onclick="window.location.href='add_dep.php'"
                    >
                        Add Department
                    </button>
                </div>
            </form>
            <div class="display-cards">
                <?php
                while($row=mysqli_fetch_assoc($result))
                {
                ?>
                <div class="display-card-top-bottom card">
                    <div class="display-card-top">
                        <h3>
                            <?php echo $row['department_name']; ?>
                        </h3>
                        <div class="btns">
                            <button
                                class="btn btn-info"
                                onclick="window.location.href='edit_dep.php?id=<?php echo $row['department_id']; ?>'"
                            >
                                Edit
                            </button>
                            <button
                                class="btn btn-danger"
                                onclick="if(confirm('Delete department?')) window.location.href='departments.php?delete=<?php echo $row['department_id']; ?>'"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                    <div class="display-card-bottom">
                        <p>
                            <strong>ID:</strong>
                            <?php echo $row['department_id']; ?>
                        </p>
                        <p>
                            <strong>Location:</strong>
                            <?php echo $row['location']; ?>
                        </p>
                        <p>
                            <?php echo $row['description']; ?>
                        </p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </section>
    </main>
</div>
</body>
</html>
<?php
$conn->close();
?>