<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');
include('../../helper/generate_id.php');

if ($_SESSION["role"] == "Patient") {
    echo "<meta http-equiv='refresh' content='3;URL=forum.php' />";
    die("Unauthorized access. Only admins and doctors can access this page.");
}

$articleId = $_POST["article_id"];

$sql = "DELETE FROM article WHERE article_id = '$articleId'";
$result = $conn->query($sql);
if (!$result) {
    echo json_encode("Failed to delete article. Error: $conn->error");
} else {
    echo json_encode("Article deleted.");
}
?>