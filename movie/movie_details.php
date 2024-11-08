<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/db_connect.php"; 
include "../includes/header.php"; 

if (isset($_GET['movie_id']) && is_numeric($_GET['movie_id'])) {
    $movie_id = intval($_GET['movie_id']);

    $stmt = $conn->prepare("SELECT title, release_date, genre, runtime, imdb_rating, user_rating, description, director, cast, language, country, poster_url, trailer_url, age_rating, budget, box_office FROM movie WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $movie = $result->fetch_assoc();
        } else {
            echo "<p>Movie not found.</p>";
            include "../includes/footer.php";
            exit();
        }
    } else {
        echo "<p>Error executing query: " . $stmt->error . "</p>";
        include "../includes/footer.php";
        exit();
    }

    $stmt->close();
} else {
    echo "<p>Invalid movie ID.</p>";
    include "../includes/footer.php";
    exit();
}
?>

<main class="main-content">
    <div class="container my-5">
        <div class="card mb-5">
            <div class="row no-gutters">
                <!-- Movie Poster -->
                <div class="col-md-4">
                    <div class="poster-wrapper">
                    <img src="/ReviewMate/<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster" class="img-fluid rounded">
                    </div>
                </div>

                <!-- Card Content -->
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h2>

                        <div class="movie-details">
                            <p class="movie-detail"><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                            <p class="movie-detail"><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                            <p class="movie-detail"><strong>Runtime:</strong> <?php echo htmlspecialchars($movie['runtime']); ?> mins</p>
                            <p class="movie-detail"><strong>IMDb Rating:</strong> <?php echo htmlspecialchars($movie['imdb_rating']); ?></p>
                            <p class="movie-detail"><strong>User Rating:</strong> <?php echo htmlspecialchars($movie['user_rating']); ?></p>
                            <p class="movie-detail"><strong>Age Rating:</strong> <?php echo htmlspecialchars($movie['age_rating']); ?></p>
                            <p class="movie-detail"><strong>Budget:</strong> $<?php echo number_format($movie['budget']); ?></p>
                            <p class="movie-detail"><strong>Box Office:</strong> $<?php echo number_format($movie['box_office']); ?></p>
                            <p class="movie-detail"><strong>Description:</strong> <?php echo htmlspecialchars($movie['description']); ?></p>
                            <p class="movie-detail"><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                            <p class="movie-detail"><strong>Cast:</strong> <?php echo htmlspecialchars($movie['cast']); ?></p>
                            <p class="movie-detail"><strong>Language:</strong> <?php echo htmlspecialchars($movie['language']); ?></p>
                            <p class="movie-detail"><strong>Country:</strong> <?php echo htmlspecialchars($movie['country']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movie Trailer -->
            <?php if (!empty($movie['trailer_url'])): ?>
                <div class="mt-4">
                    <div class="video-wrapper">
                        <iframe src="<?php echo htmlspecialchars($movie['trailer_url']); ?>" allowfullscreen frameborder="0"></iframe>
                    </div>
                </div>
            <?php else: ?>
                <p class="mt-4">No trailer available.</p>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
