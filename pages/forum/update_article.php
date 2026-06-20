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

$articleId = $_POST["article_id"];
$title = $_POST["article_title"];
$content = $_POST["article_content"];

$currentDateTime = Date('Y-m-d H:m:s');

$sql = "UPDATE article 
SET title = '$title', content = '$content', status = 'Pending', publish_datetime = '$currentDateTime', admin_staff_id = NULL 
WHERE article_id = '$articleId'";

$result = $conn->query($sql);
if (!$result) {
    echo "Failed to update article. Error: $conn->error";
} else {
    echo "Article updated and is pending for admin's review.";
}

echo "<meta http-equiv='refresh' content='3;URL=forum.php' />";
?>