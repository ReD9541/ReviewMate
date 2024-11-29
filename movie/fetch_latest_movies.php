<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db_connect.php";

$latestMoviesQuery = "SELECT movie_id, title, release_date, poster_url FROM movie ORDER BY release_date DESC";
$result = $conn->query($latestMoviesQuery);

$movies = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($movies);

$conn->close();
?>
