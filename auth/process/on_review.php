<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized. Please log in."]);
    exit();
}

include "../../includes/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : null;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $review_text = isset($_POST['review_text']) ? $conn->real_escape_string($_POST['review_text']) : null;

    $stmt = $conn->prepare("SELECT * FROM reviews WHERE user_id = ? AND movie_id = ?");
$stmt->bind_param("ii", $user_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['error' => 'You have already reviewed this movie.']);
    exit();
}

// Insert the review into the database
$stmt = $conn->prepare("INSERT INTO reviews (user_id, movie_id, rating, review_text) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiis", $user_id, $movie_id, $rating, $review_text);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Review submitted successfully.']);
} else {
    echo json_encode(['error' => 'Failed to submit review.']);
}

$stmt->close();
$conn->close();

} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
