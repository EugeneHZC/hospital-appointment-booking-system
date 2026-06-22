<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='edit-article.php';
        </script>
        ";
    exit();
}

if (!isset($_POST["status"]) || !isset($_POST["article_id"])) {
    echo json_encode("Please provide a status, article ID and admin staff ID.");
    exit();
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    echo json_encode("Failed to fetch user. Error: $conn->error");
    exit();
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo json_encode("User not found.");
    exit();
}

$articleId = $_POST["article_id"];
$status = $_POST["status"];
$adminId = $user["staff_id"];

$stmt = $conn->prepare("UPDATE article SET status = ?, admin_staff_id = ? WHERE article_id = ?");
$stmt->bind_param("sss", $status, $adminId, $articleId);
if ($status == "Rejected") {
    $stmt = $conn->prepare("UPDATE article SET status = ? WHERE article_id = ?");
    $stmt->bind_param("ss", $status, $articleId);
}

$result = $stmt->execute();

if (!$result) {
    echo json_encode("Failed to update article's status. Error: $conn->error");
} else {
    echo json_encode("Article's status updated successfully.");
}
?>