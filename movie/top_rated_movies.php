<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/header.php";
?>

<main data-page="top-rated-movies" class="main-content">
    <div class="container my-5">
        <h2 class="text-center mb-4">Top Rated Movies</h2>
        <div class="row" id="top-rated-movies-section"></div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script src="/assets/scripts/scripts.js"></script>