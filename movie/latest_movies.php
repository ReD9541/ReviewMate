<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db_connect.php";
include "../includes/header.php";

$latestMoviesQuery = "SELECT movie_id, title, release_date, poster_url FROM movie ORDER BY release_date DESC";
$latestMoviesResult = $conn->query($latestMoviesQuery);
?>

<main class="main-content">
    <div class="container my-5">
        <h2 class="text-center mb-4">Latest Movies</h2>
        <div class="row">
            <?php while ($movie = $latestMoviesResult->fetch_assoc()): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 movie-card mb-4">
                    <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                        <div class="poster-wrapper">
                            <img src="/ReviewMate/<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-fluid">
                        </div>
                    </a>
                    <h4 class="mt-2 text-center"><?= htmlspecialchars($movie['title']) ?></h4>
                    <p class="text-center">Release Date: <?= htmlspecialchars($movie['release_date']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<?php
$conn->close();
?>