$(document).ready(function () {
  // used for the horizontal nav for different article status
  $("#articles-horizontal-nav ul li").click(function (e) {
    e.preventDefault();

    $(this)
      .siblings()
      .each(function (index, element) {
        element.classList.remove("active-link");
      });
    $(this).addClass("active-link");
  });

  $(".view-details-btn").click(function () {
    location.href = "appointment-details.php";
  });

  $("#post-article-btn").click(function () {
    location.href = "post-article.php";
  });

  $("#cancel-btn").click(function () {
    window.location.href = "forum.php";
  });
});
