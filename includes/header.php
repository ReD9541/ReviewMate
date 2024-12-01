<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReviewMate</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/styles/style.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/index.php">
                    <img src="/assets/images/logo/logo.png" alt="ReviewMate Logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'movie_search.php' ? 'active' : ''; ?>">
                        <form class="navbar-form navbar-left" method="GET" action="/movie/movie_search.php">
                            <div class="form-group">
                                <input type="text" class="form-control" name="search" placeholder="Search Movies" aria-label="Search" 
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            </div>
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </form>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="/user/profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth/process/logout.php">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="/auth/page/login.php">
                                <i class="fa fa-sign-in"></i> Login
                            </a>
                        </li>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="/auth/page/register.php">
                                <i class="fa fa-user-plus"></i> Sign Up
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
