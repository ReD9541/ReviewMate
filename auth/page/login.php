<?php
include '../../includes/header.php';
?>

<div class="container main-content">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="alert alert-warning text-center">
            You're logged in, log out first to log in again.
        </div>
    <?php else: ?>
        <div class="form-container">
            <h2>Login</h2>
            <form action="/auth/process/login_process.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php
include '../../includes/footer.php';
?>
