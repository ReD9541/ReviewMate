<?php
session_start();
include "includes/db_connect.php";
include "includes/header.php";

// Fetch Top Rated Movies
$topRatedQuery = "SELECT movie_id, title, imdb_rating, poster_url FROM movies ORDER BY imdb_rating DESC LIMIT 5";
$topRatedResult = $conn->query($topRatedQuery);

// Fetch Latest Movies
$latestMoviesQuery = "SELECT movie_id, title, release_date, poster_url FROM movies ORDER BY release_date DESC LIMIT 5";
$latestMoviesResult = $conn->query($latestMoviesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReviewMate - Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .movie-card {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }
        .movie-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .movie-section {
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Welcome to ReviewMate</h2>

    <!-- Top Rated Movies Section -->
    <div class="movie-section">
        <h3>Top Rated Movies</h3>
        <div class="row">
            <?php while ($movie = $topRatedResult->fetch_assoc()): ?>
                <div class="col-md-3 movie-card">
                    <a href="movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                        <img src="<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-responsive">
                    </a>
                    <h4><?= htmlspecialchars($movie['title']) ?></h4>
                    <p>IMDb Rating: <?= htmlspecialchars($movie['imdb_rating']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Latest Movies Section -->
    <div class="movie-section">
        <h3>Latest Movies</h3>
        <div class="row">
            <?php while ($movie = $latestMoviesResult->fetch_assoc()): ?>
                <div class="col-md-3 movie-card">
                    <a href="movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                        <img src="<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-responsive">
                    </a>
                    <h4><?= htmlspecialchars($movie['title']) ?></h4>
                    <p>Release Date: <?= htmlspecialchars($movie['release_date']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include "footer.php"; // Include footer ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
