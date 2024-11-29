<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Prepare the response array
$response = [];

// Fetch user info
$stmt_user = $conn->prepare("
    SELECT u.fname, u.lname, u.pfp_url, u.country, u.address, u.bio, u.joined_on, l.username 
    FROM userinfo u
    JOIN userlogin l ON u.user_id = l.id 
    WHERE u.user_id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$response['userinfo'] = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

// Fetch watched movies
$stmt_watched = $conn->prepare("
    SELECT m.movie_id, m.title, m.release_date, m.imdb_rating, m.poster_url
    FROM movie m
    JOIN movies_watched w ON m.movie_id = w.movie_id
    WHERE w.user_id = ?");
$stmt_watched->bind_param("i", $user_id);
$stmt_watched->execute();
$response['watched_movies'] = $stmt_watched->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_watched->close();

// Fetch reviewed movies
$stmt_reviewed = $conn->prepare("
    SELECT m.movie_id, m.title, m.release_date, m.imdb_rating, m.poster_url, r.review_text
    FROM movie m
    JOIN reviews r ON m.movie_id = r.movie_id
    WHERE r.user_id = ?");
$stmt_reviewed->bind_param("i", $user_id);
$stmt_reviewed->execute();
$response['reviewed_movies'] = $stmt_reviewed->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_reviewed->close();

// Fetch watchlist movies
$stmt_watchlist = $conn->prepare("
    SELECT m.movie_id, m.title, m.release_date, m.imdb_rating, m.poster_url
    FROM movie m
    JOIN watchlist w ON m.movie_id = w.movie_id
    WHERE w.user_id = ?");
$stmt_watchlist->bind_param("i", $user_id);
$stmt_watchlist->execute();
$response['watchlist_movies'] = $stmt_watchlist->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_watchlist->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>