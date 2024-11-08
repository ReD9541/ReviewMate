<?php
// movie_search.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/db_connect.php"; 
include "../includes/header.php"; 

// Default variables
$search_term = '';
$sort_by = 'title';
$order = 'ASC';
$movies = [];

$results_per_page = 12; 
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1; 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['search'])) {
        $search_term = trim($_GET['search']);
    }
    // Get sorting options
    if (isset($_GET['sort_by'])) {
        $valid_sort_columns = ['title', 'release_date', 'imdb_rating'];
        if (in_array($_GET['sort_by'], $valid_sort_columns)) {
            $sort_by = $_GET['sort_by'];
        }
    }
    if (isset($_GET['order']) && in_array($_GET['order'], ['ASC', 'DESC'])) {
        $order = $_GET['order'];
    }

    $search_param = '%' . $search_term . '%';

    $count_sql = "SELECT COUNT(*) FROM movie WHERE title LIKE ?";
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bind_param('s', $search_param);
    $count_stmt->execute();
    $count_stmt->bind_result($total_results);
    $count_stmt->fetch();
    $count_stmt->close();

    $total_pages = ceil($total_results / $results_per_page);

    if ($page < 1) {
        $page = 1;
    } elseif ($page > $total_pages && $total_pages > 0) {
        $page = $total_pages;
    }
    $offset = ($page - 1) * $results_per_page;

    $sql = "SELECT movie_id, title, release_date, imdb_rating, poster_url FROM movie WHERE title LIKE ? ORDER BY $sort_by $order LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $search_param, $results_per_page, $offset);

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
?>
<main class="main-content">
    <div class="container my-5">
        <h2 class="mb-4">Search Movies</h2>
        <!-- Search Form -->
        <form method="get" action="movie_search.php" class="form-inline mb-4">
            <input type="text" name="search" class="form-control mr-2" placeholder="Enter movie title" value="<?php echo htmlspecialchars($search_term); ?>" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Sorting Options -->
        <?php if (isset($total_results) && $total_results > 0): ?>
            <form method="get" action="movie_search.php" class="form-inline mb-4">
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_term); ?>">
                <input type="hidden" name="page" value="<?php echo $page; ?>">
                <label for="sort_by" class="mr-2">Sort by:</label>
                <select name="sort_by" id="sort_by" class="form-control mr-2">
                    <option value="title" <?php if ($sort_by == 'title') echo 'selected'; ?>>Title</option>
                    <option value="release_date" <?php if ($sort_by == 'release_date') echo 'selected'; ?>>Release Date</option>
                    <option value="imdb_rating" <?php if ($sort_by == 'imdb_rating') echo 'selected'; ?>>IMDb Rating</option>
                </select>
                <select name="order" class="form-control mr-2">
                    <option value="ASC" <?php if ($order == 'ASC') echo 'selected'; ?>>Ascending</option>
                    <option value="DESC" <?php if ($order == 'DESC') echo 'selected'; ?>>Descending</option>
                </select>
                <button type="submit" class="btn btn-secondary">Sort</button>
            </form>
        <?php endif; ?>

        <!-- Display Search Results -->
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

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li>
                                <a href="<?php echo build_pagination_url($page - 1); ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php
                        $max_links = 5;
                        $start = max($page - floor($max_links / 2), 1);
                        $end = min($start + $max_links - 1, $total_pages);
                        $start = max($end - $max_links + 1, 1);

                        for ($i = $start; $i <= $end; $i++): ?>
                            <li <?php if ($i == $page) echo 'class="active"'; ?>>
                                <a href="<?php echo build_pagination_url($i); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Page Link -->
                        <?php if ($page < $total_pages): ?>
                            <li>
                                <a href="<?php echo build_pagination_url($page + 1); ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>

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

function build_pagination_url($page) {
    $params = $_GET;
    $params['page'] = $page;
    return 'movie_search.php?' . http_build_query($params);
}
?>
