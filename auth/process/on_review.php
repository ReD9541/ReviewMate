<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized. Please log in."]);
    exit();
}

include "../../includes/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : (isset($_POST['movie_id']) ? intval($_POST['movie_id']) : null);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $review_text = isset($_POST['review_text']) ? $conn->real_escape_string($_POST['review_text']) : null;

    if (!$movie_id || $movie_id <= 0) {
        echo json_encode(["error" => "Invalid or missing movie_id."]);
        exit();
    }
    
    if (!$movie_id || !$rating || !$review_text) {
        echo json_encode(["error" => "Invalid input. All fields are required."]);
        exit();
    }

    $check_movie_stmt = $conn->prepare("SELECT movie_id FROM movie WHERE movie_id = ?");
    $check_movie_stmt->bind_param("i", $movie_id);
    $check_movie_stmt->execute();
    $check_movie_result = $check_movie_stmt->get_result();

    if ($check_movie_result->num_rows === 0) {
        echo json_encode(["error" => "Invalid movie ID."]);
        exit();
    }

    $check_movie_stmt->close();

    $check_review_stmt = $conn->prepare("SELECT * FROM reviews WHERE user_id = ? AND movie_id = ?");
    $check_review_stmt->bind_param("ii", $user_id, $movie_id);
    $check_review_stmt->execute();
    $check_review_result = $check_review_stmt->get_result();

    if ($check_review_result->num_rows > 0) {
        echo json_encode(["error" => "You have already reviewed this movie."]);
        exit();
    }

    $check_review_stmt->close();
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, movie_id, rating, review_text, review_date) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
    $stmt->bind_param("iiis", $user_id, $movie_id, $rating, $review_text);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Your review has been added."]);
    } else {
        echo json_encode(["error" => "Error adding review."]);
    }

    $stmt->close();
    $conn->close();

} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
