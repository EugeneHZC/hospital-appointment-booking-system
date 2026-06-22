<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');
include('../../helper/generate_id.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "
        <script>
            alert('Invalid request method.');
            window.location='../appointments/appointments.php';
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

if (!isset($_POST["article_title"]) || !isset($_POST["article_content"])) {
    echo "
      <script>
          alert('Please provide an article title and content.');
          window.location='post-article.php';
      </script>
      ";
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if (!$result || $result->num_rows == 0) {
    echo "
        <script>
            alert('Failed to fetch user. Error: $conn->error');
            window.location='post-article.php';
        </script>
        ";
}

$user = $result->fetch_assoc();

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
    echo "
        <script>
            alert('Failed to post article. Error: $conn->error. ');
            window.location='post-article.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Article posted and is pending for admin's review.');
            window.location='forum.php';
        </script>
        ";
}
?>