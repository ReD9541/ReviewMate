<?php include '../../includes/header.php'; ?>

<style>

.form-container {
  max-width: 400px; 
  width: 100%;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}

</style>

<div class="container main-content">
    <div class="form-container">
        <h2>Login</h2>
        <form action="/reviewmate/auth/process/login_process.php" method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
