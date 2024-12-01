<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_term = trim($_GET['search']);

    if ($search_term != '') {
        $search_param = '%' . $search_term . '%';
        $sql = "SELECT movie_id, title, release_date, imdb_rating, poster_url FROM movie WHERE title LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $search_param);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $movies = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($movies);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error executing query: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode([]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
}

$conn->close();
?>