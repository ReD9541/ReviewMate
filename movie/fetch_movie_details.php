<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db_connect.php";

$response = [];

if (isset($_GET['movie_id']) && is_numeric($_GET['movie_id'])) {
    $movie_id = intval($_GET['movie_id']);

    $stmt = $conn->prepare("SELECT title, release_date, genre, runtime, imdb_rating, user_rating, description, director, cast, language, country, poster_url, trailer_url, age_rating, budget, box_office FROM movie WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['movie'] = $result->fetch_assoc();
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Movie not found."]);
        exit();
    }
    $stmt->close();

    $review_stmt = $conn->prepare("
        SELECT reviews.user_id, userlogin.username, reviews.rating, reviews.review_text 
        FROM reviews 
        INNER JOIN userlogin ON reviews.user_id = userlogin.id 
        WHERE reviews.movie_id = ?
    ");
    $review_stmt->bind_param("i", $movie_id);
    $review_stmt->execute();
    $response['reviews'] = $review_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $review_stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid movie ID."]);
    exit();
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>