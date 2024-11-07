<!-- 404.php -->
<?php include '../includes/header.php'; ?>

<style>
    html, body {
        font-family: Arial, sans-serif;
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
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

    .footer {
        background-color: #f1f1f1;
        padding: 10px;
        text-align: center;
        width: 100%;
        flex-shrink: 0; /* Prevents footer from shrinking */
    }
</style>

<main class="main-content">
    <section class="error-404">
        <h2>404 - Page Not Found</h2>
        <p>Sorry, the page you are looking for does not exist. It might have been moved or deleted.</p>
        <a href="../index.php" class="btn">Go Back to Home</a>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
