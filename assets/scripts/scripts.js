$(document).ready(function () {
  const page = $("main").data("page");

  if (page === "profile") {
    loadUserProfile();
  } else if (page === "latest-movies") {
    loadLatestMovies();
  } else if (page === "top-rated-movies") {
    loadTopRatedMovies();
  } else if (page === "movie-details") {
    const params = new URLSearchParams(window.location.search);
    const movieId = params.get("movie_id");

    if (movieId) {
      loadMovieDetails(movieId);
    } else {
      $("#movie-details").html("<p class='text-center'>Invalid movie ID.</p>");
    }
  } else if (page === "movie-search") {
    $("#search-form").on("submit", function (e) {
      e.preventDefault();

      const searchTerm = $("#search-term").val().trim();
      if (searchTerm) {
        performSearch(searchTerm);
      } else {
        $("#search-results").html(
          "<p>Please enter a movie title to search.</p>"
        );
      }
    });
  } else if (page === "register") {
    loadRegisterPage();
  } else if (page === "login") {
    loadLoginPage();
  }
});

function loadUserProfile() {
  $.ajax({
    url: "/user/fetch_user_data.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      if (data.error) {
        alert(data.error);
        return;
      }
      const user = data.userinfo;
      const profileHtml = `
                <div class="profile-picture mr-4">
                    <img src="${
                      user.pfp_url
                        ? "/" + user.pfp_url
                        : "/assets/images/profile_picture/default.png"
                    }" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 120px; height: 120px;">
                </div>
                <div class="profile-details">
                    <h2>${user.username}</h2>
                    <p><strong>Country:</strong> ${
                      user.country || "Not available"
                    }</p>
                    <p><strong>Address:</strong> ${
                      user.address || "Not available"
                    }</p>
                    <p><strong>Bio:</strong> ${user.bio || "Not available"}</p>
                    <p><strong>Joined on:</strong> ${
                      user.joined_on || "Not available"
                    }</p>
                </div>`;
      $("#profile-section").html(profileHtml);
      populateMovies(data.watched_movies, "#watched-movies", "watched");
      populateMovies(data.reviewed_movies, "#reviewed-movies", "reviewed");
      populateMovies(data.watchlist_movies, "#watchlist-movies", "watchlist");
    },
    error: function () {
      alert("An error occurred while fetching user data. Please try again.");
    },
  });
}

function populateMovies(movies, container, type) {
  if (!movies || movies.length === 0) {
    $(container).html("<p class='text-center'>No movies found.</p>");
    return;
  }
  let html = "";
  movies.forEach((movie) => {
    html += `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                <a href="/movie/movie_details.php?movie_id=${movie.movie_id}">
                    <div class="poster-wrapper">
                        <img src="/${movie.poster_url}" alt="${
      movie.title
    }" class="img-fluid">
                    </div>
                </a>
                <h4 class="mt-2 text-center">${movie.title}</h4>
                <p class="text-center">Release Date: ${movie.release_date}</p>
                <p class="text-center">IMDb Rating: ${movie.imdb_rating}</p>
                ${
                  type === "reviewed"
                    ? `<p class="text-center">"${movie.review_text}"</p>`
                    : ""
                }
            </div>`;
  });
  $(container).html(html);
}

function loadLatestMovies() {
  $.ajax({
    url: "/movie/fetch_latest_movies.php",
    method: "GET",
    dataType: "json",
    success: function (movies) {
      let html = "";
      movies.forEach((movie) => {
        html += `
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 movie-card mb-4">
                        <a href="/movie/movie_details.php?movie_id=${movie.movie_id}">
                            <div class="poster-wrapper">
                                <img src="/${movie.poster_url}" alt="${movie.title}" class="img-fluid">
                            </div>
                        </a>
                        <h4 class="mt-2 text-center">${movie.title}</h4>
                        <p class="text-center">Release Date: ${movie.release_date}</p>
                    </div>`;
      });
      $("#latest-movies-section").html(html);
    },
    error: function () {
      alert(
        "An error occurred while fetching the latest movies. Please try again."
      );
    },
  });
}

function loadTopRatedMovies() {
  $.ajax({
    url: "/movie/fetch_top_rated_movies.php",
    method: "GET",
    dataType: "json",
    success: function (movies) {
      let html = "";
      movies.forEach((movie) => {
        html += `
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 movie-card mb-4">
                        <a href="/movie/movie_details.php?movie_id=${movie.movie_id}">
                            <div class="poster-wrapper">
                                <img src="/${movie.poster_url}" alt="${movie.title}" class="img-fluid">
                            </div>
                        </a>
                        <h4 class="mt-2 text-center">${movie.title}</h4>
                        <p class="text-center">IMDb Rating: ${movie.imdb_rating}</p>
                    </div>`;
      });
      $("#top-rated-movies-section").html(html);
    },
    error: function () {
      alert(
        "An error occurred while fetching the top-rated movies. Please try again."
      );
    },
  });
}

function loadMovieDetails(movieId) {
  $.ajax({
    url: `/movie/fetch_movie_details.php`,
    method: "GET",
    data: { movie_id: movieId },
    dataType: "json",
    success: function (data) {
      const movie = data.movie;
      const reviews = data.reviews;

      // Populate movie details
      const movieHtml = `
                <div class="card mb-5">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <div class="poster-wrapper">
                                <img src="/${movie.poster_url}" alt="${
        movie.title
      }" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h1>${movie.title}</h1>
                                <p><strong>Release Date:</strong> ${
                                  movie.release_date
                                }</p>
                                <p><strong>Genre:</strong> ${movie.genre}</p>
                                <p><strong>Runtime:</strong> ${
                                  movie.runtime
                                } mins</p>
                                <p><strong>IMDb Rating:</strong> ${
                                  movie.imdb_rating
                                }</p>
                                <p><strong>User Rating:</strong> ${
                                  movie.user_rating
                                }</p>
                                <p><strong>Age Rating:</strong> ${
                                  movie.age_rating
                                }</p>
                                <p><strong>Budget:</strong> $${movie.budget.toLocaleString()}</p>
                                <p><strong>Box Office:</strong> $${movie.box_office.toLocaleString()}</p>
                                <p><strong>Description:</strong> ${
                                  movie.description
                                }</p>
                                <p><strong>Director:</strong> ${
                                  movie.director
                                }</p>
                                <p><strong>Cast:</strong> ${movie.cast}</p>
                                <p><strong>Language:</strong> ${
                                  movie.language
                                }</p>
                                <p><strong>Country:</strong> ${
                                  movie.country
                                }</p>
                            </div>
                        </div>
                    </div> 
                    ${
                      movie.trailer_url
                        ? `  <div class="mt-4 trailer-section"> <div class = "video-wrapper"> <iframe src="${movie.trailer_url}" allowfullscreen frameborder="0"></iframe> </div></div>`
                        : "<p class='mt-4'>No trailer available.</p>"
                    }
                </div>`;
      $("#movie-details").html(movieHtml);

      // Populate reviews
      if (reviews.length > 0) {
        let reviewsHtml =
          "<h2 class='text-center mb-4'>User Reviews</h2><div class='row'>";
        reviews.forEach((review) => {
          reviewsHtml += `
                        <div class="col-12 mb-3">
                            <div class="card h-100 shadow-sm p-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">${review.username}</h5>
                                    <p><strong>Rating:</strong> ${review.rating}/10</p>
                                    <p><strong>Review:</strong> ${review.review_text}</p>
                                </div>
                            </div>
                        </div>`;
        });
        reviewsHtml += "</div>";
        $("#reviews-section").html(reviewsHtml);
      } else {
        $("#reviews-section").html(
          "<p class='text-center'>No reviews yet. Be the first to review this movie!</p>"
        );
      }
    },
    error: function () {
      $("#movie-details").html(
        "<p class='text-center'>Failed to load movie details. Please try again later.</p>"
      );
    },
  });
}
function loadMovieSearch() {
  console.log("Movie Search Page Placeholder");
}

function loadRegisterPage() {
  console.log("Register Page Placeholder");
}

function loadLoginPage() {
  console.log("Login Page Placeholder");
}

$(document).on("click", "#add-to-watchlist", function () {
  const movieId = $(this).data("movie-id");

  $.ajax({
    url: "/auth/process/on_watchlist.php",
    method: "POST",
    data: { movie_id: movieId },
    success: function (response) {
      alert(response.success);
    },
    error: function (xhr) {
      alert(xhr.responseJSON?.error || "An error occurred.");
    },
  });
});

$(document).on("submit", "#submit-review", function (e) {
  e.preventDefault();

  const formData = $(this).serialize();

  $.ajax({
    url: "/auth/process/on_review.php",
    method: "POST",
    data: formData,
    success: function (response) {
      alert(response.success);
    },
    error: function (xhr) {
      alert(xhr.responseJSON?.error || "An error occurred.");
    },
  });
});

$(document).on("click", "#mark-watched", function () {
  const movieId = $(this).data("movie-id");

  $.ajax({
    url: "/auth/process/on_mark_watched.php",
    method: "POST",
    data: { movie_id: movieId },
    success: function (response) {
      alert(response.success);
    },
    error: function (xhr) {
      alert(xhr.responseJSON?.error || "An error occurred.");
    },
  });
});
