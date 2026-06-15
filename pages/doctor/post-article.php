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
  <title>Hospital Islam Azzahrah Appointment Booking System - Post Article</title>

  <!-- for testing purposes only -->
  <input type="hidden" value="doctor" name="role" id="role" />
</head>

<body>
  <div id="container">
    <?php include("../../components/doctor/side-nav.html") ?>
    <main>
      <header>
        <button id="nav-toggle" class="btn btn-info"><i class="fa-solid fa-bars"></i></button>
        <div>
          <h1>Post Article</h1>
          <p id="role-view"></p>
        </div>
      </header>

      <div id="content">
        <form>
          <div class="display-cards">
            <div class="display-card-top-bottom card">
              <div class="display-card-bottom">
                <div class="form-group">
                  <label for="article-title">Title</label>
                  <input type="text" name="article-title" id="article-title" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="article-content">Content</label>
                  <textarea name="article-content" id="article-content" class="form-control" rows="5"></textarea>
                </div>

                <div class="btns">
                  <button class="btn btn-info" type="submit" id="post-btn">
                    Post
                  </button>
                  <button class="btn btn-secondary" id="cancel-btn" type="button">
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>