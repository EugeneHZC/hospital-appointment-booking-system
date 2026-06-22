<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<meta http-equiv='refresh' content='3;URL=appointments.php' />";
    die("Invalid request method.");
}

if ($_SESSION["role"] == "Patient") {
    echo "<meta http-equiv='refresh' content='3;URL=forum.php' />";
    die("Unauthorized access. Only admins and doctors can access this page. Redirecting to forum page.");
}

if (!isset($_POST["article_title"]) || !isset($_POST["article_content"])) {
    echo "<meta http-equiv='refresh' content='3;URL=post-article.php' />";
    die("Please provide an article title and content. Redirecting to post article page.");
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=post-article.php' />";
    die("Failed to fetch user info. Error: $conn->error. Redirecting to post article page.");
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<meta http-equiv='refresh' content='3;URL=post-article.php' />";
    die("User not found. Redirecting to post article page.");
}

$articleId = generateId("article", 1, 8);
$title = $_POST["article_title"];
$content = $_POST["article_content"];
$staffId = $user["staff_id"];
$currentDateTime = Date('Y-m-d H:m:s');

$stmt = $conn->prepare("INSERT INTO article (article_id, title, content, publish_datetime, status, staff_id, admin_staff_id)
VALUES (?, ?, ?, ?, 'Pending', ?, null)");

$stmt->bind_param("sssss", $articleId, $title, $content, $currentDateTime, $staffId);
$result = $stmt->execute();

if (!$result) {
    echo "Failed to post article. Error: $conn->error. Redirecting to post article page.";
    echo "<meta http-equiv='refresh' content='3;URL=post-article.php' />";
} else {
    echo "Article posted and is pending for admin's review. Redirecting to forum page.";
    echo "<meta http-equiv='refresh' content='3;URL=forum.php' />";
}
?>