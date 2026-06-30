<?php
session_start();
require_once __DIR__ . '/../../helper/connect.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Login.php");
    exit();
}

$email = trim(htmlspecialchars($_POST["email"]) ?? "");
$password = htmlspecialchars($_POST["password"]) ?? "";

if ($email === "" || $password === "") {
    header("Location: Login.php?error=" . urlencode("Please enter your email and password."));
    exit();
}

function password_matches($submittedPassword, $storedPassword)
{
    return password_verify($submittedPassword, $storedPassword);
}

$patientStmt = $conn->prepare("SELECT email, password FROM patient WHERE email = ? LIMIT 1");
$patientStmt->bind_param("s", $email);
$patientStmt->execute();
$patientResult = $patientStmt->get_result();

if ($patientResult && $patientResult->num_rows === 1) {
    $patient = $patientResult->fetch_assoc();

    if (password_matches($password, $patient["password"])) {
        $_SESSION["email"] = $patient["email"];
        $_SESSION["role"] = "Patient";

        header("Location: ../appointments/appointments.php");
        exit();
    }
}

$patientStmt->close();

$staffStmt = $conn->prepare("SELECT email, password, role FROM staff WHERE email = ? LIMIT 1");
$staffStmt->bind_param("s", $email);
$staffStmt->execute();
$staffResult = $staffStmt->get_result();

if ($staffResult && $staffResult->num_rows === 1) {
    $staff = $staffResult->fetch_assoc();
    $role = ucfirst(strtolower(trim($staff["role"])));

    if (password_matches($password, $staff["password"]) && in_array($role, ["Doctor", "Admin"], true)) {
        $_SESSION["email"] = $staff["email"];
        $_SESSION["role"] = $role;

        header("Location: ../dashboard/dashboard.php");
        exit();
    }
}

$staffStmt->close();

header("Location: Login.php?error=" . urlencode("Invalid email or password."));
exit();
?>