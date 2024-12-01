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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id']) && is_numeric($_POST['movie_id'])) {
    $user_id = $_SESSION['user_id'];
    $movie_id = intval($_POST['movie_id']);

    $stmt = $conn->prepare("INSERT INTO movies_watched (user_id, movie_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $movie_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Movie marked as watched."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to mark movie as watched."]);
    }
    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request."]);
}
?>
