<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db_connect.php";

$latestMoviesQuery = "SELECT movie_id, title, release_date, poster_url, imdb_rating FROM movie ORDER BY release_date DESC LIMIT 10";
$result = $conn->query($latestMoviesQuery);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Database query failed: " . $conn->error]);
    exit;
}

$movies = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($movies);

$conn->close();
?>
