<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not authenticated."]);
    exit();
}

include "../../includes/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : null;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $review_text = isset($_POST['review_text']) ? $conn->real_escape_string($_POST['review_text']) : null;

    if (!$movie_id || !$rating || !$review_text) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid input. All fields are required."]);
        exit();
    }

    $check_stmt = $conn->prepare("SELECT id FROM reviews WHERE user_id = ? AND movie_id = ?");
    $check_stmt->bind_param("ii", $user_id, $movie_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        http_response_code(409);
        echo json_encode(["error" => "You have already reviewed this movie."]);
        error_log("User {$user_id} attempted to review movie {$movie_id} again.");
        $check_stmt->close();
        $conn->close();
        exit();
    }

    $check_stmt->close();

    $stmt = $conn->prepare("INSERT INTO reviews (user_id, movie_id, rating, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $movie_id, $rating, $review_text);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Review submitted."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to submit review."]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
