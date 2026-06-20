<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');

if (!isset($_POST["status"]) || !isset($_POST["article_id"])) {
    echo json_encode("Please provide a status, article ID and admin staff ID.");
    exit;
}

$email = $_SESSION["email"];
$sql = "SELECT * FROM staff WHERE email = '$email'";
$result = $conn->query($sql);
if (!$result) {
    echo json_encode("Failed to fetch user. Error: $conn->error");
    exit;
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo json_encode("User not found.");
    exit;
}

$articleId = $_POST["article_id"];
$status = $_POST["status"];
$adminId = $user["staff_id"];

$sql = "UPDATE article SET status = '$status', admin_staff_id = '$adminId' WHERE article_id = '$articleId'";
if ($status == "Rejected") {
    $sql = "UPDATE article SET status = '$status' WHERE article_id = '$articleId'";
}

$result = $conn->query($sql);

if (!$result) {
    echo json_encode("Failed to update article's status. Error: $conn->error");
} else {
    echo json_encode("Article's status updated successfully.");
}
?>