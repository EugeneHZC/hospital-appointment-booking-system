<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SESSION["role"] == "Patient") {
    echo "<meta http-equiv='refresh' content='3;URL=forum.php' />";
    die("Unauthorized access. Only admins and doctors can access this page.");
}

if (!isset($_POST["article_title"]) || !isset($_POST["article_content"])) {
    echo "<meta http-equiv='refresh' content='3;URL=forum.php' />";
    die("Please provide an article title and content.");
}

$email = $_SESSION["email"];
$sql = "SELECT * FROM staff WHERE email = '$email'";
$result = $conn->query($sql);
if (!$result) {
    echo "<meta http-equiv='refresh' content='3;URL=post-article.php' />";
    die("Failed to fetch user info. Error: $conn->error");
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<meta http-equiv='refresh' content='3;URL=post-article.php' />";
    die("User not found.");
}

$articleId = generateId("article", 1, 3);
$title = $_POST["article_title"];
$content = $_POST["article_content"];

$staffId = $user["staff_id"];
$currentDateTime = Date('Y-m-d H:m:s');
$sql = "INSERT INTO article (article_id, title, content, publish_datetime, status, staff_id, admin_staff_id)
VALUES ('$articleId', '$title', '$content', '$currentDateTime', 'Pending', '$staffId', null)";
$result = $conn->query($sql);
if (!$result) {
    echo "Failed to post article. Error: $conn->error";
} else {
    echo "Article posted and is pending for admin's review.";
}

echo "<meta http-equiv='refresh' content='3;URL=forum.php' />";
?>