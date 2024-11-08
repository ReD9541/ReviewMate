<?php include_once '../../includes/header.php'; ?>

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
|
<div class="container main-content">
    <div class="form-container">
        <h2 class="text-center">Register</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <form action="/ReviewMate/auth/process/register_process.php" method="POST">

            <div class="form-group">
                <label for="fname">First Name<span style="color:red;"> *</span>:</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
            </div>

            <div class="form-group">
                <label for="lname">Last Name<span style="color:red;"> *</span>:</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
            
            <div class="form-group">
                <label for="username">Username<span style="color:red;"> *</span>:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email<span style="color:red;"> *</span>:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password<span style="color:red;"> *</span>:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" class="form-control" id="country" name="country">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio" rows="5"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </div>
</div>

<?php include_once '../../includes/footer.php'; ?>
