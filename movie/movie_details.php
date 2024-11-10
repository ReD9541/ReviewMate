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
        <div class="card mb-5 movie-card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <div class="poster-wrapper">
                        <img src="/ReviewMate/<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster" class="img-fluid rounded">
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h1 class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></h1>
                        <div class="movie-details">
                            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                            <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                            <p><strong>Runtime:</strong> <?php echo htmlspecialchars($movie['runtime']); ?> mins</p>
                            <p><strong>IMDb Rating:</strong> <?php echo htmlspecialchars($movie['imdb_rating']); ?></p>
                            <p><strong>User Rating:</strong> <?php echo htmlspecialchars($movie['user_rating']); ?></p>
                            <p><strong>Age Rating:</strong> <?php echo htmlspecialchars($movie['age_rating']); ?></p>
                            <p><strong>Budget:</strong> $<?php echo number_format($movie['budget']); ?></p>
                            <p><strong>Box Office:</strong> $<?php echo number_format($movie['box_office']); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($movie['description']); ?></p>
                            <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                            <p><strong>Cast:</strong> <?php echo htmlspecialchars($movie['cast']); ?></p>
                            <p><strong>Language:</strong> <?php echo htmlspecialchars($movie['language']); ?></p>
                            <p><strong>Country:</strong> <?php echo htmlspecialchars($movie['country']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

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
