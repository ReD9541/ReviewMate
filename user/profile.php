<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/db_connect.php"; 
include "../includes/header.php"; 

if (!isset($_SESSION['user_id'])) {
    header("Location: /ReviewMate/auth/page/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt_user = $conn->prepare("
    SELECT u.fname, u.lname, u.pfp_url, u.country, u.address, u.bio, u.joined_on, l.username 
    FROM userinfo u
    JOIN userlogin l ON u.user_id = l.id 
    WHERE u.user_id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$userinfo = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

$query_watched = "
    SELECT m.movie_id, m.title, m.release_date, m.imdb_rating, m.poster_url
    FROM movie m
    JOIN movies_watched w ON m.movie_id = w.movie_id
    WHERE w.user_id = ?";
$stmt_watched = $conn->prepare($query_watched);
$stmt_watched->bind_param("i", $user_id);
$stmt_watched->execute();
$watched_movies = $stmt_watched->get_result();
$stmt_watched->close();

$query_reviewed = "
    SELECT m.movie_id, m.title, m.release_date, m.imdb_rating, m.poster_url, r.review_text
    FROM movie m
    JOIN reviews r ON m.movie_id = r.movie_id
    WHERE r.user_id = ?";
$stmt_reviewed = $conn->prepare($query_reviewed);
$stmt_reviewed->bind_param("i", $user_id);
$stmt_reviewed->execute();
$reviewed_movies = $stmt_reviewed->get_result();
$stmt_reviewed->close();

$query_watchlist = "
    SELECT m.movie_id, m.title, m.release_date, m.imdb_rating, m.poster_url
    FROM movie m
    JOIN watchlist w ON m.movie_id = w.movie_id
    WHERE w.user_id = ?";
$stmt_watchlist = $conn->prepare($query_watchlist);
$stmt_watchlist->bind_param("i", $user_id);
$stmt_watchlist->execute();
$watchlist_movies = $stmt_watchlist->get_result();
$stmt_watchlist->close();
?>

<main class="main-content">
    <div class="container-fluid">
        <?php if ($userinfo): ?>
            <div class="profile-wrapper d-flex align-items-center mb-5">
                <div class="profile-picture mr-4">
                    <img src="<?php echo htmlspecialchars($userinfo['pfp_url'] ? '/ReviewMate/' . $userinfo['pfp_url'] : '/ReviewMate/assets/images/profile_picture/default.png'); ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 120px; height: 120px;">
                </div>
                <div class="profile-details">
                    <h2><?php echo htmlspecialchars($userinfo['username']); ?></h2> 
                    <p><strong>Country:</strong> <?php echo htmlspecialchars($userinfo['country'] ?? 'Not available'); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($userinfo['address'] ?? 'Not available'); ?></p>
                    <p><strong>Bio:</strong> <?php echo htmlspecialchars($userinfo['bio'] ?? 'Not available'); ?></p>
                    <p><strong>Joined on:</strong> <?php echo htmlspecialchars($userinfo['joined_on'] ?? 'Not available'); ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>User information not found.</p>
        <?php endif; ?>

        <div class="movie-section my-5">
            <h3 class="mb-4">Movies Watched</h3>
            <div class="row">
                <?php while ($movie = $watched_movies->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                        <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                            <div class="poster-wrapper">
                                <img src="/ReviewMate/<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="img-fluid">
                            </div>
                        </a>
                        <h4 class="mt-2 text-center"><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p class="text-center">Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>
                        <p class="text-center">IMDb Rating: <?php echo htmlspecialchars($movie['imdb_rating']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="movie-section my-5">
            <h3 class="mb-4">Movies Reviewed</h3>
            <div class="row">
                <?php while ($movie = $reviewed_movies->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                        <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                            <div class="poster-wrapper">
                                <img src="/ReviewMate/<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="img-fluid">
                            </div>
                        </a>
                        <h4 class="mt-2 text-center"><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p class="text-center">Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>
                        <p class="text-center">IMDb Rating: <?php echo htmlspecialchars($movie['imdb_rating']); ?></p>
                        <p class="text-center">"<?php echo htmlspecialchars($movie['review_text']); ?>"</p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="movie-section my-5">
            <h3 class="mb-4">Watchlist</h3>
            <div class="row">
                <?php while ($movie = $watchlist_movies->fetch_assoc()): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 movie-card mb-4">
                        <a href="/ReviewMate/movie/movie_details.php?movie_id=<?= $movie['movie_id'] ?>">
                            <div class="poster-wrapper">
                                <img src="/ReviewMate/<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="img-fluid">
                            </div>
                        </a>
                        <h5 class="mt-2 text-center"><?php echo htmlspecialchars($movie['title']); ?></h5>
                        <p class="text-center">Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>
                        <p class="text-center">IMDb Rating: <?php echo htmlspecialchars($movie['imdb_rating']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</main>

<?php 
include "../includes/footer.php"; 
$conn->close();
?>

 