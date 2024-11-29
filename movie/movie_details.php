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

$review_stmt = $conn->prepare("
    SELECT reviews.user_id, userlogin.username, reviews.rating, reviews.review_text 
    FROM reviews 
    INNER JOIN userlogin ON reviews.user_id = userlogin.id 
    WHERE reviews.movie_id = ?
");
$review_stmt->bind_param("i", $movie_id);
$reviews = [];

if ($review_stmt->execute()) {
    $review_result = $review_stmt->get_result();
    if ($review_result->num_rows > 0) {
        while ($review = $review_result->fetch_assoc()) {
            $reviews[] = $review;
        }
    }
} else {
    echo "<p>Error fetching reviews: " . $review_stmt->error . "</p>";
}

$review_stmt->close();
?>

<main class="main-content">
    <div class="container my-5">
        <div class="card mb-5 movie-card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <div class="poster-wrapper">
                        <img src="/<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster" class="img-fluid rounded">
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
                <div class="mt-4 trailer-section">
                    <div class="video-wrapper">
                        <iframe src="<?php echo htmlspecialchars($movie['trailer_url']); ?>" allowfullscreen frameborder="0"></iframe>
                    </div>
                </div>
            <?php else: ?>
                <p class="mt-4 trailer-section">No trailer available.</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="mt-4 text-center">
                    <form action="/auth/process/on_watchlist.php" method="post" class="inline-form d-inline-block">
                        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">
                        <button type="submit" class="btn btn-primary mx-2">Add to Watchlist</button>
                    </form>

                    <div class="mt-3">
                        <h3 class="text-center">Leave a Review</h3>
                        <form action="/auth/process/on_review.php" method="post" class="p-4 border rounded shadow-sm">
                            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">

                            <div class="form-group mb-4">
                                <label for="rating" class="form-label">Rating:</label>
                                <input type="range" id="rating" name="rating" min="1" max="10" class="form-control-range w-100" oninput="this.nextElementSibling.value = this.value">
                                <output>5</output>
                            </div>

                            <div class="form-group mb-4">
                                <label for="review_text" class="form-label">Review:</label>
                                <textarea id="review_text" name="review_text" class="form-control" rows="4" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-info">Submit Review</button>
                        </form>
                    </div>

                    <form action="/auth/process/on_mark_watched.php" method="post" class="inline-form d-inline-block">
                        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">
                        <button type="submit" class="btn btn-success mx-2">Mark Watched</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="mt-4 text-center">
                    <a href="/auth/page/login.php" class="btn btn-primary">Sign in to Review</a>
                </div>
            <?php endif; ?>

            <div class="mt-5">
                <h2 class="text-center mb-4">User Reviews</h2>
                <?php if (!empty($reviews)): ?>
                    <div class="row">
                        <?php foreach ($reviews as $review): ?>
                            <div class="col-12 mb-3">
                                <div class="card h-100 shadow-sm p-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary"><?php echo htmlspecialchars($review['username']); ?></h5>
                                        <p class="card-text"><strong>Rating:</strong> <?php echo htmlspecialchars($review['rating']); ?>/10</p>
                                        <p class="card-text"><strong>Review:</strong> <?php echo nl2br(htmlspecialchars($review['review_text'], ENT_QUOTES, 'UTF-8')); ?></p>
                                        </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">No reviews yet. Be the first to review this movie!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
