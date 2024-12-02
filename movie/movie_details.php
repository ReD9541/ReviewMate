<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/header.php";

$movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : null;

if (!$movie_id) {
    echo "<p>Invalid movie ID.</p>";
    include "../includes/footer.php";
    exit();
}
?>

<main data-page="movie-details" class="main-content">
    <div class="container my-2">
        <div id="movie-details" class="movie-details-wrapper"></div>
        <div class="mt-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex justify-content-center mb-4">
                    <button id="add-to-watchlist" class="btn btn-primary mx-2"
                        data-movie-id="<?php echo htmlspecialchars($movie_id); ?>">Add to Watchlist</button>
                    <button id="mark-watched" class="btn btn-success mx-2"
                        data-movie-id="<?php echo htmlspecialchars($movie_id); ?>">Mark as Watched</button>
                </div>

                <div class="p-4 border rounded shadow-sm mx-auto" style="max-width: 600px;">
                    <h3 class="text-center mb-4">Leave a Review</h3>
                    <form id="submit-review">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <label for="rating" class="form-label me-3">Rating:</label>
                            <input type="range" id="rating" name="rating" min="1" max="10" class="form-range w-100"
                                oninput="this.nextElementSibling.value = this.value">
                            <output class="ms-3">5</output>
                        </div>

                        <div class="form-group mb-4">
                            <textarea id="review_text" name="review_text" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-info px-4">Submit Review</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <p class="text-center">Please <a href="/auth/page/login.php">log in</a> to use these features.</p>
            <?php endif; ?>
        </div>


        <div id="reviews-section" class="reviews-section mt-5"></div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script src="/assets/scripts/scripts.js?v=1.0"></script>