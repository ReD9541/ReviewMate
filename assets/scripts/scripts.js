$(document).ready(function () {
    const page = $("main").data("page");

    if (page === "profile") {
        loadUserProfile();
    }
    else if (page === "latest-movies") {
        loadLatestMovies();
    }
    else if (page === "top-rated-movies") {
        loadTopRatedMovies();
    }
    else if (page === "movie-search") {
        loadMovieSearch();
    }
    else if (page === "register") {
        loadRegisterPage();
    }
    else if (page === "login") {
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
                    <img src="${user.pfp_url ? '/' + user.pfp_url : '/assets/images/profile_picture/default.png'}" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 120px; height: 120px;">
                </div>
                <div class="profile-details">
                    <h2>${user.username}</h2>
                    <p><strong>Country:</strong> ${user.country || 'Not available'}</p>
                    <p><strong>Address:</strong> ${user.address || 'Not available'}</p>
                    <p><strong>Bio:</strong> ${user.bio || 'Not available'}</p>
                    <p><strong>Joined on:</strong> ${user.joined_on || 'Not available'}</p>
                </div>`;
            $("#profile-section").html(profileHtml);
            populateMovies(data.watched_movies, "#watched-movies", "watched");
            populateMovies(data.reviewed_movies, "#reviewed-movies", "reviewed");
            populateMovies(data.watchlist_movies, "#watchlist-movies", "watchlist");
        },
        error: function () {
            alert("An error occurred while fetching user data. Please try again.");
        }
    });
}

function populateMovies(movies, container, type) {
    if (!movies || movies.length === 0) {
        $(container).html("<p class='text-center'>No movies found.</p>");
        return;
    }
    let html = "";
    movies.forEach(movie => {
        html += `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                <a href="/movie/movie_details.php?movie_id=${movie.movie_id}">
                    <div class="poster-wrapper">
                        <img src="/${movie.poster_url}" alt="${movie.title}" class="img-fluid">
                    </div>
                </a>
                <h4 class="mt-2 text-center">${movie.title}</h4>
                <p class="text-center">Release Date: ${movie.release_date}</p>
                <p class="text-center">IMDb Rating: ${movie.imdb_rating}</p>
                ${type === "reviewed" ? `<p class="text-center">"${movie.review_text}"</p>` : ""}
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
            movies.forEach(movie => {
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
            alert("An error occurred while fetching the latest movies. Please try again.");
        }
    });
}

function loadTopRatedMovies() {
    $.ajax({
        url: "/movie/fetch_top_rated_movies.php",
        method: "GET",
        dataType: "json",
        success: function (movies) {
            let html = "";
            movies.forEach(movie => {
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
            alert("An error occurred while fetching the top-rated movies. Please try again.");
        }
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
