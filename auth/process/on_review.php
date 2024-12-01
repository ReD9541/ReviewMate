<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not authenticated."]);
    exit();
}

include "../../includes/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'], $_POST['rating'], $_POST['review_text']) && is_numeric($_POST['movie_id']) && is_numeric($_POST['rating'])) {
    $user_id = $_SESSION['user_id'];
    $movie_id = intval($_POST['movie_id']);
    $rating = intval($_POST['rating']);
    $review_text = $conn->real_escape_string($_POST['review_text']);

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
    http_response_code(400);
    echo json_encode(["error" => "Invalid request."]);
}
?>
