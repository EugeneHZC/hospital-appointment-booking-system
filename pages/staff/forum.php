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
  <title>Hospital Islam Azzahrah Appointment Booking System</title>

  <!-- For testing purposes -->
  <input type="hidden" value="admin" id="role" name="role" />
</head>

<body>
  <div id="container">
    <?php include("../../components/side-nav.html") ?>
    <main>
      <header>
        <h1>Forum</h1>
        <p id="role-view"></p>
      </header>

      <div id="content">
        <div id="article-search" class="row">
          <label for="search-bar">Search</label>
          <input type="search" name="search-bar" id="search-bar" class="form-control" placeholder="Search for article names or content" />
          <button class="btn btn-info" id="post-article-btn">
            Post Article
          </button>
        </div>

        <nav class="horizontal-nav" id="articles-horizontal-nav">
          <ul class="nav-links">
            <li class="nav-link active-link">
              <a>Approved</a>
            </li>
            <li class="nav-link">
              <a>Pending</a>
            </li>
            <li class="nav-link"><a>Rejected</a></li>
          </ul>
        </nav>

        <div class="display-cards">
          <div class="display-card-top-bottom card">
            <div class="display-card-top">
              <div>
                <h3>Article Title</h3>
                <p class="text-sm text-gray my-half">
                  <i class="fa-solid fa-circle-user"></i>Written by Doctor A
                </p>
              </div>
            </div>

            <br />

            <div class="display-card-bottom">
              <p class="line-height-3">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Cumque nulla ratione vitae veniam tenetur porro labore, ad
                magni atque assumenda nihil. Necessitatibus, quis! Fuga
                voluptatibus officia laboriosam voluptas corporis voluptatum
                accusantium. Alias, obcaecati facilis assumenda, ab quia
                mollitia molestias quis enim quos fugit voluptatibus rem.
                Porro tempora incidunt expedita dicta neque illum eveniet quia
                autem itaque a! Quia officiis possimus rem unde alias saepe
                soluta mollitia fugit sed eveniet amet maiores obcaecati quae
                nesciunt est pariatur animi eum, totam perferendis
                perspiciatis quisquam quidem! Ipsum illum quia, repellendus
                ducimus maiores modi recusandae deserunt veniam sequi impedit.
                Quibusdam qui mollitia commodi neque?
              </p>

              <br />

              <div class="float-right">
                <button class="btn btn-success approve-article-btn">
                  Approve
                </button>

                <button class="btn btn-danger reject-article-btn">
                  Reject
                </button>
              </div>
            </div>
          </div>

          <div class="display-card-top-bottom card">
            <div class="display-card-top">
              <div>
                <h3>Article Title</h3>
                <p class="text-sm text-gray my-half">
                  <i class="fa-solid fa-circle-user"></i>Written by Doctor B
                </p>
                <p class="text-sm text-gray my-half">
                  <i class="fa-solid fa-check"></i>Approved by Admin B
                </p>
              </div>

              <div>
                <button class="btn btn-info">Edit</button>
                <button class="btn btn-danger">Delete</button>
              </div>
            </div>

            <br />

            <div class="display-card-bottom">
              <p class="line-height-3">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Cumque nulla ratione vitae veniam tenetur porro labore, ad
                magni atque assumenda nihil. Necessitatibus, quis! Fuga
                voluptatibus officia laboriosam voluptas corporis voluptatum
                accusantium. Alias, obcaecati facilis assumenda, ab quia
                mollitia molestias quis enim quos fugit voluptatibus rem.
                Porro tempora incidunt expedita dicta neque illum eveniet quia
                autem itaque a! Quia officiis possimus rem unde alias saepe
                soluta mollitia fugit sed eveniet amet maiores obcaecati quae
                nesciunt est pariatur animi eum, totam perferendis
                perspiciatis quisquam quidem! Ipsum illum quia, repellendus
                ducimus maiores modi recusandae deserunt veniam sequi impedit.
                Quibusdam qui mollitia commodi neque?
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>