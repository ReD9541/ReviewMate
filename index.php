<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "includes/db_connect.php";
include "includes/header.php";

$topRatedQuery = "SELECT movie_id, title, imdb_rating, poster_url FROM movie ORDER BY imdb_rating DESC LIMIT 4";
$topRatedResult = $conn->query($topRatedQuery);

$latestMoviesQuery = "SELECT movie_id, title, release_date, poster_url FROM movie ORDER BY release_date DESC LIMIT 4";
$latestMoviesResult = $conn->query($latestMoviesQuery);
?>

<main class="main-content">
    <div class="container-fluid">
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['username'])): ?>
        <h2 class="text-center my-4">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! Welcome to ReviewMate</h2>
        <?php else: ?>
            <h2 class="text-center my-4">Welcome to ReviewMate</h2>
        <?php endif; ?>
        <div class="movie-section my-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Top Rated Movies</h3>
                <a href="/movie/top_rated_movies.php" class="btn btn-primary ml-3 my-2" style="padding: 10px 20px; margin: 10px;">Show More</a>
            </div>
            <div class="row">
                <?php while ($movie = $topRatedResult->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                        <a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                            <div class="poster-wrapper">
                                <img src="/<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-fluid">
                            </div>
                        </a>
                        <h4 class="mt-2 text-center"><?= htmlspecialchars($movie['title']) ?></h4>
                        <p class="text-center">IMDb Rating: <?= htmlspecialchars($movie['imdb_rating']) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="movie-section my-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Latest Movies</h3>
                <a href="/movie/latest_movies.php" class="btn btn-primary ml-3 my-2" style="padding: 10px 20px; margin: 10px;">Show More</a>
            </div>
            <div class="row">
                <?php while ($movie = $latestMoviesResult->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                        <a href="/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                            <div class="poster-wrapper">
                                <img src="/<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-fluid">
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
