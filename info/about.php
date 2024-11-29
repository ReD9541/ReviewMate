<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/header.php"; 
?>

<main class="main-content">
    <div class="container my-5">
        <h2 class="text-center mb-4">About ReviewMate</h2>

        <div class="row">
            <div class="my-5 text-center">
                <h4 class="mb-3">What is ReviewMate?</h4>
                <p>
                    ReviewMate is a platform designed for movie enthusiasts, critics, and casual viewers alike. 
                    It allows you to browse an extensive collection of movies, TV shows, documentaries, music albums, and more. 
                    Whether you want to find your next favorite film, leave a review, or explore reviews from others, ReviewMate is the place to be.
                </p>
                <p>
                    Our goal is to foster a community of like-minded individuals who love to share their opinions on all things related to entertainment. 
                    From blockbuster hits to hidden gems, you can rate, review, and discover movies that suit your taste.
                </p>
            </div>
        </div>
    
        <div class="my-5 text-center">
            <h4 class="mb-3">Our Mission</h4>
            <p>
                At ReviewMate, we aim to connect movie lovers around the world by providing an easy-to-use platform where people can 
                share their movie experiences. We believe that the best recommendations come from fellow moviegoers, and we want to 
                make that process as smooth and fun as possible. Join our community and start sharing your reviews and ratings today!
            </p>
        </div>

        <div class="text-center my-5">
            <h4>Ready to Join?</h4>
            <p>
                Sign up now to start reviewing and discovering movies you love. Explore our collection, create your profile, and get involved in our growing community!
            </p>
            <a href="/auth/page/register.php" class="btn btn-primary btn-lg">Join ReviewMate</a>
        </div>
    </div>
</main>

<?php
include "../includes/footer.php"; 
?>
