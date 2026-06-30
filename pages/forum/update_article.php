<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='edit-article.php';
        </script>
        ";
    exit();
}

if ($_SESSION["role"] == "Patient") {
    echo "
      <script>
          alert('Only admins and doctors can view this page.');
          window.location='forum.php';
      </script>
      ";
    exit();
}

if (!isset($_POST["article_title"]) || !isset($_POST["article_content"])) {
    echo "
      <script>
          alert('Please provide an article title and content.');
          window.location='edit-article.php';
      </script>
      ";
    exit();
}

$articleId = htmlspecialchars($_POST["article_id"]);
$title = $_POST["article_title"];
$content = $_POST["article_content"];
$currentDateTime = Date('Y-m-d H:m:s');

$stmt = $conn->prepare("UPDATE article 
SET title = ?, content = ?, status = 'Pending', publish_datetime = ?, admin_staff_id = NULL 
WHERE article_id = ?");

$stmt->bind_param("ssss", $title, $content, $currentDateTime, $articleId);

$result = $stmt->execute();

if (!$result) {
    echo "
      <script>
          alert('Failed to update article. Error: $conn->error');
          window.location='edit-article.php';
      </script>
      ";
} else {
    echo "
      <script>
          alert('Article updated and is pending for admin\'s review.');
          window.location='forum.php';
      </script>
      ";
}
?>