<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "includes/db_connect.php";
include "includes/header.php";

$topRatedQuery = "SELECT movie_id, title, imdb_rating, poster_url FROM movie ORDER BY imdb_rating DESC LIMIT 6";
$topRatedResult = $conn->query($topRatedQuery);

$latestMoviesQuery = "SELECT movie_id, title, release_date, poster_url FROM movie ORDER BY release_date DESC LIMIT 6";
$latestMoviesResult = $conn->query($latestMoviesQuery);
?>

<main class="main-content">
    <div class="container-fluid">
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['username'])): ?>
            <div class="my-5 py-4 text-center bg-light">
                <h2 class="text-center fw-bold">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! Welcome to <strong>ReviewMate</strong></h2>
            </div>
        <?php else: ?>
            <div class="my-5 py-4 text-center bg-light">
                <h2 class="fw-bold">Welcome to <strong>ReviewMate</strong></h2>
            </div>
        <?php endif; ?>

        <div class="movie-section my-5">
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="overwritting_div">
                        <div class="mr-auto p-2">
                            <h1 class="fw-bold mb-0">Top Rated Movies</h1>
                        </div>
                        <div class="p-2"> <a href="/movie/top_rated_movies.php" class="btn btn-primary px-4 py-2">Show More</a> </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 d-flex flex-nowrap">
                <?php while ($movie = $topRatedResult->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 ">
                        <div class="movie-grid">
                            <div class="movie-image">
                                <a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>" class="image">
                                    <img src="/<?= htmlspecialchars($movie['poster_url']) ?>" class="img-fluid" alt="<?= htmlspecialchars($movie['title']) ?>">
                                </a>
                                <span class="movie-rating-label">IMDb: <?= htmlspecialchars($movie['imdb_rating']) ?></span>
                                <a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>" class="movie-details-btn">View Details</a>
                            </div>
                            <div class="movie-content text-center">
                                <h3 class="movie-title"><a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>"><?= htmlspecialchars($movie['title']) ?></a></h3>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="movie-section my-5">
            <div class="container-fluid">
                <div class="overwritting_div">
                    <div class="mr-auto p-2">
                        <h1 class="fw-bold mb-0">Latest Movies</h1>
                    </div>
                    <div class="p-2"> <a href="/movie/latest_movies.php" class="btn btn-primary px-4 py-2">Show More</a> </div>
                </div>
            </div>

            <div class="row g-4">
                <?php while ($movie = $latestMoviesResult->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 ">
                        <div class="movie-grid">
                            <div class="movie-image">
                                <a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>" class="image">
                                    <img src="/<?= htmlspecialchars($movie['poster_url']) ?>" class="img-fluid" alt="<?= htmlspecialchars($movie['title']) ?>">
                                </a>
                                <span class="movie-rating-label">Release Date: <?= htmlspecialchars($movie['release_date']) ?></span>
                                <a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>" class="movie-details-btn">View Details</a>
                            </div>
                            <div class="movie-content text-center">
                                <h3 class="movie-title"><a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>"><?= htmlspecialchars($movie['title']) ?></a></h3>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
</main>



<?php include "includes/footer.php"; ?>

<?php
$conn->close();
?>