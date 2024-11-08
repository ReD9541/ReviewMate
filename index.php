<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "includes/db_connect.php";
include "includes/header.php";

// Fetch Top Rated Movies
$topRatedQuery = "SELECT movie_id, title, imdb_rating, poster_url FROM movie ORDER BY imdb_rating DESC LIMIT 4";
$topRatedResult = $conn->query($topRatedQuery);

// Fetch Latest Movies
$latestMoviesQuery = "SELECT movie_id, title, release_date, poster_url FROM movie ORDER BY release_date DESC LIMIT 4";
$latestMoviesResult = $conn->query($latestMoviesQuery);
?>

<main class="main-content">
    <div class="container-fluid">
        <h2 class="text-center my-4">Welcome to ReviewMate</h2>

        <!-- Top Rated Movies Section -->
        <div class="movie-section my-5">
            <h3 class="mb-4">Top Rated Movies</h3>
            <div class="row">
                <?php while ($movie = $topRatedResult->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                        <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                        <div class="poster-wrapper">
                            <img src="<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-fluid">
                        </div>
                        </a>
                        <h4 class="mt-2 text-center"><?= htmlspecialchars($movie['title']) ?></h4>
                        <p class="text-center">IMDb Rating: <?= htmlspecialchars($movie['imdb_rating']) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Latest Movies Section -->
        <div class="movie-section my-5">
            <h3 class="mb-4">Latest Movies</h3>
            <div class="row">
                <?php while ($movie = $latestMoviesResult->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                        <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                        <div class="poster-wrapper">
                            <img src="<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-fluid">
                        </div>
                        </a>
                        <h4 class="mt-2 text-center"><?= htmlspecialchars($movie['title']) ?></h4>
                        <p class="text-center">Release Date: <?= htmlspecialchars($movie['release_date']) ?></p>
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
