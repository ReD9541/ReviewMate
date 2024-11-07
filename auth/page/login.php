<?php include '../../includes/header.php'; ?>

<style>
html, body {
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

.form-container {
  max-width: 400px; 
  width: 100%;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.footer {
  background-color: #f1f1f1;
  padding: 10px;
  text-align: center;
  width: 100%;
  position: relative;
  bottom: 0;
}
</style>

<div class="container main-content">
    <div class="form-container">
        <h2>Login</h2>
        <form action="process.php" method="POST">
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
