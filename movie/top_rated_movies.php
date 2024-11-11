<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db_connect.php";
include "../includes/header.php";

$topRatedQuery = "SELECT movie_id, title, imdb_rating, poster_url FROM movie ORDER BY imdb_rating DESC";
$topRatedResult = $conn->query($topRatedQuery);
?>

<main class="main-content">
    <div class="container my-5">
        <h2 class="text-center mb-4">Top Rated Movies</h2>
        <div class="row">
            <?php while ($movie = $topRatedResult->fetch_assoc()): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 movie-card mb-4">
                    <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                        <div class="poster-wrapper">
                            <img src="/ReviewMate/<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-fluid">
                        </div>
                    </a>
                    <h4 class="mt-2 text-center"><?= htmlspecialchars($movie['title']) ?></h4>
                    <p class="text-center">IMDb Rating: <?= htmlspecialchars($movie['imdb_rating']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<?php
$conn->close();
?>