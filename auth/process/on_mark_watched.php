<?php
session_start();
include "../../includes/db_connect.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/page/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id']) && is_numeric($_POST['movie_id'])) {
    $movie_id = intval($conn->real_escape_string($_POST['movie_id']));
    $user_id = $_SESSION['user_id'];
    $check_movie_stmt = $conn->prepare("SELECT movie_id FROM movie WHERE movie_id = ?");
    if ($check_movie_stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $check_movie_stmt->bind_param("i", $movie_id);
    $check_movie_stmt->execute();
    $check_movie_result = $check_movie_stmt->get_result();

    if ($check_movie_result->num_rows > 0) {
        $check_watched_stmt = $conn->prepare("SELECT * FROM movies_watched WHERE user_id = ? AND movie_id = ?");
        if ($check_watched_stmt === false) {
            die("Error preparing the check watched query: " . $conn->error);
        }

        $check_watched_stmt->bind_param("ii", $user_id, $movie_id);
        $check_watched_stmt->execute();
        $check_watched_result = $check_watched_stmt->get_result();

        if ($check_watched_result->num_rows > 0) {
            echo "<script>alert('You\'ve already marked the movie as watched.');window.location.href='/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO movies_watched (user_id, movie_id, watch_date) VALUES (?, ?, CURRENT_TIMESTAMP)");
            if ($stmt === false) {
                die("Error preparing the insert query: " . $conn->error);
            }

            $stmt->bind_param("ii", $user_id, $movie_id);

            if ($stmt->execute()) {
                header("Location: /movie/movie_details.php?movie_id=" . $movie_id);
                exit();
            } else {
                echo "<script>alert('Error marking as watched.');window.location.href='/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
            }

            $stmt->close();
        }

        $check_watched_stmt->close();
    } else {
        echo "<script>alert('Invalid movie ID.');window.location.href='/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
    }

    $check_movie_stmt->close();
} else {
    echo "<script>alert('Invalid movie ID.');window.location.href='/movie/movie_details.php';</script>";
}

$conn->close();
?>
