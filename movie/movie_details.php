<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/header.php";
?>

<main data-page="movie-details" class="main-content">
    <div class="container my-5">
        <div id="movie-details" class="movie-details-wrapper"></div>
        <div class="mt-4 text-center">
            <button id="add-to-watchlist" style="margin:10px;" class="btn btn-primary mx-2"
                data-movie-id="<?php echo htmlspecialchars($movie_id); ?>">Add to Watchlist</button>

            <div class="mt-3">
                <h3 class="text-center">Leave a Review</h3>
                <form id="submit-review" style="margin:10px;" class="p-4 border rounded shadow-sm">
                    <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">
                    <div class="form-group mb-4">
                        <label for="rating" class="form-label">Rating:</label>
                        <input type="range" id="rating" name="rating" min="1" max="10" class="form-control-range w-100"
                            oninput="this.nextElementSibling.value = this.value">
                        <output>5</output>
                    </div>
                    <div class="form-group mb-4">
                        <label for="review_text" class="form-label">Review:</label>
                        <textarea id="review_text" name="review_text" class="form-control" rows="4" required></textarea>
                    </div>
                    <button style="margin:10px;" type="submit" class="btn btn-info">Submit Review</button>
                </form>
            </div>

            <button id="mark-watched" class="btn btn-success mx-2"
                data-movie-id="<?php echo htmlspecialchars($movie_id); ?>">Mark Watched</button>
        </div>

        <div id="reviews-section" class="reviews-section mt-5"></div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script src="/assets/scripts/scripts.js"></script>