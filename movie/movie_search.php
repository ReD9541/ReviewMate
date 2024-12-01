<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/header.php";
?>

<main data-page="movie-search" class="main-content">
    <div class="container my-5">
        <h2 class="mb-4">Search Movies</h2>
        <form id="search-form" class="form-inline mb-4">
            <input type="text" id="search-term" name="search" class="form-control mr-2" placeholder="Enter movie title"
                required>
            <button type="submit" class="btn btn-primary ml-3 my-2"
                style="padding: 10px 20px; margin: 10px;">Search</button>
        </form>

        <div id="search-results" class="row"></div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
<script src="/assets/scripts/scripts.js"></script>