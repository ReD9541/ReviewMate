<?php
include_once '../../includes/header.php';
?>

<main class="flex-fill">
    <div class="container mt-5">
        <h2 class="mb-4">Register</h2>

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
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username<span style="color:red;"> *</span>:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email<span style="color:red;"> *</span>:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password<span style="color:red;"> *</span>:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- First Name -->
            <div class="form-group">
                <label for="fname">First Name<span style="color:red;"> *</span>:</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="lname">Last Name<span style="color:red;"> *</span>:</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>

            <!-- Country (Optional) -->
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" class="form-control" id="country" name="country">
            </div>

            <!-- Address (Optional) -->
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
            </div>

            <!-- Bio (Optional) -->
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio" rows="5"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</main>

<?php
include_once '../../includes/footer.php';
?>
