<?php
include('../../helper/connect.php');
include('../../helper/verify_auth.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='forum.php';
        </script>
        ";
}

if ($_SESSION["role"] == "Patient") {
    echo "
        <script>
            alert('Only admins and doctors can view this page.');
            window.location='forum.php';
        </script>
        ";
}

$articleId = $_POST["article_id"];

$stmt = $conn->prepare("DELETE FROM article WHERE article_id = ?");
$stmt->bind_param("s", $articleId);

$result = $stmt->execute();
if (!$result) {
    echo json_encode("Failed to delete article. Error: $conn->error");
} else {
    echo json_encode("Article deleted.");
}
?>