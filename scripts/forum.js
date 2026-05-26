$(document).ready(function () {
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
    location.href = "appointment-details.html";
  });

  $("#post-article-btn").click(function () {
    location.href = "add-forum.html";
  });
});
