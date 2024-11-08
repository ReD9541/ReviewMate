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
    <link rel="stylesheet" href="/ReviewMate/assets/styles/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Logo and link to homepage -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/ReviewMate/index.php">
                    <img src="/ReviewMate/assets/images/logo/logo.png" alt="ReviewMate Logo">
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Search Button -->
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'movie_search.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="/ReviewMate/movie/movie_search.php">
                            <i class="fa fa-search"></i> Search
                        </a>
                    </li>
                    <?php if (isset($_SESSION['id'])): ?>
                        <!-- Profile Link -->
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="/ReviewMate/user/profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ReviewMate/auth/process/logout.php">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="/ReviewMate/auth/page/login.php">
                                <i class="fa fa-sign-in"></i> Login
                            </a>
                        </li>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="/ReviewMate/auth/page/register.php">
                                <i class="fa fa-user-plus"></i> Sign Up
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </nav>
