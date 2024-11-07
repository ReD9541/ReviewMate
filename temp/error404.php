<!-- 404.php -->
<?php include '../includes/header.php'; ?>

<style>

        /* style.css */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 1rem;
        text-align: center;
    }

    header nav ul {
        list-style: none;
        padding: 0;
    }

    header nav ul li {
        display: inline;
        margin: 0 1rem;
    }

    header nav ul li a {
        color: #fff;
        text-decoration: none;
    }

    .error-404 {
        text-align: center;
        padding: 2rem;
    }

    .error-404 h2 {
        font-size: 2rem;
        color: #333;
    }

    .error-404 p {
        font-size: 1.2rem;
        color: #666;
    }

    .error-404 .btn {
        display: inline-block;
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        background-color: #333;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
    }
</style>
<main>
    <section class="error-404">
        <h2>404 - Page Not Found</h2>
        <p>Sorry, the page you are looking for does not exist. It might have been moved or deleted.</p>
        <a href="/" class="btn">Go Back to Home</a>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
