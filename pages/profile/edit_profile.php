<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$email = $_SESSION["email"];
$role = $_SESSION["role"];

// Fetch user data based on role
if ($role === 'Patient') {
    // $query = "SELECT patient_id as id, name, email, phone_no as phone, date_of_birth, profile_picture, 'Patient' as role, NULL as specialty, NULL as bio, NULL as department FROM patient WHERE email = ?";
    $query = "SELECT * FROM patient WHERE email = ?";
} else if ($role === 'Doctor' || $role === 'Admin') {
    // $query = "SELECT staff_id as id, name, email, phone_no as phone, role, specialty, bio, profile_picture, d.department_name as department FROM staff s LEFT JOIN department d ON s.department_id = d.department_id WHERE s.email = ?";
    $query = "SELECT * FROM staff s JOIN department d ON s.department_id = d.department_id WHERE s.email = ?";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch profile info. Error: $conn->error');
            window.location='../appointments/appointments.php';
        </script>
        ";
}

$profileData = $result->fetch_assoc();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hospital Islam Azzahrah Appointment Booking System - Edit Profile</title>
    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <script src="../../scripts/logout.js"></script>
</head>

<body>
    <div id="container">
        <?php include("../../components/side-nav.php") ?>
        <main>
            <header>
                <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
                <div>
                    <h1>Profile</h1>
                    <p id="role-view">
                        <?php echo $role; ?>'s View
                    </p>
                </div>
            </header>
            <div id="content">
                <form action="update_profile.php" method="post" enctype="multipart/form-data">
                    <div class="edit-section card">
                        <h3><i class="fa-regular fa-pen-to-square"></i> Edit Profile</h3>
                        <div class="form-row">
                            <div class="profile-upload-container">
                                <div class="profile-avatar" id="profile-avatar-preview">
                                    <img src="<?php echo $profileData["profile_picture"]; ?>" alt="Profile Picture">
                                </div>
                                <input type="file" id="profile-picture-input" name="profile_picture" class="form-control" required accept="image/jpeg,image/png,image/gif,image/webp" />
                                <small class="form-text text-muted">JPG, PNG, GIF, or WebP</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="edit-fullname" name="name" class="form-control" value="<?php echo $profileData["name"]; ?>" required />
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" id="edit-email" name="email" class="form-control" value="<?php echo $profileData["email"]; ?>" required />
                        </div>
                        <?php if ($role === "Patient") { ?>
                            <div class="form-group">
                                <label>IC Number</label>
                                <input type="text" name="ic_number" class="form-control" value="<?php echo $profileData["ic_number"]; ?>" required />
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone_no" class="form-control" value="<?php echo $profileData["phone_no"]; ?>" required />
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <div class="row">
                                <input type="radio" name="gender" value="M" <?php echo $profileData["gender"] == "M" ? "checked" : "" ?>>
                                <label for="M">Male</label>
                            </div>
                            <div class="row">
                                <input type="radio" name="gender" value="F" <?php echo $profileData["gender"] == "F" ? "checked" : "" ?>>
                                <label for="F">Female</label>
                            </div>
                        </div>
                        <?php if ($role === 'Patient') { ?>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" id="edit-dob" name="date_of_birth" class="form-control" value="<?php echo $profileData["date_of_birth"]; ?>" required />
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" rows="5" id="address" class="form-control" required><?php echo $profileData["address"]; ?></textarea>
                            </div>
                        <?php } ?>
                        <?php if ($role === 'Doctor' || $role === 'Admin') { ?>
                            <div class="form-group">
                                <label>Specialty</label>
                                <input type="text" id="edit-specialty" name="specialty" class="form-control" value="<?php echo $profileData["specialty"]; ?>" required />
                            </div>
                            <div class="form-group">
                                <label>Bio</label>
                                <textarea required id="edit-bio" rows="5" name="bio" class="form-control"><?php echo $profileData["bio"]; ?></textarea>
                            </div>
                        <?php } ?>
                        <div class="btns">
                            <button class="btn btn-secondary" id="cancel-btn">Cancel</button>
                            <button class="btn btn-info" id="save-btn">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>

<?php
$conn->close();
?>