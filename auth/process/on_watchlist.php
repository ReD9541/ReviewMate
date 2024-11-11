<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /ReviewMate/auth/page/login.php");
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
        $check_watchlist_stmt = $conn->prepare("SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?");
        if ($check_watchlist_stmt === false) {
            die("Error preparing the check watchlist query: " . $conn->error);
        }

        $check_watchlist_stmt->bind_param("ii", $user_id, $movie_id);
        $check_watchlist_stmt->execute();
        $check_watchlist_result = $check_watchlist_stmt->get_result();

        if ($check_watchlist_result->num_rows > 0) {
            echo "<script>alert('The movie is already in your watchlist.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO watchlist (user_id, movie_id, added_date) VALUES (?, ?, CURRENT_TIMESTAMP)");
            if ($stmt === false) {
                die("Error preparing the insert query: " . $conn->error);
            }

            $stmt->bind_param("ii", $user_id, $movie_id);

            if ($stmt->execute()) {
                echo "<script>alert('The movie is has been added in your watchlist.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
            } else {
                echo "<script>alert('Error adding to watchlist.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
            }

            $stmt->close();
        }

        $check_watchlist_stmt->close();
    } else {
        echo "<script>alert('Invalid movie ID.');window.location.href='/ReviewMate/movie/movie_details.php?movie_id=" . $movie_id . "';</script>";
    }

    $check_movie_stmt->close();
} else {
    echo "<script>alert('Invalid movie ID.');window.location.href='/ReviewMate/movie/movie_details.php';</script>";
}

$conn->close();
?>
