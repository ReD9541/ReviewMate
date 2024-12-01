<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/header.php";
?>
<main data-page="top-rated-movies" class="main-content">
    <div class="container-fluid">
        <div class="movie-section my-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Top Rated Movies</h2>
            </div>
            <div class="row g-4 " id="top-rated-movies-section">
            </div>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script src="/assets/scripts/scripts.js"></script>