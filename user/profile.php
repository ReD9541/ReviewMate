<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/page/login.php");
    exit();
}

include "../includes/db_connect.php";
include "../includes/header.php";
?>

<main data-page="profile" class="main-content">
    <div class="container-fluid">
        <div id="profile-section" class="profile-wrapper d-flex align-items-center mb-5"></div>

        <div id="watched-section" class="movie-section my-5">
            <h3 class="mb-4">Movies Watched</h3>
            <div class="row g-4" id="watched-movies"></div>
        </div>

        <div id="reviewed-section" class="movie-section my-5">
            <h3 class="mb-4">Movies Reviewed</h3>
            <div class="row g-4" id="reviewed-movies"></div>
        </div>

        <div id="watchlist-section" class="movie-section my-5">
            <h3 class="mb-4">Watchlist</h3>
            <div class="row g-4 " id="watchlist-movies"></div>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>

<script src="/assets/scripts/scripts.js"></script>
