<?php
include "../includes/header.php";
include "../includes/db_connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user profile information
$stmt_user = $conn->prepare("SELECT fname, lname, pfp_url FROM userinfo WHERE user_id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$userinfo = $stmt_user->get_result()->fetch_assoc();

// Fetch movies watched
$query_watched = "
    SELECT m.movie_id, m.title, m.poster_url
    FROM movies m
    JOIN movies_watched w ON m.movie_id = w.movie_id
    WHERE w.user_id = ?";
$stmt_watched = $conn->prepare($query_watched);
$stmt_watched->bind_param("i", $user_id);
$stmt_watched->execute();
$watched_movies = $stmt_watched->get_result();

// Fetch reviewed movies from the `reviews` table
$query_reviewed = "
    SELECT m.movie_id, m.title, m.poster_url, r.review
    FROM movies m
    JOIN reviews r ON m.movie_id = r.movie_id
    WHERE r.user_id = ?";
$stmt_reviewed = $conn->prepare($query_reviewed);
$stmt_reviewed->bind_param("i", $user_id);
$stmt_reviewed->execute();
$reviewed_movies = $stmt_reviewed->get_result();

// Fetch watchlist
$query_watchlist = "
    SELECT m.movie_id, m.title, m.poster_url
    FROM movies m
    JOIN watchlist w ON m.movie_id = w.movie_id
    WHERE w.user_id = ?";
$stmt_watchlist = $conn->prepare($query_watchlist);
$stmt_watchlist->bind_param("i", $user_id);
$stmt_watchlist->execute();
$watchlist_movies = $stmt_watchlist->get_result();
?>

<div class="container">
    <!-- Profile Header -->
    <div class="profile-header text-center">
        <img src="<?php echo $userinfo['pfp_url'] ?: '/assets/images/default_profile.png'; ?>" class="img-circle" alt="Profile Picture" width="150" height="150">
        <h2><?php echo htmlspecialchars($userinfo['fname'] . ' ' . $userinfo['lname']); ?></h2>
    </div>

    <!-- Movies Watched Section -->
    <h3>Movies Watched</h3>
    <div class="row">
        <?php while ($movie = $watched_movies->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="<?php echo $movie['poster_url']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="card-img-top img-thumbnail">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Movies Reviewed Section -->
    <h3>Movies Reviewed</h3>
    <div class="row">
        <?php while ($movie = $reviewed_movies->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="<?php echo $movie['poster_url']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="card-img-top img-thumbnail">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($movie['review']); ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Watchlist Section -->
    <h3>Watchlist</h3>
    <div class="row">
        <?php while ($movie = $watchlist_movies->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="<?php echo $movie['poster_url']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="card-img-top img-thumbnail">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
