<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/db_connect.php"; 
include "../includes/header.php"; 

$search_term = '';
$movies = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['search'])) {
        $search_term = trim($_GET['search']);
    }

    if ($search_term != '') {
        $search_param = '%' . $search_term . '%';
        $sql = "SELECT movie_id, title, release_date, imdb_rating, poster_url FROM movie WHERE title LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $search_param);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($movie = $result->fetch_assoc()) {
                $movies[] = $movie;
            }
        } else {
            echo "<p>Error executing query: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}
?>

<main class="main-content">
    <div class="container my-5">
        <h2 class="mb-4">Search Movies</h2>
        <form method="get" action="movie_search.php" class="form-inline mb-4">
            <input type="text" name="search" class="form-control mr-2" placeholder="Enter movie title" value="<?php echo htmlspecialchars($search_term); ?>" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php if (!empty($movies)): ?>
            <div class="row">
                <?php foreach ($movies as $movie): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 movie-card mb-4">
                        <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                            <div class="poster-wrapper">
                                <img src="/ReviewMate/<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="img-fluid">
                            </div>
                        </a>
                        <h5 class="mt-2 text-center"><?= htmlspecialchars($movie['title']) ?></h5>
                        <p class="text-center">
                            Release Date: <?= htmlspecialchars($movie['release_date']) ?><br>
                            IMDb Rating: <?= htmlspecialchars($movie['imdb_rating']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($search_term != ''): ?>
            <p>No movies found matching your search criteria.</p>
        <?php else: ?>
            <p>Please enter a movie title to search.</p>
        <?php endif; ?>
    </div>
</main>

<?php
include "../includes/footer.php";
$conn->close();
?>
