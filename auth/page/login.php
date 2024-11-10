<?php include '../../includes/header.php'; ?>

<div class="container main-content">
    <div class="form-container">
        <h2>Login</h2>
        <form action="/reviewmate/auth/process/login_process.php" method="POST">
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
</div>

<?php include '../../includes/footer.php'; ?>
