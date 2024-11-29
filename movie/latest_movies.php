<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/header.php";
?>

<main data-page="latest-movies" class="main-content">
    <div class="container my-5">
        <h2 class="text-center mb-4">Latest Movies</h2>
        <div class="row" id="latest-movies-section"></div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script src="/assets/scripts/scripts.js"></script>
