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

  let horizontalLinkClicked = "Approved";

  function filterArticles(statusSelected, searchQuery) {
    // loop through each display card
    $(".display-card-top-bottom").each(function () {
      // if the status of that display card (value is the status of the article) is same with the currently selected filter link
      // or if the search keyword exists in the title or content of the article
      if (
        $(this).data("status") === statusSelected &&
        ($(this).data("title").toLowerCase().includes(searchQuery) ||
          $(this).data("content").toLowerCase().includes(searchQuery))
      ) {
        // show this display card (means the current display card is the one the user wants)
        $(this).show();
      } else {
        // hide this display card (means the current display card is not the one the user wants)
        $(this).hide();
      }
    });
  }

  // initial filter (only show approved articles since the approved link will be selected when the page loads)
  filterArticles("Approved", "");

  // filter article status through horizontal nav
  $("#articles-horizontal-nav .nav-link").click(function () {
    horizontalLinkClicked = $(this).data("status");
    // get the horizontal nav link (artcle status filter) that has been clicked (selected by user)
    filterArticles(
      $(this).data("status"),
      $("#search-bar").val().toLowerCase(),
    );
  });

  $("#search-bar").change(function () {
    let searchQuery = $(this).val().toLowerCase();
    filterArticles(horizontalLinkClicked, searchQuery);
  });

  $(".delete-btn").click(function () {
    // provide a confirmation modal to confirm whether the user has
    if (confirm("Are you sure you want to delete this article?")) {
      $.ajax({
        type: "POST",
        url: "delete_article.php",
        data: {
          article_id: $(this).data("id"),
        },
        success: function (response) {
          alert(JSON.parse(response));
          window.location.reload();
        },
      });
    }
  });

  $(".approve-article-btn").click(function () {
    if (confirm("Are you sure you want to approve this article?")) {
      $.ajax({
        type: "POST",
        url: "update_article_status.php",
        data: {
          article_id: $(this).data("id"),
          status: "Approved",
        },
        success: function (response) {
          alert(JSON.parse(response));
          window.location.reload();
        },
      });
    }
  });

  $(".reject-article-btn").click(function () {
    if (confirm("Are you sure you want to reject this article?")) {
      $.ajax({
        type: "POST",
        url: "update_article_status.php",
        data: {
          article_id: $(this).data("id"),
          status: "Rejected",
        },
        success: function (response) {
          alert(JSON.parse(response));
          window.location.reload();
        },
      });
    }
  });
});
