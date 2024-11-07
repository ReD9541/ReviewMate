<?php
session_start();
include "../includes/db_connect.php"; 
include "../includes/header.php"; 

if (isset($_GET['movie_id']) && is_numeric($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];
    
    // Prepare and execute the SQL statement to fetch all movie details
    $stmt = $conn->prepare("SELECT title, release_date, genre, runtime, imdb_rating, user_rating, description, director, cast, language, country, poster_url, trailer_url, age_rating, budget, box_office FROM movies WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "<p>Movie not found.</p>";
        exit();
    }

    $stmt->close();
} else {
    echo "<p>Invalid movie ID.</p>";
    exit();
}
?>

<style>
/* Basic styling for card and content */
.container {
    display: flex;
    justify-content: center;
    margin: 20px auto;
    width: 80%;
}
.card {
    display: flex;
    flex-direction: column;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 100%;
    max-width: 800px;
}
.card img {
    max-width: 100%;
    border-radius: 8px;
}
.card-content {
    display: flex;
    flex-direction: column;
}
.movie-details {
    margin-top: 20px;
}
.movie-detail {
    margin: 10px 0;
}
.footer {
    background-color: #f1f1f1;
    padding: 10px;
    text-align: center;
    width: 100%;
    position: relative;
    bottom: 0;
}
iframe {
    width: 100%;
    height: 400px;
    border-radius: 8px;
    border: none;
    margin-top: 20px;
}
</style>

<div class="container main-content">
    <div class="card">
        <!-- Movie Poster -->
        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
        
        <!-- Card Content -->
        <div class="card-content">
            <h2><?php echo htmlspecialchars($movie['title']); ?></h2>
            
            <div class="movie-details">
                <p class="movie-detail"><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                <p class="movie-detail"><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                <p class="movie-detail"><strong>Runtime:</strong> <?php echo htmlspecialchars($movie['runtime']); ?> mins</p>
                <p class="movie-detail"><strong>IMDb Rating:</strong> <?php echo htmlspecialchars($movie['imdb_rating']); ?></p>
                <p class="movie-detail"><strong>User Rating:</strong> <?php echo htmlspecialchars($movie['user_rating']); ?></p>
                <p class="movie-detail"><strong>Age Rating:</strong> <?php echo htmlspecialchars($movie['age_rating']); ?></p>
                <p class="movie-detail"><strong>Budget:</strong> $<?php echo number_format($movie['budget']); ?></p>
                <p class="movie-detail"><strong>Box Office:</strong> $<?php echo number_format($movie['box_office']); ?></p>
                <p class="movie-detail"><strong>Description:</strong> <?php echo htmlspecialchars($movie['description']); ?></p>
                <p class="movie-detail"><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                <p class="movie-detail"><strong>Cast:</strong> <?php echo htmlspecialchars($movie['cast']); ?></p>
                <p class="movie-detail"><strong>Language:</strong> <?php echo htmlspecialchars($movie['language']); ?></p>
                <p class="movie-detail"><strong>Country:</strong> <?php echo htmlspecialchars($movie['country']); ?></p>
            </div>
            
            <!-- Movie Trailer -->
            <?php if (!empty($movie['trailer_url'])): ?>
                <iframe src="<?php echo htmlspecialchars($movie['trailer_url']); ?>" allowfullscreen></iframe>
            <?php else: ?>
                <p>No trailer available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
