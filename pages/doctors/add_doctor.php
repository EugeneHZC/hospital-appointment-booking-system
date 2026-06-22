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
    $staff_id = generate_id(
        "staff",
        "staff_id",
        "DOC"
    );

    $name = $_POST['name'];
    $department_id = $_POST['department_id'];
    $specialty = $_POST['specialty'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $bio = $_POST['bio'];

    $sql = "

    INSERT INTO staff
    (
        staff_id,
        name,
        role,
        email,
        phone_no,
        specialty,
        bio,
        department_id
    )

    VALUES

    (
        '$staff_id',
        '$name',
        'Doctor',
        '$email',
        '$phone_no',
        '$specialty',
        '$bio',
        '$department_id'
    )

    ";

    if(mysqli_query($conn,$sql))
    {
        echo "
        <script>
            alert('Doctor added successfully');
            window.location='doctor.php';
        </script>
        ";
    }
}





$department = mysqli_query(
    $conn,
    "SELECT *
     FROM department
     ORDER BY department_name"
);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Add Doctor
    </title>

    <link rel="stylesheet" href="../../styles/styles.css" />
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
                <h1>
                    Add Doctor
                </h1>
                <p id="role-view">
                    <?php echo $role; ?>'s View
                </p>
            </div>
        </header>

        <section id="content">
            <div class="card" style="max-width:900px;margin:auto;">
                <form method="POST">
                    <div class="row">
                        <div style="flex:1;">
                            <label>
                                Doctor ID
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                value="Auto Generate"
                                readonly
                            >

                        </div>

                        <div style="flex:1;">
                            <label>
                                Doctor Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>

                    <br>

                    <div class="row">
                        <div style="flex:1;">
                            <label>
                                Department
                            </label>

                            <select
                                name="department_id"
                                class="form-control"
                                required>
                                <option>
                                    Select Department
                                </option>

                                <?php
                                while($row = mysqli_fetch_assoc($department))
                                {
                                ?>

                                <option value="<?php echo $row['department_id']; ?>">
                                    <?php echo $row['department_name']; ?>
                                </option>

                                <?php
                                }
                                ?>

                            </select>

                        </div>

                        <div style="flex:1;">
                            <label>
                                Speciality
                            </label>

                            <input
                                type="text"
                                name="specialty"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>

                    <br>

                    <div class="row">
                        <div style="flex:1;">
                            <label>
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required
                            >

                        </div>
                        <div style="flex:1;">
                            <label>
                                Phone Number
                            </label>

                            <input
                                type="text"
                                name="phone_no"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>

                    <br>

                    <div>

                        <label>
                            Description
                        </label>

                        <textarea
                            name="bio"
                            rows="5"
                            class="form-control">
                        </textarea>

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
                            name="save"
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

<?php
$conn->close();
?>