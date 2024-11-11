<?php
session_start();
include "../../includes/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /ReviewMate/auth/page/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id']) && is_numeric($_POST['movie_id']) && isset($_POST['rating']) && isset($_POST['review_text'])) {
    $movie_id = intval($_POST['movie_id']);
    $user_id = $_SESSION['user_id'];
    $rating = intval($_POST['rating']);
    $review_text = $_POST['review_text'];

    $check_movie_stmt = $conn->prepare("SELECT movie_id FROM movie WHERE movie_id = ?");
    $check_movie_stmt->bind_param("i", $movie_id);
    $check_movie_stmt->execute();
    $check_movie_result = $check_movie_stmt->get_result();

    if ($check_movie_result->num_rows > 0) {
        $check_review_stmt = $conn->prepare("SELECT * FROM reviews WHERE user_id = ? AND movie_id = ?");
        $check_review_stmt->bind_param("ii", $user_id, $movie_id);
        $check_review_stmt->execute();
        $check_review_result = $check_review_stmt->get_result();

        if ($check_review_result->num_rows > 0) {
            echo "<script>alert('You\'ve already reviewed this movie.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO reviews (user_id, movie_id, rating, review_text, review_date) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
            $stmt->bind_param("iiis", $user_id, $movie_id, $rating, $review_text);

            if ($stmt->execute()) {
                echo "<script>alert('Your review has been added.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
            } else {
                echo "<script>alert('Error adding review.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
            }

            $stmt->close();
        }

        $check_review_stmt->close();
    } else {
        echo "<script>alert('Invalid movie ID.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
    }

    $check_movie_stmt->close();
} else {
    echo "<script>alert('Invalid movie ID.');window.location.href='/ReviewMate/movie/movie_details.php';</script>";
}

$conn->close();

