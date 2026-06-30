<?php
include('../../helper/verify_auth.php');
include('../../helper/connect.php');

$role = $_SESSION["role"];

if ($role === "Patient") {
  echo "
      <script>
          alert('Only admins and doctors can view this page.');
          window.location='forum.php';
      </script>
      ";
  exit();
}

if (!isset($_GET["article_id"])) {
  echo "
        <script>
            alert('Article ID required.');
            window.location='forum.php';
        </script>
        ";
  exit();
}

// get the article by article ID provided
$articleId = $_GET["article_id"];
$stmt = $conn->prepare("SELECT * FROM article WHERE article_id = ?");
$stmt->bind_param("s", $articleId);
$stmt->execute();
$result = $stmt->get_result();
if (!$result || $result->num_rows == 0) {
  echo "
        <script>
            alert('Failed to fetch article. Error: $conn->error');
            window.location='forum.php';
        </script>
        ";
  exit();
}

$article = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../styles/styles.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
  <script src="../../scripts/load-page.js"></script>
  <script src="../../scripts/forum.js"></script>
  <title>Hospital Islam Azzahrah Appointment Booking System - Edit Article</title>
</head>

<body>
  <div id="container">
    <?php include("../../components/side-nav.php") ?>
    <main>
      <header>
        <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
        <div>
          <h1>Edit Article</h1>
          <p id="role-view">
            <?php echo $role; ?>'s View
          </p>
        </div>
      </header>

      <div id="content">
        <form action="update_article.php" method="post">
          <input type="hidden" name="article_id" value="<?php echo $article["article_id"]; ?>">
          <div class="display-cards">
            <div class="card">
              <div class="form-group">
                <label for="article-title">Title</label>
                <input type="text" name="article_title" id="article-title" class="form-control" required value="<?php echo $article["title"]; ?>" />
              </div>
              <div class="form-group">
                <label for="article-content">Content</label>
                <textarea name="article_content" id="article-content" class="form-control" rows="5" required><?php echo $article["content"]; ?></textarea>
              </div>

              <small class="text-gray">Article posted will be on the pending list for admin's approval.</small>

              <div class="text-center">
                <button class="btn btn-secondary" id="cancel-btn" type="button">
                  Cancel
                </button>
                <button class="btn btn-info" type="submit" id="save-btn"><i class="fa-solid fa-floppy-disk"></i>
                  Save
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>

<?php
$conn->close();
?>