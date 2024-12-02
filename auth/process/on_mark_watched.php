
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

$stmt = $conn->prepare("SELECT * FROM movies_watched WHERE user_id = ? AND movie_id = ?");
$stmt->bind_param("ii", $user_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['error' => 'Movie is already marked as watched.']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO movies_watched (user_id, movie_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $movie_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Movie marked as watched.']);
} else {
    echo json_encode(['error' => 'Failed to mark movie as watched.']);
}

$stmt->close();
$conn->close();
?>
