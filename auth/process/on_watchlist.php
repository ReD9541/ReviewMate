<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized. Please log in.']);
    exit();
}

include "../../includes/db_connect.php";

$user_id = $_SESSION['user_id'];
$movie_id = intval($_POST['movie_id']);

$stmt = $conn->prepare("SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?");
$stmt->bind_param("ii", $user_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['error' => 'Movie is already in your watchlist.']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $movie_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Movie added to watchlist.']);
} else {
    echo json_encode(['error' => 'Failed to add movie to watchlist.']);
}

$stmt->close();
$conn->close();
